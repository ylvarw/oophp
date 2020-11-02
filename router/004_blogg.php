<?php
/**
 * Create routes using $app programming style.
 */
include("autoloader.php");

$sql = null;
$resultset = null;


/**
* Showing startpage with all content
 */
$app->router->get("blogg/start", function () use ($app) {
    $title = "dbBlogg";

    $app->db->connect();
    
    $sql = "SELECT * FROM content;";
    $res = $app->db->executeFetchAll($sql);

    $app->page->add("bloggpage/startpage", [
        "resultset" => $res,
        "testVar" => "Test",
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
* Showing admin page for database CRUD.
* update / delete page or bloggpost
 */
$app->router->post("blogg/admin", function () use ($app) {
    $title = "dbBlogg";

    $contentTitle = $_POST["contentTitle"] ?? null;
    $contentPath = $_POST["contentPath"] ?? null;
    $contentSlug = $_POST["contentSlug"] ?? null;
    $contentData = $_POST["contentData"] ?? null;
    $contentType = $_POST["contentType"] ?? null;
    $contentFilter = $_POST["contentFilter"] ?? null;
    $contentPublish = $_POST["contentPublish"] ?? null;
    $contentId = $_POST["contentId"] ?? null;

    $doEdit = $_POST["doEdit"] ?? null;
    $doSave = $_POST["doSave"] ?? null;
    $askDelete = $_POST["askDelete"] ?? null;
    $doDelete = $_POST["doDelete"] ?? null;
    
    $params = [$contentTitle, $contentPath, $contentSlug, $contentData, $contentType, $contentFilter, $contentFilter, $contentId];


    $app->db->connect();
    
    $sql = "SELECT * FROM content;";
    $res = $app->db->executeFetchAll($sql);

    // get content from id to edit
    if ($doEdit) {
        $editSql = "SELECT * FROM content WHERE id = ?;";
        $editRes = $app->db->execute($editSql, $doEdit);
        $_SESSION["editRes"] = $editRes;
    }

    // get content from id to delete
    if ($askDelete) {
        $editSql = "SELECT * FROM content WHERE id = ?;";
        $askdeleteRes = $app->db->execute($editSql, $doEdit);
        $_SESSION["deleteRes"] = $askdeleteRes;
    }


    // delete by id
    if ($doDelete) {
        $deleteSql = "UPDATE content SET deleted=NOW() WHERE id=?;";
        $app->db->execute($deleteSql, $doDelete);
    }

    // $updateSql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
    // $app->db->execute($updateSql, array_values($params));

    // $_SESSION["editRes"] = $editRes;
    // $_SESSION["deleteRes"] = $askdeleteRes;

    return $app->response->redirect("blogg/admin");
});

/**
* Showing admin page for database CRUD.
* update / delete page or bloggpost
 */
$app->router->get("blogg/admin", function () use ($app) {
    $title = "dbBlogg";


    $app->db->connect();
    
    $sql = "SELECT * FROM content;";
    $res = $app->db->executeFetchAll($sql);

    $editRes = $_SESSION["editRes"];
    $askdeleteRes = $_SESSION["deleteRes"];

    $data = [
        "resultset" => $res ?? null,
        "editRes" => $editRes ?? null,
        "deleteRes" => $askdeleteRes ?? null,
        "askDelete" => $askDelete ?? null,
    ];

    $app->page->add("bloggpage/admin", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
* create new page/bloggpost.
 */
$app->router->get("blogg/create", function () use ($app) {
    $title = "dbBlogg";
    
    $contentTitle = $_POST["contentTitle"] ?? null;
    $contentPath = $_POST["contentPath"] ?? null;
    $contentSlug = $_POST["contentSlug"] ?? null;
    $contentData = $_POST["contentData"] ?? null;
    $contentType = $_POST["contentType"] ?? null;
    $contentFilter = $_POST["contentFilter"] ?? null;
    $contentPublish = $_POST["contentPublish"] ?? null;
    $contentId = $_POST["contentId"] ?? null;


    $doSave = $_POST["doSave"] ?? null;
    $doCreate = $_POST["doCreate"] ?? null;
    
    $params = [
        $contentTitle,
        $contentPath,
        $contentSlug,
        $contentData,
        $contentType,
        $contentFilter,
        $contentFilter,
        $contentId
    ];

    $app->db->connect();
    $sql = "SELECT * FROM content;";
    $res = $app->db->executeFetchAll($sql);

    if ($doCreate) {
        $createSql = "INSERT INTO content (title) VALUES (?);";
        $app->db->execute($createSql, [$title]);
        $id = $app->db->lastInsertId();
    }

    $slugTest = null;
    if ($doSave) {
        $SlugSql = "SELECT * FROM content WHERE slug=?;";
        $result = $app->db->executeFetch($SlugSql, [$contentSlug]);
      
        if ($result->num_rows == 0) {
            $updateSql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
            $db->execute($updateSql, array_values($params));

            $app->page->redirect("bloggpage/startpage");
        } else {
            $slugTest = false;
        }
    }

    $data = [
        "resultset" => $res,
        "slugTest" => $slugTest ?? null,
        "contentTitle" => $contentTitle ?? null,
        "contentId" => $id ?? null,
    ];

    $app->page->add("bloggpage/create", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
* Showing all blogposts.
 */
$app->router->get("blogg/bloggposts", function () use ($app) {
    $title = "dbBlogg";
    $app->db->connect();

    // $sql = "SELECT * FROM content where 'type' = pages;";
    $sql = "SELECT * FROM content WHERE type='post';";
    $res = $app->db->executeFetchAll($sql);

    $data = [
        "resultset" => $res,
        "testVar" => "Test",
    ];

    $app->page->add("bloggpage/bloggposts", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
* Showing all pages, select to view page.
 */
$app->router->get("blogg/pages", function () use ($app) {
    $title = "dbBlogg";
    $app->db->connect();

    // $sql = "SELECT * FROM content where 'type' = pages;";
    $sql = "SELECT * FROM content WHERE type='page';";
    $res = $app->db->executeFetchAll($sql);


    $data = [
        "resultset" => $res,
        "testVar" => "Test",
    ];

    $app->page->add("bloggpage/pages", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

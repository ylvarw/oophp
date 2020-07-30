<?php
namespace Ylvan\Movie;

/**
 * Show all movies.
 */
$app->router->get("movie", function () use ($app) {
    $title = "Movie database | oophp";

    // $title = "Show all movies";
    // $view[] = "view/show-all.php";
    // $sql = "SELECT * FROM movie;";
    // $resultset = $db->executeFetchAll($sql);


    $app->db->connect();
    
    $sql = "SELECT * FROM movie;";
    $res = $app->db->executeFetchAll($sql);

    $app->page->add("movie/index", [
        "resultset" => $res,
        // "res" => $res,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});




/**
 * search by title.
 */
//  gör POST istället?

$app->router->get("movie/title", function () use ($app) {
    $title = "Movie database | oophp";
    $searchTitle = $_POST["searchTitle"] ?? null;
    // $app->db->connect();

    // $sql = "SELECT * FROM movie;";
    // $res = $app->db->executeFetchAll($sql);

    $app->db->connect();
    $allsql = "SELECT * FROM movie;";
    // $resultset = $db->executeFetchAll($sql);

    // $movietitle = "SELECT * WHERE title";
    // $view[] = "../htdocs/php-pdo-mysql/view/search-title.php";
    // $view[] = "../htdocs/php-pdo-mysql/view/show-all.php";
    // $searchTitle = getGet("searchTitle");
    
    if ($searchTitle) {
        $sql = "SELECT * FROM movie WHERE title LIKE ?;";
        $res = $db->executeFetchAll($sql, [$searchTitle]);
        $titleResult = $db->executeFetchAll($sql, [$searchTitle]);
    }

    $data = [
        "resultset" => $allsql,
        "titleres" => $titleResult ?? null,
        "testVar" => "kalops",
    ];

    $app->page->add("movie/title-search", $data);
    // $app->page->add("movie/index", [
    //     "resultset" => $res ?? $allsql,
    // ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

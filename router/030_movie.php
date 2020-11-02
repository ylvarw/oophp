<?php
namespace Ylvan\Movie;

// require "../htdocs/php-pdo-mysql/src/autoload.php";
// require "../htdocs/php-pdo-mysql/src/config.php";
include("autoloader.php");
// include("dbfunctions.php");
// require "../router/dbfunctions.php";

$sql = null;
$resultset = null;
// $db;

/**
 * init database and redirect to see list of movies
 */
$app->router->get("movie/init", function () use ($app) {

    return $app->response->redirect("movie/list");
});



/**
 * Show all movies.
 */
$app->router->get("movie/list", function () use ($app) {
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
    $searchTitle = htmlentities($_GET["searchTitle"] ?? null);

    // $app->db->connect();

    // $sql = "SELECT * FROM movie;";
    // $res = $app->db->executeFetchAll($sql);

    $app->db->connect();

    $allsql = "SELECT * FROM movie;";
    $allres = $app->db->executeFetchAll($allsql);
    // $resultset = $db->executeFetchAll($sql);

    
    if ($searchTitle) {
        $app->db->connect();
        // $movietitle = "SELECT * WHERE title";
        // $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
        // $res = $app->db->executeFetchAll($sql, [$year1, $year2]);

        $sql = "SELECT * FROM movie WHERE title LIKE ?;";
        // $sql = "SELECT * FROM movie WHERE CONTAINS(title, ?;";
        $searchRes = $app->db->executeFetchAll($sql, [$searchTitle]);
    } else {
        $sql = "SELECT * FROM movie;";
        $searchRes = $app->db->executeFetchAll($sql);
    }

    $data = [
        "resultset" => $allres,
        "titleRes" => $searchRes ?? null,
        "searchTitle" => $searchTitle,
    ];

    // $app->page->add("movie/index", $data);
    $app->page->add("movie/title-search", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * search by year.
 */
$app->router->get("movie/year", function () use ($app) {
    $title = "Movie database | oophp";
    $app->db->connect();
    $allsql = "SELECT * FROM movie;";
    $allres = $app->db->executeFetchAll($allsql);
    $year1 = htmlentities($_GET["year1"] ?? 1900);
    $year2 = htmlentities($_GET["year2"] ?? 2100);

    if ($year1 && $year2) {
        $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
        $res = $app->db->executeFetchAll($sql, [$year1, $year2]);
    } elseif ($year1) {
        $sql = "SELECT * FROM movie WHERE year >= ?;";
        $res = $app->db->executeFetchAll($sql, [$year1]);
    } elseif ($year2) {
        $sql = "SELECT * FROM movie WHERE year <= ?;";
        $res = $app->db->executeFetchAll($sql, [$year2]);
    }
    

    $data = [
        "resultset" => $allres ?? null,
        "yearRes" => $res ?? null,
        "year1" => $year1 ?? "-",
        "year2" => $year2 ?? "-",
        "testVar" => "kladdkaka",
    ];

    $app->page->add("movie/year-search", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * create, read, update, delete movie in database
 */
//  gör POST istället?
$app->router->get("movie/crud", function () use ($app) {
    $title = "Movie database | oophp";

    $movieId = htmlentities($_GET["movieId"] ?? null);
    $movieTitle = htmlentities($_GET["movieTitle"] ?? null);
    $movieYear = htmlentities($_GET["movieYear"] ?? null);
    $movieImage = htmlentities($_GET["movieImage"] ?? null);

    $doSave = htmlentities($_POST["doSave"] ?? null);
    $doEdit = htmlentities($_POST["doEdit"] ?? null);
    $doAdd = htmlentities($_POST["doAdd"] ?? null);



    $app->db->connect();
    $allsql = "SELECT * FROM movie;";
    $res = $app->db->executeFetchAll($allsql);

    
    // $title = "UPDATE movie";

    // $movieId    = getPost("movieId") ?: getGet("movieId");
    // $movieTitle = getPost("movieTitle");
    // $movieYear  = getPost("movieYear");
    // $movieImage = getPost("movieImage");

    if ($doSave) {
        $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
        $app->db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
        // header("Location: ?route=movie-edit&movieId=$movieId");
        // exit;
    }

    if ($doAdd) {
        // $app->page->add("movie/add-movie");
        $app->response->redirect("movie/add-movie");
    }

    if ($doEdit) {
        // $app->page->add("movie/edit", $selectedMovie);
        $app->response->redirect("movie/edit");
    }


    $sql = "SELECT * FROM movie WHERE id = ?;";
    $movie = $app->db->executeFetchAll($sql, [$movieId]);
    // $movie = $movie[0];

    
    $allsql = "SELECT * FROM movie;";
    $newRes = $app->db->executeFetchAll($allsql);

    $data = [
        "resultset" => $res ?? null,
        "newRes" => $newRes ?? null,
        "movie" => $movie ?? null,
        "chosen" => $chosen ?? null,
        "showAll" => $allRes ?? null,
        // "edit" => $edit ?? null,
        "testVar" => "chokladkex",
    ];

    $app->page->add("movie/movie-crud", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Show all movies and newly added ones.
 */
// $app->router->get("movie/add", function () use ($app) {
$app->router->get("movie/add", function () use ($app) {
    $title = "Movie database";
  
    $app->db->connect();

    $sql = "SELECT * FROM movie;";
    $res = $app->db->executeFetchAll($sql);

    // $res = $_SESSION["resultset"];
    // $doAdd = $_SESSION["add"];
    // $updated = $_SESSION["updatedList"];

    $data = [
        "resultset" => $res ?? null,
        // "doSave" => $doAdd ?? null,
        // "movielist" => $updated ?? null,

        "testVar" => "eukalyptus",
    ];
    $app->page->add("movie/add-movie", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Add new movie to DB
 */
// $app->router->get("movie/add", function () use ($app) {
$app->router->post("movie/add", function () use ($app) {
    $title = "Movie database";

    // $movieId = htmlentities($_GET["movieId"] ?? null);
    $movieTitle = htmlentities($_POST["movieTitle"] ?? "A title");
    $movieYear = htmlentities($_POST["movieYear"] ?? 2017);
    $movieImage = htmlentities($_POST["movieImage"] ?? "img/noimage.png");
    $doAdd = htmlentities($_POST["doAdd"] ?? null);

    $app->db->connect();

    if ($doAdd) {
        $app->db->connect();

        $addsql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
        $app->db->execute($addsql, [$movieTitle, $movieYear, $movieImage]);
        $movieId = $app->db->lastInsertId();

        $sql = "SELECT * FROM movie;";
        $updated = $app->db->executeFetchAll($sql);
    }

    $sql = "SELECT * FROM movie;";
    $res = $app->db->executeFetchAll($sql);

    // $addMovie = $_SESSION["addMovie"];

    $_SESSION["resultset"] = $res;
    $_SESSION["add"] = $doAdd;
    $_SESSION["updatedList"] = $updated;

    return $app->response->redirect("movie/add");
});


/**
 * Edit Movie information.
 */
$app->router->post("movie/edit", function () use ($app) {

    $doEdit = htmlentities($_POST["doEdit"] ?? null);
    $movieId = htmlentities($_POST["movieId"] ?? null);
    $newMovieTitle = htmlentities($_POST["movieTitle"] ?? null);
    $newMovieYear = htmlentities($_POST["movieYear"] ?? null);
    $newMovieImage = htmlentities($_POST["movieImage"] ?? null);


    $app->db->connect();

    if ($doEdit) {
        // check vars and replace the missing ones with vars from database
        if (strlen($newMovieTitle) == 0) {
            $titleSql = "SELECT title FROM movie WHERE id = ?;";
            $movieTitle = $app->db->executeFetchAll($titleSql, [$movieId]);
        } else {
            $movieTitle = $newMovieTitle;
        }

        if (strlen($newMovieYear) == 0) {
            $yearSql = "SELECT year FROM movie WHERE id = ?;";
            $movieYear = $app->db->executeFetchAll($yearSql, [$movieId]);
        } else {
            $movieYear = $newMovieYear;
        }

        if (strlen($newMovieImage) == 0) {
            $imageSql = "SELECT image FROM movie WHERE id = ?;";
            $movieImage = $app->db->executeFetchAll($imageSql, [$movieId]);
        } else {
            $movieImage = $newMovieImage;
        }

        // $_SESSION["movieId"] = $movieId;
        // $_SESSION["movieTitle"] = $newMovieTitle;
        // $_SESSION["movieYear"] = $newMovieYear;
        // $_SESSION["movieImage"] = $newMovieImage;

        $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
        $app->db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
    }


    // $_SESSION["movieId"] = $movieId;
    // $_SESSION["movieTitle"] = $newMovieTitle;
    // $_SESSION["movieYear"] = $newMovieYear;
    // $_SESSION["movieImage"] = $newMovieImage;

    return $app->response->redirect("movie/edit");
});

/**
 * Show all movies and updated information.
 */
// $app->router->get("movie/add", function () use ($app) {
$app->router->get("movie/edit", function () use ($app) {
    $title = "Movie database";
    
    $app->db->connect();

    $sql = "SELECT * FROM movie;";
    $res = $app->db->executeFetchAll($sql);

    // $movieId = $_SESSION["movieId"];
    // $movieTitle = $_SESSION["movieTitle"];
    // $movieYear = $_SESSION["movieYear"];
    // $movieImage = $_SESSION["movieImage"];


    $data = [
    "resultset" => $res ?? null,
    // "doEdit" => $doEdit ?? null,
    // "movieId" => $movieId ?? null,
    // "movieTitle" => $movieTitle ?? null,
    // "movieYear" => $movieYear ?? null,
    // "movieImage" => $movieImage ?? null,
    // "testVar" => "kolasås",
    ];

    $app->page->add("movie/edit", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Show all movies.
 */
$app->router->post("movie/del", function () use ($app) {
    $movieId = htmlentities($_POST["movieId"] ?? null);
    $doDelete = htmlentities($_POST["doDelete"] ?? null);
    // strval($movieId);
    // echo $movieId;

    $app->db->connect();

    if ($doDelete) {
        $sql = "DELETE FROM movie WHERE id = ?;";
        $app->db->execute($sql, [$movieId]);
    }

    return $app->response->redirect("movie/del");
});

$app->router->get("movie/del", function () use ($app) {
    $title = "Movie database";
    
    $app->db->connect();

    $sql = "SELECT * FROM movie;";
    $res = $app->db->executeFetchAll($sql);


    $data = [
    "resultset" => $res ?? null,
    ];

    $app->page->add("movie/delete-movie", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

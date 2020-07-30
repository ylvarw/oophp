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
 * Show all movies.
 */
$app->router->get("movie/add", function () use ($app) {
    $title = "Movie database | oophp";

    // $movieId = htmlentities($_GET["movieId"] ?? null);
    $movieTitle = htmlentities($_POST["movieTitle"] ?? "A title");
    $movieYear = htmlentities($_POST["movieYear"] ?? 2017);
    $movieImage = htmlentities($_POST["movieImage"] ?? "img/noimage.png");

    $doAdd = htmlentities($_POST["doAdd"] ?? null);

  
    $app->db->connect();
    
    

    // $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
    // $db->execute($sql, ["A title", 2017, "img/noimage.png"]);
    // $movieId = $db->lastInsertId();


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


    $data = [
        "resultset" => $res ?? null,
        "doSave" => $doAdd ?? null,
        "movielist" => $updated ?? null,
        // "chosen" => $chosen ?? null,
        // "showAll" => $allRes ?? null,
        // "edit" => $edit ?? null,
        "testVar" => "eukalyptus",
    ];
    $app->page->add("movie/add-movie", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Show all movies.
 */
$app->router->get("movie/edit", function () use ($app) {
    $title = "Movie database | oophp";

    $doSave = htmlentities($_POST["doSave"] ?? null);
    $doEdit = htmlentities($_POST["doEdit"] ?? null);
    $editmovieId = htmlentities($_POST["editmovieId"] ?? null);
    $movieselect = htmlentities($_POST["movieselect"] ?? null);
    // echo $movieselect;


    $movieId = is_numeric(htmlentities($_GET["movieId"] ?? null));
    $movieTitle = htmlentities($_GET["movieTitle"] ?? null);
    $movieYear = htmlentities($_GET["movieYear"] ?? null);
    $movieImage = htmlentities($_GET["movieImage"] ?? null);
    // $movieId    = getPost("movieId") ?: getGet("movieId");
    // $movieTitle = getPost("movieTitle");
    // $movieYear  = getPost("movieYear");
    // $movieImage = getPost("movieImage");
    // if (getPost("doSave")) {
    //     $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
    //     $db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
    //     header("Location: ?route=movie-edit&movieId=$movieId");
    //     exit;
    // }
    // $sql = "SELECT * FROM movie WHERE id = ?;";
    // $movie = $db->executeFetchAll($sql, [$movieId]);

    $app->db->connect();
    
    $sql = "SELECT * FROM movie;";
    $res = $app->db->executeFetchAll($sql);

    $selectsql = "SELECT id, title FROM movie;";
    $movies = $app->db->executeFetchAll($selectsql);

    
    if ($doEdit) {
        $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
        // if (!$movieTitle){
        //     $titlesql = "SELECT title FROM movie WHERE id = ?;";
        //     $movieTitle = $app->db->executeFetchAll($titlesql, [$movieId]);
        // }
        // if (!$movieYear){
        //     $yearsql = "SELECT year FROM movie WHERE id = ?;";
        //     $movieYear = $app->db->executeFetchAll($yearsql, [$movieId]);
        // }
        // if (!$movieImage){
        //     $imagesql = "SELECT image FROM movie WHERE id = ?;";
        //     $movieImage = $app->db->executeFetchAll($imagesql, [$movieId]);
        // }
        $app->db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
    }
    // if ($editmovieId) {
    //     $sql = "SELECT * FROM movie WHERE id = ?;";
    //     $selectmovie = $app->db->execute($sql, [$editmovieId]);
    //     $selectTitle = $selectmovie->title;
    //     $selectyear = $selectmovie->year;
    //     $selectImage = $selectmovie->image;
    //     // $selectTitle = $selectmovie->title;
    //     // $app->page->add("movie/index");
    // }


    $data = [
        "resultset" => $res ?? null,
        "doEdit" => $doEdit ?? null,
        "movies" => $movies ?? null,
        "movieId" => $movieId ?? null,
        "movieTitle" => $movieTitle ?? null,
        "movieYear" => $movieYear ?? null,
        "movieImage" => $movieImage ?? null,
        "selectmovie" => $selectmovie ?? null,
        "editmovieId" => $editmovieId ?? null,
        "selectTitle" => $selectTitle ?? null,
        "selectYear" => $selectYear ?? null,
        "selectImage" => $movieImage ?? null,
        // "movieImage" => $movieImage ?? null,
        "testVar" => "kolasås",
    ];

    $app->page->add("movie/edit", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Show all movies.
 */
$app->router->get("movie/del", function () use ($app) {
    $title = "Movie database | oophp";

    $movieId = htmlentities($_GET["movieId"] ?? null);
    // $movieTitle = htmlentities($_GET["movieTitle"] ?? null);
    // $movieYear = htmlentities($_GET["movieYear"] ?? null);
    // $movieImage = htmlentities($_GET["movieImage"] ?? null);

    $doDelete = htmlentities($_POST["doDelete"] ?? null);

    // $title = "Show all movies";
    // $view[] = "view/show-all.php";
    // $sql = "SELECT * FROM movie;";
    // $resultset = $db->executeFetchAll($sql);

    $app->db->connect();
    
    $sql = "SELECT * FROM movie;";
    $res = $app->db->executeFetchAll($sql);

    
    if ($doDelete) {
        $app->db->connect();

        $sql = "DELETE FROM movie WHERE id = ?;";
        $app->db->execute($sql, [$movieId]);
    }


    $data = [
        "resultset" => $res ?? null,
        "doDelete" => $doDelete ?? null,
        "testVar" => "körsbärspaj",
    ];

    $app->page->add("movie/delete-movie", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

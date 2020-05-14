<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));

/**
 * init game and redirect to play game
 */
$app->router->get("dice/init", function () use ($app) {
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    // destroy the session.
    session_destroy();
    session_name("dice");
    session_start();
    // session_name("dice");
    // session_start();
    // $_SESSION["dice"] = new Ylvan\Dice\Dice();
    // // $game = new Ylvan\Guess\Guess();
    if (!isset($_SESSION["dice"])) {
        $_SESSION["dice"] = new Ylvan\Dice\Dice();
    }

    return $app->response->redirect("dice/play");
});

/**
 * play the game
 */
$app->router->post("dice/play", function () use ($app) {
    if (!isset($_SESSION["dice"])) {
        $_SESSION["dice"] = new Ylvan\Dice\Dice();
    }

    $game = $_SESSION["dice"];
    $goal = 100;

    $_SESSION["playersum"] ?? 0;
    // $_SESSION["computerpoint"] ?? 0;
    $_SESSION["computersum"] ?? 0;
    $_SESSION["gameroundSum"] ?? 0;
    $_SESSION["currentplayer"] ?? "person";
    $_SESSION["diceList"] ?? null;
    $_SESSION["haveWinner"] ?? null;
    $_SESSION["continue"] ?? 1;
    $_SESSION["diceHand"] ?? null;

    $roll = $_POST["roll"] ?? null;
    $save = $_POST["save"] ?? null;
    $restart = $_POST["restart"] ?? null;

    /*
    *switch between player and computer
    */
    function changePlayer()
    {
        $player = $_SESSION["currentplayer"];
        if ($player === "person") {
            $_SESSION["currentplayer"] = "computer";
        } else {
            $_SESSION["currentplayer"] = "person";
        }
    }

    function savepoints()
    {
        if ($_SESSION["currentplayer"] === "person") {
            $_SESSION["playersum"] += $_SESSION["gameroundSum"];
            $_SESSION["gameroundSum"] = 0;
            checkWinner();
            changePlayer();
        } else {
            $_SESSION["computersum"] += $_SESSION["gameroundSum"];
            $_SESSION["gameroundSum"] = 0;
            checkWinner();
            changePlayer();
        }
    }

    /*
    *check dice list to see if there is a 1 to stop round
    */
    function rollDice()
    {
        $game = $_SESSION["dice"];
        $game->roll();
        $dices = $game->getRolls();
        // $_SESSION["diceList"] = $game->getRolls();

        if (in_array(1, $dices)) {
            $_SESSION["gameroundSum"] = 0;
            $_SESSION["diceList"] = $game->rolls;
            // $_SESSION["diceList"] = $game->values();
            changePlayer();
        } else {
            $_SESSION["diceList"] = $game->rolls;
            // $_SESSION["diceList"] = $game->values();
            $_SESSION["gameroundSum"] += $game->sum();
        }
    }

    /*
    *check winner
    */
    function checkWinner()
    {
        // check if current player have 100 points
        if ($_SESSION["playersum"] >= 100) {
            $_SESSION["haveWinner"] = "Grattis! Du";
        }

        if ($_SESSION["computersum"] >= 100) {
            $_SESSION["haveWinner"] = "Datorn";
        }
        // if ($_SESSION["currentplayer"] === "person") {
        //     if ($_SESSION["gameroundSum"] >= 100) {
        //         $_SESSION["haveWinner"] = "Spelare 1";
        //     } else {
        //         changePlayer();
        //     }
        // } else {
        //     if ($_SESSION["computersum"] >= 100) {
        //         $_SESSION["haveWinner"] = "datorn";
        //     } else {
        //         changePlayer();
        //     }
        // }
    }

    function computer()
    {
        $_SESSION["computerturn"] = true;
        rollDice();
        // decide if computer should save or roll again
        if (rand(0, 1) == 1) {
            rollDice();
        } else {
            savepoints();
            // checkWinner();
        }
    }


    function restart()
    {
        // reset parameters and values in session
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        // destroy the session.
        session_destroy();
        // session_name("dice");
        session_start();

        if (!isset($_SESSION["dice"])) {
            $_SESSION["dice"] = new Ylvan\Dice\Dice();
        }
    }

    // computer round.
    if ($_SESSION["currentplayer"] === "computer") {
        computer();
    }



    // roll the dice
    if ($roll) {
        rollDice();
    }

    // save points
    if ($save) {
        savepoints();
        // checkWinner();
    }


    if ($restart) {
        restart();
        // // reset parameters and values in session
        // if (ini_get("session.use_cookies")) {
        //     $params = session_get_cookie_params();
        //     setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        // }
        // // destroy the session.
        // session_destroy();
        // // session_name("dice");
        // session_start();
        //
        // if (!isset($_SESSION["dice"])) {
        //     $_SESSION["dice"] = new Ylvan\Dice\Dice();
        // }
    //     if (ini_get("session.use_cookies")) {
    //         $params = session_get_cookie_params();
    //         setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    //     }
    //     // destroy the session.
    //     $game->restart();
    //     session_destroy();
    //     session_start();
    }

    return $app->response->redirect("dice/play");
});



/**
* setting data to render on Dice page
 */
 $app->router->get("dice/play", function () use ($app) {

     $playersum = $_SESSION["playersum"] ?? 0;
     $computersum = $_SESSION["computersum"] ?? 0;
     $diceSum = $_SESSION["gameroundSum"] ?? 0;
     $winner = $_SESSION["haveWinner"] ?? null;
     $computerturn = $_SESSION["computerturn"] ?? null;
     $_SESSION["computerturn"] = null;
     $diceList = $_SESSION["diceList"] ?? null;
     $_SESSION["diceList"] = null;

     $title = "Play the game";
     $data = [
         "playerpoint" => $playersum,
         "computerpoint" => $computersum,
         "diceList" => $_SESSION["diceList"],
         // "diceList" => $diceList,
         "computerturn" => $computerturn,
         "diceSum" => $diceSum,
         "winner" => $winner,
         "roll" => $roll ?? null,
         "save" => $save ?? null,
         // "restart" => $restart ?? null,
     ];

     $app->page->add("dice/play", $data);
     // $app->page->add("guess/debug");

     return $app->page->render([
         "title" => $title,
     ]);
 });

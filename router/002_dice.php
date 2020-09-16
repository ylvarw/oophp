<?php
namespace Ylvan\Game;

// require './autoloader.php';
use Ylvan\Game\Dice2;

include("autoloader.php");
include("../src/Dice/Dice2.php");
// include(__DIR__ . "/Dice.php");
// use Ylvan\Game\Dice as Dice;
// $dice = new Dice();



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
    session_destroy();
    session_name("dice");
    session_start();

    if (!isset($_SESSION["dice"])) {
        $_SESSION["dice"] = new Dice2();
    }

    return $app->response->redirect("dice/play");
});

/**
 * play the game
 */
$app->router->post("dice/play", function () use ($app) {

    if (!isset($_SESSION["dice"])) {
        $_SESSION["dice"] = new Dice2();
    }
    $game = $_SESSION["dice"];
    // global $game;

    $_SESSION["playersum"] ?? 0;
    $_SESSION["computersum"] ?? 0;
    $_SESSION["gameroundSum"] ?? 0;
    $_SESSION["currentplayer"] ?? "person";
    $_SESSION["computerturn"] ?? false;
    $_SESSION["diceList"] ?? null;
    $_SESSION["haveWinner"] ?? null;
    $_SESSION["continue"] ?? 1;
    $_SESSION["diceHand"] ?? null;

    $roll = $_POST["roll"] ?? null;
    $save = $_POST["save"] ?? null;

    /*
    * change player
    */
    function changePlayer()
    {
        $player = $_SESSION["currentplayer"];
        if ($player === "person") {
            $_SESSION["currentplayer"] = "computer";
            computer();
        } else {
            $_SESSION["currentplayer"] = "person";
            $_SESSION["computerturn"] = false;
        }
    }

    /*
    * save the points
    */
    function savepoints()
    {
        $player = $_SESSION["currentplayer"];
        // if ($_SESSION["currentplayer"] === "person") {
        if ($player === "person") {
            $_SESSION["playersum"] += $_SESSION["gameroundSum"];
            $_SESSION["gameroundSum"] = 0;
            checkWinner();
            // changePlayer();
        } else {
            $_SESSION["computersum"] += $_SESSION["gameroundSum"];
            $_SESSION["gameroundSum"] = 0;
            checkWinner();
            // changePlayer();
        }
    }

    /*
    * Roll dice, changwe player if 1 in dicelist
    */
    function rollDice()
    {
        $game = new Dice2();

        $game->roll();
        // $dices = $game->rolls;
        $dices = $game->getRolls();
        // $_SESSION["diceList"] = $game->getRolls();

        if (in_array(1, $dices)) {
            $_SESSION["gameroundSum"] = 0;
            $_SESSION["diceList"] = $game->rolls;
            // $_SESSION["diceList"] = $game->values();
            changePlayer();
        } else {
            $_SESSION["diceList"] = $game->values();
            // $_SESSION["diceList"] = $game->values();
            $_SESSION["gameroundSum"] += $game->sum();
        }
    }

    /*
    * Check for winner
    */
    function checkWinner()
    {
        // $player = $_SESSION["currentplayer"];
        $computer = $_SESSION["computerturn"];

        if ($computer === false) {
            if ($_SESSION["gameroundSum"] >= 100) {
                $_SESSION["haveWinner"] = "Spelare 1";
            } else {
                changePlayer();
            }
        } elseif ($computer === true) {
            if ($_SESSION["computersum"] >= 100) {
                $_SESSION["haveWinner"] = "datorn";
            } else {
                changePlayer();
            }
        }
    }

    /*
    * play computers turn
    */
    function computer()
    {
        $_SESSION["computerturn"] = true;
        rollDice();
        // decide if computer should save or roll again
        if (rand(0, 1) == 1) {
            rollDice();
            savepoints();
        } else {
            savepoints();
        }
    }

    // roll the dice
    if ($roll) {
        rollDice();
    }

    // save points
    if ($save) {
        savepoints();
    }

    return $app->response->redirect("dice/play");
});



/**
* restart game
 */
 $app->router->get("dice/restart", function () use ($app) {

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
     // destroy the session.
     session_destroy();
     session_start();

    if (!isset($_SESSION["dice"])) {
        $_SESSION["dice"] = new Dice2();
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
         // "diceList" => $_SESSION["diceList"],
         "diceList" => $diceList,
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

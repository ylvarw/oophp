<?php
namespace Ylvan\Game;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response.
        // return __METHOD__ . ", \$db is {$this->db}";
        return "Index page!!";
    }


    /**
     *debug
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
        // return __METHOD__ . ", \$db is {$this->db}";
        return "debug me";
    }


    /**
     * Init action, initiate game
     * @return object
     */
    public function initAction() : object
    {
        $session = $this->app->session;
        $response = $this->app->response;

        if (($session->get("dice")) === null) {
            $session->set("dice", new Dice2());
        }
        return $response->redirect("dice/play");
    }


    /**
     * Play the game
     *
     * @return object
     */
    public function playAction() : object
    {
        $session = $this->app->session;
        $response = $this->app->response;
        $request = $this->app->request;

        $session->set("playersum", 0);
        $session->set("computersum", 0);
        $session->set("gameroundSum", 0);
        $session->set("currentplayer", "person");
        $session->set("diceList", null);
        $session->set("haveWinner", null);
        $session->set("diceHand", null);
        $session->set("computerturn", false);

        $roll = $request->getPOST("roll", null);
        $save = $request->getPOST("save", null);


        /*
        * change player
        */
        function changePlayer()
        {
            $player = $session->get("currentplayer");
            if ($player === "person") {
                $session->set("currentplayer", "computer");
                computer();
            } else {
                $session->set("currentplayer", "person");
                $session->set("computerturn", false);
            }
        }

        /*
        * save the points
        */
        function savepoints()
        {
            $player = $session->get("currentplayer");
            $gameroundSum = $session->get("gameroundSum");
            $computersum = $session->get("computersum");
            $playersum = $session->get("playersum");

            if ($player === "person") {
                $sumpoints = $playersum + $gameroundSum;
                $session->set("playersum", $sumpoints);
                $session->set("gameroundSum", 0);
                checkWinner();
            } elseif ($player === "computer") {
                $sumpoints = $computersum + $gameroundSum;
                $session->set("computersum", $sumpoints);
                $session->set("gameroundSum", 0);
                checkWinner();
            }
        }

        /*
        * Roll dice, changwe player if 1 in dicelist
        */
        function rollDice()
        {
            $game = new Dice2();
            $game->roll();
            $dices = $game->getRolls();

            if (in_array(1, $dices)) {
                $session->set("gameroundSum", 0);
                $dicevalues = $game->values();
                $session->set("diceList", $dicevalues);
                changePlayer();
            } else {
                $points = $session->get("gameroundSum");
                $dicevalues = $game->values();
                $session->set("diceList", $dicevalues);
                $gameroundpoints = $points + $game->sum();
                $session->set("gameroundSum", $gameroundpoints);
            }
        }

        /*
        * Check for winner
        */
        function checkWinner()
        {
            $computer = $session->get("computerturn");
            $gameroundSum = $session->get("gameroundSum");
            $computersum = $session->get("computersum");

            if ($computer === false) {
                if ($gameroundSum >= 100) {
                    $session->set("haveWinner", "Hooman");
                } else {
                    changePlayer();
                }
            } elseif ($computer === true) {
                if ($computersum >= 100) {
                    $session->set("haveWinner", "Datorn");
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
            $session = $this->app->session;

            $session->set("computerturn", true);
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

        return $response->redirect("dice/play");
    }


    /**
     * Restart the game
     *
     * @return object
     */
    public function restartAction() : object
    {
        $session = $this->app->session;
        $response = $this->app->response;

        $session->set("playersum", 0);
        $session->set("computersum", 0);
        $session->set("gameroundSum", 0);
        $session->set("currentplayer", "person");
        $session->set("diceList", null);
        $session->set("haveWinner", null);
        $session->set("diceHand", null);
        $session->set("computerturn", false);
        $session->set("dice", new Dice2());

        return $response->redirect("dice/play");
    }


    /**
     * send vars to game page with GET
     *
     * @return object
     */
    public function getPlayAction() : object
    {
        $session = $this->app->session;
        $page = $this->app->page;

        //Get current vars from session
        $playersum = $session->get("playersum", 0);
        $computersum = $session->get("computersum", 0);
        $diceSum = $session->get("gameroundSum", 0);
        $winner = $session->get("haveWinner", null);

        $computerturn = $session->get("computerturn", null);
        $computerturn = $session->set("computerturn", null);

        $diceList = $session->get("diceList", null);
        $diceList = $session->set("diceList", null);

        $title = "Play 100";
        $data = [
            "playerpoint" => $playersum,
            "computerpoint" => $computersum,
            "diceList" => $diceList,
            "computerturn" => $computerturn,
            "diceSum" => $diceSum,
            "winner" => $winner
        ];

        $page->add("dice/play", $data);

        return $page->render([
            "title" => $title,
        ]);
    }
}

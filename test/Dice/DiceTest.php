<?php

namespace Ylvan\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class DiceTest extends TestCase
{
    /**
     * Construct object and verify the object
     */
    public function testCreateObjectNoArguments()
    {
        $game = new Dice();
        $this->assertInstanceOf("Ylvan\Dice\Dice", $game);
    }


    /**
    * Do a roll with the dice
    */
    public function testRoll()
    {
        $game = new Dice();
        $game->roll();
        $res = count($game->rolls);
        $exp = 4;
        $this->assertEquals($exp, $res);
    }


    /**
    * test the sum of the dice
    */
    public function testSum()
    {
        $game = new Dice();
        $game->roll();
        $res = $game->sum();
        $exp = array_sum($game->rolls);

        $this->assertEquals($exp, $res);
    }

    /**
    * test to get rolls
    */
    public function testGetRolls()
    {
        $game = new Dice();
        $game->roll();
        $res = $game->rolls;
        $exp = $game->getRolls();

        $this->assertEquals($exp, $res);
    }
}

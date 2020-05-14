<?php
namespace Ylvan\Dice;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */

class Dice
{
    public $rolls = [];
    private $faces = 6;
    // protected $playerpoint = 0;
    // protected $computerpoint = 0;

    public function roll($times = 4)
    {
         $this->rolls = [];
        for ($i=0; $i < $times; $i++) {
             $this->rolls[] = rand(1, $this->faces);
        }
    }

    public function sum()
    {
        return array_sum($this->rolls);
    }

    // public function average()
    // {
    //      $middle = (array_sum($this->rolls) / sizeof($this->rolls));
    //      return $middle;
    // }

    public function getRolls()
    {
        return $this->rolls;
    }

    public function values()
    {
        echo join(', ', $this->rolls);
    }

    // public function getPlayerPoints()
    // {
    //     return $this->playerpoint;
    // }
    //
    // public function setPlayerPoints($points)
    // {
    //     $this->playerpoint = $this->playerpoint + $points;
    // }
    //
    // public function getComputerPoints()
    // {
    //     return $this->computerpoint;
    // }
    //
    // public function setComputerPoints($points)
    // {
    //     $this->computerpoint = $this->computerpoint + $points;
    // }
    //
    // public function restart()
    // {
    //     $this->computerpoint = 0;
    //     $this->playerpoint = 0;
    // }
}

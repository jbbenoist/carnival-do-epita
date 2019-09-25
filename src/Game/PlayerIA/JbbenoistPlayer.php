<?php

namespace Hackathon\PlayerIA;
use Hackathon\Game\Result;

/**
 * Class jbbenoistPlayer
 * @package Hackathon\PlayerIA
 * @author jbbenoist
 *
 */
class JbbenoistPlayer extends Player
{
    protected $mySide;
    protected $opponentSide;
    protected $result;
    protected $prevalues;

    function __construct() {
      $this->prevalues = array(
                     "rock" => array(
                        "rock" => array("rock" => 0, "paper" => 0, "scissors" => 0),
                        "paper" => array("rock" => 0, "paper" => 0, "scissors" => 0),
                        "scissors" => array("rock" => 0, "paper" => 0, "scissors" => 0)),
                     "paper" => array(
                        "rock" => array("rock" => 0, "paper" => 0, "scissors" => 0),
                        "paper" => array("rock" => 0, "paper" => 0, "scissors" => 0),
                        "scissors" => array("rock" => 0, "paper" => 0, "scissors" => 0)),
                     "scissors" => array(
                        "rock" => array("rock" => 0, "paper" => 0, "scissors" => 0),
                        "paper" => array("rock" => 0, "paper" => 0, "scissors" => 0),
                        "scissors" => array("rock" => 0, "paper" => 0, "scissors" => 0)));
    }

    

    public function getChoice()
    {
      $mychoices = $this->result->getChoicesFor($this->mySide);
      $opponentchoices = $this->result->getChoicesFor($this->opponentSide);
      $size = sizeof($mychoices);
      if ($size > 2) {
        $myturn = $mychoices[$size - 2];
        $opponentturn = $opponentchoices[$size - 2];
        $reactturn = $opponentchoices[$size - 1];
        $this->prevalues[$myturn][$opponentturn][$reactturn] += 1;
        /*print($myturn);
        print(" ");
        print($opponentturn);
        print(" ");
        print($reactturn);
        print(" ");
        print($this->prevalues[$myturn][$opponentturn][$reactturn]);
        print("\n");*/
      }
      if ($size > 1) {
        $finalchoice = $this->prevalues[$mychoices[$size - 2]][$opponentchoices[$size - 2]];
        if ($finalchoice["rock"] > $finalchoice["paper"] && $finalchoice["rock"] > $finalchoice["scissors"])
          return parent::paperChoice();
        if ($finalchoice["paper"] > $finalchoice["rock"] && $finalchoice["paper"] > $finalchoice["scissors"])
          return parent::scissorsChoice();
        if ($finalchoice["scissors"] > $finalchoice["paper"] && $finalchoice["scissors"] > $finalchoice["rock"])
          return parent::rockChoice();
        if ($finalchoice["rock"] == $finalchoice["paper"]) {
          $test = rand();
          if ($test % 2 == 0)
            return parent::scissorsChoice();
          else
            return parent::paperChoice();
        }
        if ($finalchoice["rock"] == $finalchoice["scissors"]) {
          $test = rand();
          if ($test % 2 == 0)
            return parent::paperChoice();
          else
            return parent::rockChoice();
        }
        if ($finalchoice["paper"] == $finalchoice["scissors"]) {
          $test = rand();
          if ($test % 2 == 0)
            return parent::scissorsChoice();
          else
            return parent::rockChoice();
        }
      }
      $test = rand();
      if ($test % 3 == 0)
        return parent::paperChoice();
      else if ($test % 3 == 1)
        return parent::rockChoice();
      else
        return parent::scissorsChoice();
    }
};

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
    protected $prevalues; //Le tableau crée pour stocker les réactions de l'adversaire.

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


    /*
     * La fonction commence par regarder ce qui a été joué par les deux joueurs
     * deux tours auparavant et store la réaction de l'adversaire (son coup au
     * dernier tour).
     * Ensuite pour choisir ce que je vais jouer, je regarde dans le tableau
     * les réactions que l'adversaire a eu auparant par rapport à la situation
     * au dernier tour, s'il a plus joué une des trois possibilité, je la
     * choisi, par contre si la situation n'a jamais eu lieu, mon choix sera au
     * hasard entre les trois possibilités, de la même manière si l'adversaire
     * a eu plusieurs réactions autant de fois dans la même situation le choix
     * sera un random entre ces réactions (Exemple : Pierre - Pierre, anciennes
     * réactions : 5 ciseaux-5 papiers-1 pierre fera un random ciseau-papier).
     */
    public function getChoice()
    {
      $mychoices = $this->result->getChoicesFor($this->mySide);
      $opponentchoices = $this->result->getChoicesFor($this->opponentSide);
      $size = sizeof($mychoices);
      if ($size > 2) {

        //ajout dans le tableau
        $myturn = $mychoices[$size - 2];
        $opponentturn = $opponentchoices[$size - 2];
        $reactturn = $opponentchoices[$size - 1];
        $this->prevalues[$myturn][$opponentturn][$reactturn] += 1;
        //fin d'ajout dans le tableau

      }
      if ($size > 1) {

        //choix par rapport au tableau avec un dominant
        $finalchoice = $this->prevalues[$mychoices[$size - 2]][$opponentchoices[$size - 2]];
        if ($finalchoice["rock"] > $finalchoice["paper"] && $finalchoice["rock"] > $finalchoice["scissors"])
          return parent::paperChoice();
        if ($finalchoice["paper"] > $finalchoice["rock"] && $finalchoice["paper"] > $finalchoice["scissors"])
          return parent::scissorsChoice();
        if ($finalchoice["scissors"] > $finalchoice["paper"] && $finalchoice["scissors"] > $finalchoice["rock"])
          return parent::rockChoice();
        //fin de choix par rapport au tableau avec un dominant

        //choix par rapport au tableau avec deux dominants
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
        //fin de choix par rapport au tableau avec deux dominants

      }

      //Cas non connu ou triple égalité donc random sur les trois
      $test = rand();
      if ($test % 3 == 0)
        return parent::paperChoice();
      else if ($test % 3 == 1)
        return parent::rockChoice();
      else
        return parent::scissorsChoice();
      //Cas non connu ou triple égalité donc random sur les trois
    }
};

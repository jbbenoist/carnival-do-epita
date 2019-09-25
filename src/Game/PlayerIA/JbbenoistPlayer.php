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


    public function getChoice()
    {
       $test = rand();
       if ($test % 3 == 0)
         return parent::paperChoice();
       else if ($test % 3 == 1)
         return parent::rockChoice();
       else
         return parent::scissorsChoice();
    }
};

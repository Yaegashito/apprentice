<?php

class Player
{
    public $name;
    public $playerCards;
    public $playerSpareCards = [];

    // public function __construct($name)
    // {
    //     $this->name = $name;
    // }

    public function addSpareToPlayerCards()
    {
        shuffle($this->playerSpareCards);
        $this->playerCards = array_merge($this->playerCards, $this->playerSpareCards);
        return $this->playerCards;
    }
}

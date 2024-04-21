<?php

namespace WarGame;

class Player
{
    public $name;
    public $playerCards;
    public $playerSpareCards = [];

    public function addSpareToPlayerCards()
    {
        shuffle($this->playerSpareCards);
        $this->playerCards = array_merge($this->playerCards, $this->playerSpareCards);
        return $this->playerCards;
    }
}

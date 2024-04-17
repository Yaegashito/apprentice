<?php

class Player
{
    public $name;
    public $countCards = 26;

    public function __construct($name)
    {
        $this->name = $name;
    }
}

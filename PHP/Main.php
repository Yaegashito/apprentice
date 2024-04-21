<?php

use WarGame\WarGame;

require_once('Game.php');
require_once('Player.php');
require_once('Card.php');
require_once('TwoPlayerRule.php');
require_once('ThreePlayerRule.php');

$game = new WarGame();
$game->startGame();

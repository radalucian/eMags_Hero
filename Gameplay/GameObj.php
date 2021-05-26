<?php

include_once("Gameplay/Game.php");
include_once("Logging/GameLogger.php");

// init object of gameMechanics
class GameObj
{
    public static function init(Creature $hero, Creature $beast)
    {
        return (new GameMechanics(new Config(), new GameLogger()))
            ->initHero($hero)
            ->initBeast($beast);
    }
}

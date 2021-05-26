<?php

include_once("GameConfig.php");
include_once("Creatures/BeastsObj.php");
include_once("Creatures/HeroesObj.php");
include_once("Gameplay/GameObj.php");

    try
    {
        $Beast = BeastsObj::init(Config::BEAST_NAME, Config::BEAST_STATS, Config::BEAST_SKILLS);
        $Hero = HeroesObj::init(Config::HERO_NAME, Config::HERO_STATS, Config::HERO_SKILLS);
        $Game = GameObj::init($Hero, $Beast);
        $Game->startGame();
    }
    catch(Exception $e)
        {
            print_r($e->getMessage());
        }

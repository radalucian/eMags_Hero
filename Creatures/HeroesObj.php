<?php
include_once("Creatures/Creatures.php");
include_once("Creatures/StatusGenerator.php");
include_once("Creatures/CreaturesInterface.php");

// create objects of heroes
class HeroesObj implements CreaturesInterface
{
    public static function init($name, $stats = [], $creatureSkills = []){
        $StatusGenerator = new RandomCreatureStatsGenerator();
        $HeroObj =  new Hero($StatusGenerator, $stats, $creatureSkills);
        $HeroObj->setName($name);
        return $HeroObj;
    }

}
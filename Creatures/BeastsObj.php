<?php
include_once("Creatures/Creatures.php");
include_once("Creatures/CreaturesInterface.php");
include_once("Creatures/StatusGenerator.php");

// create objects of beasts
class BeastsObj implements CreaturesInterface
{
    public static function init($name, $stats = [], $creatureSkills = []){
        $StatusGenerator = new RandomCreatureStatsGenerator();
        $BeastObj =  new Beast($StatusGenerator, $stats, $creatureSkills);
        $BeastObj->setName($name);
        return $BeastObj;
    }

}
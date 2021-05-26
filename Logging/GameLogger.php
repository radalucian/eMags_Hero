<?php

include_once("Logging/LoggerInterface.php");
include_once("Gameplay/GameInterface.php");
include_once("Gameplay/Game.php");

class GameLogger implements LoggerInterface {

    // print initial status of creatures objects -> hero and beast
    public function printInitialStats(GameInterface $game)
    {
        echo "Start Battle!".PHP_EOL.PHP_EOL;
        echo "Hero health    : ".$game->getHero()->getHealth().PHP_EOL;
        echo "Hero strength  : ".$game->getHero()->getStrength().PHP_EOL;
        echo "Hero speed     : ".$game->getHero()->getSpeed().PHP_EOL;
        echo "Hero defence   : ".$game->getHero()->getDefence().PHP_EOL;
        echo "Hero luck      : ".$game->getHero()->getLuck().PHP_EOL;
        echo PHP_EOL;

        echo "Beast health   : ".$game->getBeast()->getHealth().PHP_EOL;
        echo "Beast strength : ".$game->getBeast()->getStrength().PHP_EOL;
        echo "Beast speed    : ".$game->getBeast()->getSpeed().PHP_EOL;
        echo "Beast defence  : ".$game->getBeast()->getDefence().PHP_EOL;
        echo "Beast luck     : ".$game->getBeast()->getLuck().PHP_EOL;
        echo PHP_EOL;
    }

    // on each round print details of round: damage dealt, who is defending and who is attacking, etc.
    public function printRoundStats(GameInterface $game, $currentRound)
    {

        echo "ROUND : " . $currentRound . PHP_EOL . PHP_EOL;
        echo "Attacker Name           : " . $game->getAttacker()->getName() . PHP_EOL;
        echo "Attacker Strength       : " . $game->getAttacker()->getStrength() . PHP_EOL;
        echo "Damage Dealt            : " . ((!$game->getDefenderWasLucky()) ? $game->calculateDamage() : 0) . PHP_EOL . PHP_EOL;

        echo "Defender Name           : " . $game->getDefender()->getName() . PHP_EOL;
        echo "Defender Initial Health : " . ((!$game->getDefenderWasLucky()) ? $game->getDefender()->getHealth() + $game->calculateDamage() : $game->getDefender()->getHealth()) . PHP_EOL;
        echo "Defender's Defence      : " . $game->getDefender()->getDefence() . PHP_EOL;
        echo "Defender Current Health : " . $game->getDefender()->getHealth() . PHP_EOL;

        if ($game->getDefenderWasLucky()) {
            echo "Defender was lucky. No damage was received." . PHP_EOL;
        }
        else {
            if ($game->getAttackerWasLucky()) {
                echo "Hero was lucky. Double damage was dealt." . PHP_EOL;
            }
            if ($game->getDefenderUsedSkill()) {
                echo "Hero was lucky. Half the damage was received." . PHP_EOL;
            }
        }

        echo PHP_EOL;
    }

    // print game over and winner
    public function printBattleResults(GameInterface $game)
    {
        echo "Winner is : ".$game->getWinner()->getName().PHP_EOL;
        echo "GAME OVER!!".PHP_EOL;
    }
}
<?php

interface LoggerInterface {
    public function printInitialStats(GameInterface $game);
    public function printRoundStats(GameInterface $game, $currentRound);
    public function printBattleResults(GameInterface $game);
}
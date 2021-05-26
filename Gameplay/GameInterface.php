<?php
interface GameInterface {
    public function initHero(Creature $hero);
    public function initBeast(Creature $beast);
    public function startGame();
    public function getWinner();
    public function calculateDamage();
}
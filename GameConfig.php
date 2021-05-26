<?php

/* main config of application
   contains properties ranges for creatures, names and skills */
class Config{

    const ROUNDS_OF_GAME = 20;

    const HERO_STATS = [
        'health'   => [70, 100],
        'strength' => [70, 80],
        'speed'    => [40, 50],
        'defence'  => [45, 55],
        'luck'     => [10, 30]
    ];

    const HERO_SKILLS = [
        'hasAttackSkills'  => true,
        'hasDefenceSkills' => true,
        'rapidStrikeLuck'  => 10,
        'magicShieldLuck'  => 20
    ];

    const HERO_NAME = "Orderus";

    const BEAST_STATS = [
        'health'   => [60, 90],
        'strength' => [60, 90],
        'speed'    => [40, 60],
        'defence'  => [40, 60],
        'luck'     => [25, 40]
    ];

    const BEAST_SKILLS = [
        'hasAttackSkills'  => false,
        'hasDefenceSkills' => false
    ];

    const BEAST_NAME = "Wild Beast";
}


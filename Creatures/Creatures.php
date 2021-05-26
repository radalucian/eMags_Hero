<?php

class Creature{
    public $name;
    public $health;
    public $strength;
    public $defence;
    public $speed;
    public $luck;
    public $hasAttackSkills;
    public $hasDefenceSkills;

    public function __construct(RandomCreatureStatsGenerator $generator, $stats = [], $creatureSkills = [])
    {
        $generator->generate($this, $stats);
        $generator->setSkills($this, $creatureSkills);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getHealth()
    {
        return $this->health;
    }

    public function setHealth($health)
    {
        $this->health = $health;
        return $this;
    }

    public function getStrength()
    {
        return $this->strength;
    }

    public function setStrength($strength)
    {
        $this->strength = $strength;
        return $this;
    }

    public function getDefence()
    {
        return $this->defence;
    }

    public function setDefence($defence)
    {
        $this->defence = $defence;
        return $this;
    }

    public function getSpeed()
    {
        return $this->speed;
    }

    public function setSpeed($speed)
    {
        $this->speed = $speed;
        return $this;
    }

    public function getLuck()
    {
        return $this->luck;
    }

    public function setLuck($luck)
    {
        $this->luck = $luck;
        return $this;
    }

    public function setHasAttackSkills($hasAttackSkills){
        $this->hasAttackSkills = $hasAttackSkills;
        return $this;
    }

    public function getHasAttackSkills(){
        return $this->hasAttackSkills;
    }

    public function setHasDefenceSkills($hasDefenceSkills){
        $this->hasDefenceSkills = $hasDefenceSkills;
        return $this;
    }

    public function getHasDefenceSkills(){
        return $this->hasDefenceSkills;
    }
}

class Beast extends Creature
{
}

class Hero extends Creature
{
    public $rapidStrikeLuck;
    public $magicShieldLuck;

    public function getRapidStrikeLuck()
    {
        return $this->rapidStrikeLuck;
    }

    public function setRapidStrikeLuck($RapidStrikeLuck)
    {
        $this->rapidStrikeLuck = $RapidStrikeLuck;
        return $this;
    }

    public function getMagicShieldLuck()
    {
        return $this->magicShieldLuck;
    }

    public function setMagicShieldLuck($magicShieldLuck)
    {
        $this->magicShieldLuck = $magicShieldLuck;
        return $this;
    }

}
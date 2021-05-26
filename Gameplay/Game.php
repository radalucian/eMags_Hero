<?php

include_once("GameInterface.php");
include_once("Creatures/StatusGenerator.php");

class GameMechanics implements GameInterface {

    private $currentRound     = null;

    private $attacker         = null;
    private $defender         = null;

    private $hero             = null;
    private $beast            = null;

    private $config           = null;
    private $logger           = null;

    private $defenderWasLucky  = false;
    private $attackerWasLucky  = false;
    private $defenderUsedSkill = false;


    public function __construct(Config $config, LoggerInterface $logger)
    {
        $this->config = $config;
        $this->logger = $logger;
    }

    public function initHero(Creature $hero)
    {
        $this->hero = $hero;
        return $this;
    }

    public function initBeast(Creature $beast)
    {
        $this->beast = $beast;
        return $this;
    }

    public function getHero()
    {
        return $this->hero;
    }

    public function getBeast()
    {
        return $this->beast;
    }

    public function getAttacker()
    {
        return $this->attacker;
    }

    public function getDefender()
    {
        return $this->defender;
    }

    public function getDefenderWasLucky()
    {
        return $this->defenderWasLucky;
    }

    public function getAttackerWasLucky()
    {
        return $this->attackerWasLucky;
    }

    public function getDefenderUsedSkill()
    {
        return $this->defenderUsedSkill;
    }

    /* main function of the game
    it plays the number of rounds defined in config file or until one hero is defeated*/
    public function startGame()
    {
        $this->printInitialStats();
        $this->selectFirstAttacker();

        for($round = 1; $round <= $this->config::ROUNDS_OF_GAME; $round++)
        {
            $this->currentRound = $round;

            if($this->isEndOfBattle())
            {
                break;
            }

            $this->playRound($round);
        }

        $this->printBattleResults();
    }

    /*function plays round -> @param int $round <- round no.
      on each round check probabilities and skills and
      calculate damage accordingly */
    private function playRound(int $round)
    {
        $this->checkIfDefenderWasLucky();
        $this->checkIfDefenderUsedSkill();
        $this->checkIfAttackerWasLucky();
        $this->updateDefenderHealth();
        $this->printRoundStats($round);
        $this->switchPlayerRoles();
    }

    // returns true when one of the players reached 0 health
    private function isEndOfBattle() : ?bool
    {
        if($this->defender->getHealth() <= 0 || $this->attacker->getHealth() <= 0)
        {
            return true;
        }
        return false;
    }

/*  function sets attacker and defender based on speed property
    case speed is similar, setter is based on luck*/
    private function selectFirstAttacker()
    {
        if($this->hero->getSpeed() > $this->beast->getSpeed())
        {
            $this->attacker = $this->hero;
            $this->defender = $this->beast;
            return false;
        } else
        {
            $this->attacker = $this->beast;
            $this->defender = $this->hero;
            return false;
        }

        if($this->hero->getLuck() > $this->beast->getLuck())
        {
            $this->attacker = $this->hero;
            $this->defender = $this->beast;
            return false;
        } else
        {
            $this->attacker = $this->beast;
            $this->defender = $this->hero;
            return false;
        }

        $this->attacker = $this->hero;
        $this->defender = $this->beast;
    }

    /*calculates damage taken by defender
    takes into account creatures skills -> defence luck, defence and attack skills*/
    public function calculateDamage()
    {
        $damage = 0;

        if(!$this->defenderWasLucky) {
            if($this->attacker->getStrength() > $this->defender->getDefence())
            {
                $damage = $this->attacker->getStrength() - $this->defender->getDefence();

                if ($this->defender->getHasDefenceSkills() and $this->defenderUsedSkill){
                    $damage = $damage / 2;
                }

                if ($this->attacker->getHasAttackSkills() and $this->attackerWasLucky) {
                    $damage = 2 * $damage;
                }
            }
        }
        return $damage;
    }

    //update defender's health
    private function updateDefenderHealth()
    {
        $damage = $this->calculateDamage();

        $newHealthValue = $this->defender->getHealth() - $damage;

        if($newHealthValue < 0)
        {
            $newHealthValue = 0;
        }

        $this->defender->setHealth($newHealthValue);
    }

    // swap turns of creatures
    private function switchPlayerRoles()
    {
        $temp = $this->attacker;
        $this->attacker = $this->defender;
        $this->defender = $temp;
    }

    // returns Winner of the game. Winner is Caracter with gratest health
    public function getWinner()
    {
        if($this->attacker->getHealth() > $this->defender->getHealth())
        {
            return $this->attacker;
        }

        return $this->defender;
    }

    // function checks probability that defender was lucky on receiving damage. All creatures can have luck
    private function checkIfDefenderWasLucky()
    {
        $rand = mt_rand(1, 100);
        if($rand <= $this->defender->getLuck())
        {
            $this->defenderWasLucky = true;
            return;
        }

        $this->defenderWasLucky = false;
    }

    // function checks probability that defender used skill on receiving damage. Only heroes can have Defenders Skills
    private function checkIfDefenderUsedSkill()
    {
        if($this->defender->getHasDefenceSkills())
        {
            $rand = mt_rand(1, 100);
            if ($rand <= $this->defender->getMagicShieldLuck()) {
                $this->defenderUsedSkill = true;
                return;
            }
        }
        $this->defenderUsedSkill = false;
    }

    // function checks probability wether attacker was lucky on hit. Only heroes can be lucky
    private function checkIfAttackerWasLucky()
    {
        if($this->attacker->getHasAttackSkills())
        {
            $rand = mt_rand(1, 100);
            if ($rand <= $this->attacker->getRapidStrikeLuck()) {
                $this->attackerWasLucky = true;
                return;
            }
        }
        $this->attackerWasLucky = false;
    }

    private function printInitialStats()
    {
        $this->logger->printInitialStats($this);
    }

    private function printRoundStats($currentRound)
    {
        $this->logger->printRoundStats($this, $currentRound);
    }

    private function printBattleResults()
    {
        $this->logger->printBattleResults($this);
    }
}
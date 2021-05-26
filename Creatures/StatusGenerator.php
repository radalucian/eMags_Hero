<?php

class RandomCreatureStatsGenerator {

    /* function generates and sets object property's values
    based on ranges provided in $stats param <- this param needs to be defined in main application config file
    used when initializing(__construct) creatures*/
    public function generate(Creature $creature, $stats = []) {

        if(empty($stats))
        {
            throw new Exception('The stats cannot be empty');
        }

        foreach($stats as $statKey => $statValue)
        {
            if(empty($statValue[0]) || empty($statValue[1]))
            {
                throw new Exception('The minimum or maximum value is missing');
            }
            if($statValue[0] > $statValue[1])
            {
                throw new Exception('The minimum cannot be greater than maximum');
            }

            $method = sprintf("set%s", ucfirst(strtolower($statKey)));
            if (!method_exists($creature, $method)) {
                throw new Exception(sprintf('Attribute cannot be set. Method [%s] does not exist.', $method));
            }

            $randNumber = $this->getRandomNumber($statValue[0], $statValue[1]);
            $creature->$method($randNumber);
        }
    }

    /* function sets Skills for Creatures
       used when initializing all Creatures Objects
       Only Heroes Objects can have defence/attack skills */
    public function setSkills(Creature $creature, $creatureSkills = []) {

        if(empty($creatureSkills))
        {
            throw new Exception('The stats cannot be empty');
        }

        if (array_key_exists('hasAttackSkills', $creatureSkills)){
            $creature->setHasAttackSkills($creatureSkills['hasAttackSkills']);

            if ($creatureSkills['hasAttackSkills']){
                if (get_class($creature) === 'Hero') {
                    if (array_key_exists('rapidStrikeLuck', $creatureSkills)) {
                        $creature->setRapidStrikeLuck($creatureSkills['rapidStrikeLuck']);
                    } else {
                        throw new Exception(sprintf('Required atack skill luck not available in config. Needed property is [%s].', 'rapidStrikeLuck'));
                    }
                } else {
                    throw new Exception(sprintf('Objects of type Beast cannot have skills. Please set the property of beasts skills to false in config file.'));
                }
            }
        }
        else
        {
            throw new Exception(sprintf('Required skill not available in config. Needed property is [%s].', 'hasAttackSkills'));
        }

        if (array_key_exists('hasDefenceSkills', $creatureSkills)){
            $creature->setHasDefenceSkills($creatureSkills['hasDefenceSkills']);

            if ($creatureSkills['hasDefenceSkills']) {
                if (get_class($creature) === 'Hero') {
                    if (array_key_exists('magicShieldLuck', $creatureSkills)) {
                        $creature->setMagicShieldLuck($creatureSkills['magicShieldLuck']);
                    } else {
                        throw new Exception(sprintf('Required defence skill luck not available in config. Needed property is [%s].', 'magicShieldLuck'));
                    }
                } else {
                    throw new Exception(sprintf('Objects of type Beast cannot have skills. Please set the property of beasts skills to false in config file.'));
                }
            }
        }
        else{
            throw new Exception(sprintf('Required skill not available in config. Needed property is [%s].', 'hasDefenceSkills'));
        }
   }

    public function getRandomNumber(int $min, int $max): int
    {
        return mt_rand($min, $max);
    }
}
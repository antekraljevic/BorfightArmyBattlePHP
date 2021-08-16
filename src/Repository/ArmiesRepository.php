<?php

namespace App\Repository;

use App\Entity\Armies;
use App\Factory\MainFactory;

class ArmiesRepository
{
    public function engageBattle(Armies $armies, array $log): array
    {
        $isBattleOver = false;
        $numberOfClashes = 0;
        $result = array();

        while (!$isBattleOver) {
            $numberOfClashes++;

            $log[] = 'Clash #' . $numberOfClashes . ' begins!';

            $result = $this->initiateClash($armies, $log);

            $armies = $this->getFactory()->createArmies($result['armyOne'], $result['armyTwo']);
            $log = $result['log'];

            $log[] = 'Clash #' . $numberOfClashes . ' is over.';
            $log[] = '-----------------------------------';
            if ($armies->armyOne < 1 || $armies->armyTwo < 1) {
                $isBattleOver = true;
            }
        }
        $armyOne = $armies->armyOne;
        $armyTwo = $armies->armyTwo;

        if($armyTwo < 1) {
            $log[] = 'Battle is over!';
            $log[] = 'ArmyOne won!';
            return $log;
        }
        elseif($armyOne < 1) {
            $log[] = 'Battle is over!';
            $log[] = 'ArmyTwo won!';
            return $log;
        }
        else {
            $log[] = 'Unexpected error.';
            return $log;
        }
    }

    private function initiateClash(Armies $armies, array $log): array
    {
        $earthquakeChance = rand(1, 100);
        if($earthquakeChance <= 10)
        {
            $log[] = 'EARTHQUAKE!';
            $prcntgCsltsArmyOne = rand(10, 15);
            $prcntgCsltsArmyTwo = rand(10, 15);

            $armyOneSoldiersBefore = $armies->armyOne;
            $armyTwoSoldiersBefore = $armies->armyTwo;

            $armies = $this->takeCasualties($armies, $prcntgCsltsArmyOne, $prcntgCsltsArmyTwo);

            $log[] = 'Eearthquake killed ' . $armyOneSoldiersBefore - $armies->armyOne . ' soldiers of ArmyOne and ' . $armyTwoSoldiersBefore - $armies->armyTwo . ' soldiers of ArmyTwo.';
            $log[] = 'ArmyOne has ' . $armies->armyOne . ' soldiers remaining. ArmyTwo has ' . $armies->armyTwo . ' soldiers remaining.';

            if($armies->armyTwo < 1) {
                return [
                    'armyOne' => $armies->armyOne,
                    'armyTwo' => $armies->armyTwo,
                    'log' => $log,
                ];
            }
            elseif($armies->armyOne < 1) {
                return [
                    'armyOne' => $armies->armyOne,
                    'armyTwo' => $armies->armyTwo,
                    'log' => $log,
                ];
            }
        }

        $log[] = 'BATTLE!';
        $prcntgCsltsArmyOne = rand(10, 15);
        $prcntgCsltsArmyTwo = rand(10, 15);

        $armyOneSoldiersBefore = $armies->armyOne;
        $armyTwoSoldiersBefore = $armies->armyTwo;

        $armies = $this->takeCasualties($armies, $prcntgCsltsArmyOne, $prcntgCsltsArmyTwo);

        $log[] = 'Battle killed ' . $armyOneSoldiersBefore - $armies->armyOne . ' soldiers of ArmyOne and ' . $armyTwoSoldiersBefore - $armies->armyTwo . ' soldiers of ArmyTwo.';
        $log[] = 'ArmyOne has ' . $armies->armyOne . ' soldiers remaining. ArmyTwo has ' . $armies->armyTwo . ' soldiers remaining.';

        $result = [
            'armyOne' => $armies->armyOne,
            'armyTwo' => $armies->armyTwo,
            'log' => $log,
        ];

        return $result;
    }

    private function takeCasualties(Armies $armies, int $prcntgCsltsArmyOne, int $prcntgCsltsArmyTwo): Armies
    {
        #echo '<p>' . json_encode($armies) . '</p>';
        $casualtiesArmyOne = intdiv($prcntgCsltsArmyOne * $armies->armyOne, 100);
        $casualtiesArmyTwo = intdiv($prcntgCsltsArmyTwo * $armies->armyTwo, 100);

        if ($armies->armyOne <= 10) {
            $casualtiesArmyOne = rand(1, $armies->armyOne);
        }

        if ($armies->armyTwo <= 10) {
            $casualtiesArmyTwo = rand(1, $armies->armyTwo);
        }

        return $this->getFactory()->createArmies($armies->armyOne - $casualtiesArmyOne, $armies->armyTwo - $casualtiesArmyTwo);
    }

    private function getFactory()
    {
        return new MainFactory();
    }
}
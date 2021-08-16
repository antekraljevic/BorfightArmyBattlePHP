<?php

namespace App\Factory;

use App\Entity\Armies;
use App\Repository\ArmiesRepository;

class MainFactory
{
    public static function createArmies(int $armyOne, int $armyTwo): Armies
    {
        return new Armies($armyOne, $armyTwo);
    }

    public static function getRepository()
    {
        return new ArmiesRepository();
    }
}
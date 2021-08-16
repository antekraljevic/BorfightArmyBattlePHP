<?php

namespace App\Entity;

class Armies
{
    public int $armyOne;
    public int $armyTwo;

    public function __construct(int $armyOne, int $armyTwo)
    {
        $this->armyOne = $armyOne;
        $this->armyTwo = $armyTwo;
    }

    public function getArmyOne(): int
    {
        return $this->armyOne;
    }

    public function setArmyOne(int $armyOne): void
    {
        $this->armyOne = $armyOne;
    }

    public function getArmyTwo(): int
    {
        return $this->armyTwo;
    }

    public function setArmyTwo(int $armyTwo): void
    {
        $this->armyTwo = $armyTwo;
    }
}
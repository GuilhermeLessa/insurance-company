<?php

namespace App\Domain\Entities\AgeLoad;

use App\Domain\Entities\AgeLoad\AgeLoadInterface;

class AgeLoadHardcoded implements AgeLoadInterface
{

    private array $fares = [
        30 => 0.6,
        40 => 0.7,
        50 => 0.8,
        60 => 0.9,
        70 => 1,
    ];

    function __construct()
    {
        ksort($this->fares, SORT_NUMERIC);
    }

    function getFare(int $age): float
    {
        foreach ($this->fares as $max_age => $fare) {
            if ($age <= $max_age) {
                return $fare;
            }
        }
        return end($this->fares);
    }
}

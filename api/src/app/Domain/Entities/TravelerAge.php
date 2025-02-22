<?php

namespace App\Domain\Entities;

use App\Domain\Exceptions\InvalidAgeException;

class TravelerAge
{

    private int $age = 0;
    private float $load = 0;

    function __construct(
        int $age
    ) {
        if ($age < 0) {
            throw new InvalidAgeException("Age must be zero or greater");
        }

        $this->age = $age;
        $this->load = $this->_getLoad();
    }

    function getAge(): int
    {
        return $this->age;
    }

    function getLoad(): float
    {
        return $this->load;
    }

    private function _getLoad(): float
    {
        if ($this->age < 31) {
            return 0.6;
        }
        if ($this->age < 41) {
            return 0.7;
        }
        if ($this->age < 51) {
            return 0.8;
        }
        if ($this->age < 61) {
            return 0.9;
        }
        return 1;
    }
}

<?php

namespace App\Domain\Entities\AgeLoad;

interface AgeLoadInterface
{
    public function getFare(int $age): float;
}

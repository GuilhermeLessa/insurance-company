<?php

namespace App\Domain\Entities\AgeLoad;

use App\Domain\Entities\AgeLoad\AgeLoadInterface;

class AgeLoadCached implements AgeLoadInterface
{

    private array $fares = [];

    function __construct(
        //Cache $cache
    )
    {
        //$this->fares = $cache->getFares();
    }

    function getFare(int $age): float
    {
        /*
            Just an example of different implementation 
            of age load using providers to easily switch 
            betweeen cache, database or hardcode
        */
        return end($this->fares);
    }
}

<?php

namespace App\Domain\Entities;

class Traveler
{

    private TravelerAge $age;
    private TravelPeriod $travel_period;
    private float $insuranceCoast = 0;

    function __construct(
        TravelerAge $age,
        TravelPeriod $travel_period
    ) {
        $this->age = $age;
        $this->travel_period = $travel_period;
        $this->insuranceCoast = $this->_getInsuranceCoast();
    }

    function getTravelerAge(): TravelerAge
    {
        return $this->age;
    }

    function getTravelPeriod(): TravelPeriod
    {
        return $this->travel_period;
    }

    function getInsuranceCoast(): float
    {
        return $this->insuranceCoast;
    }

    private function _getInsuranceCoast(): float
    {
        $coast = Quotation::RATE *
            $this->age->getLoad() *
            $this->travel_period->getLength();

        return round($coast * 10) / 10;
    }
}

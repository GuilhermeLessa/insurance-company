<?php

namespace App\Domain\Entities;

use DateTime;

use App\Domain\Entities\AgeLoad\AgeLoadInterface;
use DomainException;

class PersonalQuotation
{

    private int $age = 0;
    private float $total = 0;
    private float $age_load_fare = 0;

    function __construct(
        AgeLoadInterface $age_load,
        int $age,
        Datetime $start_date,
        Datetime $end_date
    ) {
        if ($age < 0) {
            throw new DomainException("Age must be zero or greater");
        }
        if ($end_date < $start_date) {
            throw new DomainException("End date must be after start date");
        }

        $this->age = $age;
        $this->age_load_fare = $age_load->getFare($age);
        $trip_length = $start_date->diff($end_date)->days + 1;
        $this->total = Quotation::RATE * $this->age_load_fare * $trip_length;
    }

    function getAge(): int
    {
        return $this->age;
    }

    function getAgeLoadFare(): float
    {
        return $this->age_load_fare;
    }

    function getTotal(): float
    {
        return round($this->total * 10) / 10;
    }
}

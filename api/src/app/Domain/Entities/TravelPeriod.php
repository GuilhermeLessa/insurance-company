<?php

namespace App\Domain\Entities;

use DateTime;

use App\Domain\Exceptions\InvalidDateRangeException;

class TravelPeriod
{
    private DateTime $start_date;
    private DateTime $end_date;
    private int $length = 1;

    function __construct(
        DateTime $start_date,
        DateTime $end_date
    ) {
        if ($end_date < $start_date) {
            throw new InvalidDateRangeException("End date must be the equal or after start date");
        }

        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->length = $start_date->diff($end_date)->days + 1;
    }

    function getStartDate(): DateTime
    {
        return $this->start_date;
    }

    function getEndDate(): DateTime
    {
        return $this->end_date;
    }

    function getLength(): int
    {
        return $this->length;
    }
}

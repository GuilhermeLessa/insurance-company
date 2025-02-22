<?php

namespace Tests\Domain;

use Illuminate\Foundation\Testing\TestCase;
use DateTime;

use App\Domain\Entities\TravelPeriod;
use App\Domain\Exceptions\InvalidDateRangeException;

class TravelPeriodTest extends TestCase
{

    public function test_invalid_travel_period(): void
    {
        $this->expectException(InvalidDateRangeException::class);
        new TravelPeriod(
            new DateTime("2025-03-30"),
            new DateTime("2025-02-28")
        );
    }

    public function test_travel_period(): void
    {
        $start_date = new DateTime("2025-03-01");
        $end_date = new DateTime("2025-03-30");

        $travel_period = new TravelPeriod(
            $start_date,
            $end_date
        );

        $this->assertEquals(
            $travel_period->getStartDate(),
            $start_date
        );
        $this->assertEquals(
            $travel_period->getEndDate(),
            $end_date
        );
    }

    public function test_travel_period_length(): void
    {
        $travel_period = new TravelPeriod(
            new DateTime("2025-03-01"),
            new DateTime("2025-03-30")
        );
        $this->assertEquals(
            $travel_period->getLength(),
            30
        );

        $travel_period = new TravelPeriod(
            new DateTime("2025-03-01"),
            new DateTime("2025-03-01")
        );
        $this->assertEquals(
            $travel_period->getLength(),
            1
        );
    }
}

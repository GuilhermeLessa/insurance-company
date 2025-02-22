<?php

namespace Tests\Domain;

use Illuminate\Foundation\Testing\TestCase;
use DateTime;

use App\Domain\Entities\Traveler;
use App\Domain\Entities\TravelerAge;
use App\Domain\Entities\TravelPeriod;

class TravelerTest extends TestCase
{

    public function test_traveler(): void
    {
        $traveler_age = new TravelerAge(29);

        $travel_period = new TravelPeriod(
            new DateTime("2025-03-01"),
            new DateTime("2025-03-30")
        );

        $traveler = new Traveler($traveler_age, $travel_period);

        $this->assertSame($traveler_age, $traveler->getTravelerAge());
        $this->assertSame($travel_period, $traveler->getTravelPeriod());
    }

    public function test_traveler_insurance_coast(): void
    {
        $traveler = new Traveler(
            new TravelerAge(29),
            new TravelPeriod(
                new DateTime("2025-03-01"),
                new DateTime("2025-03-30")
            )
        );

        $this->assertEquals($traveler->getInsuranceCoast(), 54);
    }
}

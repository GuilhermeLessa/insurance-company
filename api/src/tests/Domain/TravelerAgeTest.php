<?php

namespace Tests\Domain;

use Illuminate\Foundation\Testing\TestCase;

use App\Domain\Entities\TravelerAge;
use App\Domain\Exceptions\InvalidAgeException;

class TravelerAgeTest extends TestCase
{

    public function test_invalid_traveler_age(): void
    {
        $this->expectException(InvalidAgeException::class);
        new TravelerAge(-1);
    }

    public function test_traveler_age(): void
    {
        $travelerAge = new TravelerAge(18);
        $this->assertEquals(
            $travelerAge->getAge(),
            18
        );
    }

    public function test_traveler_age_load(): void
    {
        $travelerAge = new TravelerAge(0);
        $this->assertEquals(
            $travelerAge->getLoad(),
            0.6
        );

        $travelerAge = new TravelerAge(30);
        $this->assertEquals(
            $travelerAge->getLoad(),
            0.6
        );

        $travelerAge = new TravelerAge(31);
        $this->assertEquals(
            $travelerAge->getLoad(),
            0.7
        );

        $travelerAge = new TravelerAge(40);
        $this->assertEquals(
            $travelerAge->getLoad(),
            0.7
        );

        $travelerAge = new TravelerAge(41);
        $this->assertEquals(
            $travelerAge->getLoad(),
            0.8
        );

        $travelerAge = new TravelerAge(50);
        $this->assertEquals(
            $travelerAge->getLoad(),
            0.8
        );

        $travelerAge = new TravelerAge(51);
        $this->assertEquals(
            $travelerAge->getLoad(),
            0.9
        );

        $travelerAge = new TravelerAge(60);
        $this->assertEquals(
            $travelerAge->getLoad(),
            0.9
        );

        $travelerAge = new TravelerAge(61);
        $this->assertEquals(
            $travelerAge->getLoad(),
            1
        );

        $travelerAge = new TravelerAge(999);
        $this->assertEquals(
            $travelerAge->getLoad(),
            1
        );
    }
}

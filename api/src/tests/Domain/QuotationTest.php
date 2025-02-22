<?php

namespace Tests\Domain;

use DateTime;
use Illuminate\Foundation\Testing\TestCase;

use App\Domain\Exceptions\InvalidCurrencyIdException;
use App\Domain\Exceptions\InvalidAgentIdException;
use App\Domain\Entities\Traveler;
use App\Domain\Entities\TravelerAge;
use App\Domain\Entities\TravelPeriod;
use App\Domain\Entities\Quotation;

class QuotationTest extends TestCase
{

    public function test_invalid_currency_id(): void
    {
        $this->expectException(InvalidCurrencyIdException::class);
        new Quotation("BRL", 1);
    }

    public function test_valid_currency_ids(): void
    {
        $quotation = new Quotation("EUR", 1);
        $this->assertEquals($quotation->getCurrencyId(), "EUR");

        $quotation = new Quotation("GBP", 1);
        $this->assertEquals($quotation->getCurrencyId(), "GBP");

        $quotation = new Quotation("USD", 1);
        $this->assertEquals($quotation->getCurrencyId(), "USD");
    }

    public function test_invalid_agent_id(): void
    {
        $this->expectException(InvalidAgentIdException::class);
        new Quotation("EUR", -1);

        $this->expectException(InvalidAgentIdException::class);
        new Quotation("EUR", "a");
    }

    public function test_quotation(): void
    {
        $traveler1 = new Traveler(
            new TravelerAge(29),
            new TravelPeriod(
                new DateTime("2025-03-01"),
                new DateTime("2025-03-30")
            )
        );

        $traveler2 = new Traveler(
            new TravelerAge(39),
            new TravelPeriod(
                new DateTime("2025-03-01"),
                new DateTime("2025-03-30")
            )
        );

        $traveler3 = new Traveler(
            new TravelerAge(49),
            new TravelPeriod(
                new DateTime("2025-03-01"),
                new DateTime("2025-03-30")
            )
        );

        $quotation = new Quotation("EUR", 1);
        $quotation->addTraveler($traveler1);
        $quotation->addTraveler($traveler2);
        $quotation->addTraveler($traveler3);

        $this->assertEquals($quotation->getCurrencyId(), "EUR");
        $this->assertEquals($quotation->getAgentId(), 1);
        $this->assertSame(
            $quotation->getTravelers(),
            [$traveler1, $traveler2, $traveler3]
        );
        $this->assertEquals(
            $quotation->getTotal(),
            189
        );
    }
}

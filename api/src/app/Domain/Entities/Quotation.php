<?php

namespace App\Domain\Entities;

use DateTime;

use App\Domain\Exceptions\InvalidCurrencyIdException;
use App\Domain\Exceptions\InvalidAgentIdException;
use App\Domain\Entities\Traveler;

class Quotation
{

    const RATE = 3;
    private string $currency_id;
    private float $total = 0;
    private int $agent_id;

    /** @var Traveler[] $travelers */
    private array $travelers = [];

    function __construct(
        string $currency_id,
        int $agent_id
    ) {
        if (!in_array($currency_id, ['EUR', 'GBP', 'USD'])) {
            throw new InvalidCurrencyIdException('Currency id must be either “EUR”, ”GBP” or “USD"');
        }
        if (!(intval($agent_id) > 0)) {
            throw new InvalidAgentIdException("Agent id must be a valid integer greater then zero");
        }

        $this->currency_id = $currency_id;
        $this->agent_id = $agent_id;
    }

    function getCurrencyId(): string
    {
        return $this->currency_id;
    }

    function addTraveler(Traveler $traveler)
    {
        $this->total += $traveler->getInsuranceCoast();
        $this->total = round($this->total * 10) / 10;
        $this->travelers[] = $traveler;
    }

    function getTravelers(): array
    {
        return $this->travelers;
    }

    function getTotal(): float
    {
        return $this->total;
    }

    function getAgentId(): int
    {
        return $this->agent_id;
    }
}

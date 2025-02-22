<?php

namespace App\Domain\Entities;

use DateTime;

use App\Domain\Entities\AgeLoad\AgeLoadInterface;
use App\Domain\Entities\PersonalQuotation;
use DomainException;

class Quotation
{

    const RATE = 3;
    private float $total = 0;

    /** @var PersonalQuotation[] $personalQuotation */
    private array $personalQuotations = [];

    function __construct(
        AgeLoadInterface $age_load,
        array $ages,
        string $currency_id,
        Datetime $start_date,
        Datetime $end_date
    ) {
        if (!in_array($currency_id, ['EUR', 'GBP', 'USD'])) {
            throw new DomainException('Currency id must be either “EUR”, ”GBP” or “USD"');
        }

        foreach ($ages as $age) {
            $personalQuotation = new PersonalQuotation($age_load, $age, $start_date, $end_date);
            $this->total += $personalQuotation->getTotal();
            $this->personalQuotations[] = $personalQuotation;
        }
    }

    function getPersonalQuotations(): array
    {
        return $this->personalQuotations;
    }

    function getTotal(): float
    {
        return round($this->total * 10) / 10;
    }
}

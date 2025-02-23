<?php

namespace App\UseCases;

class QuotationUseCaseOutput
{

    private float $total;
    private string $currency_id;
    private int $quotation_id;

    function __construct(
        float $total,
        string $currency_id,
        int $quotation_id
    ) {
        $this->total = $total;
        $this->currency_id = $currency_id;
        $this->quotation_id = $quotation_id;
    }

    function getTotal(): float
    {
        return $this->total;
    }

    function getCurrencyId(): string
    {
        return $this->currency_id;
    }

    function getQuotationId(): int
    {
        return $this->quotation_id;
    }
}

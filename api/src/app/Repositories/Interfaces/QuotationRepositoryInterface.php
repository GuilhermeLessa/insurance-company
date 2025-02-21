<?php

namespace App\Repositories\Interfaces;

use DateTime;

use App\Models\QuotationModel;

interface QuotationRepositoryInterface
{
    public function save(
        int $rate,
        string $currency_id,
        DateTime $start_date,
        DateTime $end_date,
        float $total,
        string $agentId
    ): QuotationModel;
}

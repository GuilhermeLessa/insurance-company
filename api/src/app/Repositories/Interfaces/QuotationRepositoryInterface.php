<?php

namespace App\Repositories\Interfaces;

use App\Models\QuotationModel;

interface QuotationRepositoryInterface
{
    public function save(
        int $rate,
        string $currency_id,
        float $total,
        int $agent_id
    ): QuotationModel;
}

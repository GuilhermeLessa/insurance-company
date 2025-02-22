<?php

namespace App\Repositories\Interfaces;

use DateTime;

use App\Models\TravelerQuotationModel;

interface TravelerQuotationRepositoryInterface
{
    public function save(
        int $quotation_id,
        DateTime $start_date,
        DateTime $end_date,
        int $age,
        float $age_load_fare,
        float $total
    ): TravelerQuotationModel;
}

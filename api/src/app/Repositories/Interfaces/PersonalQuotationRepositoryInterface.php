<?php

namespace App\Repositories\Interfaces;

use App\Models\PersonalQuotationModel;

interface PersonalQuotationRepositoryInterface
{
    public function save(
        int $quotation_id,
        int $age,
        float $age_load_fare,
        float $total
    ): PersonalQuotationModel;
}

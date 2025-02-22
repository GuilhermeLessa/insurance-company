<?php

namespace App\Repositories;

use App\Repositories\Interfaces\QuotationRepositoryInterface;
use App\Models\QuotationModel;

class QuotationRepository implements QuotationRepositoryInterface
{

    public function save(
        int $rate,
        string $currency_id,
        float $total,
        int $agent_id
    ): QuotationModel {

        $quotation = new QuotationModel();
        $quotation->rate = $rate;
        $quotation->currency_id = $currency_id;
        $quotation->total = $total;
        $quotation->agent_id = $agent_id;
        $quotation->save();

        return $quotation;
    }
}

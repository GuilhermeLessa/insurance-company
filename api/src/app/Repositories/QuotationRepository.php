<?php

namespace App\Repositories;

use DateTime;

use App\Repositories\Interfaces\QuotationRepositoryInterface;
use App\Models\QuotationModel;

class QuotationRepository implements QuotationRepositoryInterface
{

    public function save(
        int $rate,
        string $currency_id,
        DateTime $start_date,
        DateTime $end_date,
        float $total,
        string $agentId
    ): QuotationModel {

        $quotation = new QuotationModel();
        $quotation->rate = $rate;
        $quotation->currency_id = $currency_id;
        $quotation->start_date = $start_date;
        $quotation->end_date = $end_date;
        $quotation->total = $total;
        $quotation->agent_id = $agentId;
        $quotation->save();

        return $quotation;
    }
}

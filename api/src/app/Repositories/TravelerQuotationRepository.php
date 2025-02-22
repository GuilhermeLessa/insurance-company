<?php

namespace App\Repositories;

use DateTime;

use App\Repositories\Interfaces\TravelerQuotationRepositoryInterface;
use App\Models\TravelerQuotationModel;

class TravelerQuotationRepository implements TravelerQuotationRepositoryInterface
{

    public function save(
        int $quotation_id,
        DateTime $start_date,
        DateTime $end_date,
        int $age,
        float $age_load_fare,
        float $total
    ): TravelerQuotationModel {

        $travelerQuotation = new TravelerQuotationModel();
        $travelerQuotation->quotation_id = $quotation_id;
        $travelerQuotation->start_date = $start_date;
        $travelerQuotation->end_date = $end_date;
        $travelerQuotation->age = $age;
        $travelerQuotation->age_load_fare = $age_load_fare;
        $travelerQuotation->total = $total;
        $travelerQuotation->timestamps = false;
        $travelerQuotation->save();

        return $travelerQuotation;
    }
}

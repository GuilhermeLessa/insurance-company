<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PersonalQuotationRepositoryInterface;
use App\Models\PersonalQuotationModel;

class PersonalQuotationRepository implements PersonalQuotationRepositoryInterface
{

    public function save(
        int $quotation_id,
        int $age,
        float $age_load_fare,
        float $total
    ): PersonalQuotationModel {

        $personalQuotation = new PersonalQuotationModel();
        $personalQuotation->quotation_id = $quotation_id;
        $personalQuotation->age = $age;
        $personalQuotation->age_load_fare = $age_load_fare;
        $personalQuotation->total = $total;
        $personalQuotation->timestamps = false;
        $personalQuotation->save();

        return $personalQuotation;
    }
}

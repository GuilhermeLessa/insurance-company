<?php

namespace App\Http\Transformers;

use Illuminate\Support\Facades\Auth;
use DateTime;

class QuotationRequestTransformer implements TransformerInterface
{

    function transform(array $data): array
    {
        return [
            'ages' => array_map('intval', array_filter(explode(',', $data['age']))),
            'currency_id' => $data['currency_id'],
            'start_date' => DateTime::createFromFormat('Y-m-d', $data['start_date']),
            'end_date' => DateTime::createFromFormat('Y-m-d', $data['end_date']),
            'agent_id' => Auth::id()
        ];
    }
}

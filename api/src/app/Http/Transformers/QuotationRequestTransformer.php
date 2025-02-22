<?php

namespace App\Http\Transformers;

use Illuminate\Support\Facades\Auth;
use DateTime;

class QuotationRequestTransformer implements TransformerInterface
{

    private int $agent_id;

    function __construct(
        $agent_id,
    ) {
        $this->agent_id = $agent_id;
    }

    function transform(array $data): array
    {
        $ages = array_map('intval', array_filter(explode(',', $data['age'])));
        $start_data = DateTime::createFromFormat('Y-m-d', $data['start_date'])
            ->setTime(0, 0, 0);
        $end_date = DateTime::createFromFormat('Y-m-d', $data['end_date'])
            ->setTime(0, 0, 0);

        return [
            'ages' => $ages,
            'currency_id' => $data['currency_id'],
            'start_date' => $start_data,
            'end_date' => $end_date,
            'agent_id' => $this->agent_id,
        ];
    }
}

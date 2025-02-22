<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Http\Transformers\QuotationRequestTransformer;

class QuotationRequest extends FormRequest
{

    private QuotationRequestTransformer $transformer;

    function __construct(
        QuotationRequestTransformer $transformer,
    ) {
        $this->transformer = $transformer;
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'age' => 'required|regex:/^\d+(,\d+)*$/',
            'currency_id' => 'required|in:EUR,GBP,USD',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();
        return $this->transformer->transform($data);
    }
}

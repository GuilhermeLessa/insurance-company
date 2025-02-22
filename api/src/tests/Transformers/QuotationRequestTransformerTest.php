<?php

namespace Tests\Transformers;

use Illuminate\Foundation\Testing\TestCase;
use DateTime;

use App\Http\Transformers\QuotationRequestTransformer;

class QuotationRequestTransformerTest extends TestCase
{

    public function test_quotation_request_transformer(): void
    {
        $transformer = new QuotationRequestTransformer(1);

        $data = $transformer->transform([
            "age" => "29,39",
            "currency_id" => "EUR",
            "start_date" => "2025-03-01",
            "end_date" => "2025-03-30",
            "agent_id" => 1,
            "should_be_removed" => ""
        ]);

        $this->assertEquals($data["ages"], [29, 39]);
        $this->assertEquals($data["currency_id"], "EUR");
        $this->assertEquals($data["start_date"], new DateTime("2025-03-01"));
        $this->assertEquals($data["end_date"], new DateTime("2025-03-30"));
        $this->assertEquals($data["agent_id"], 1);
        $this->assertArrayNotHasKey("should_be_removed", $data);
    }
}

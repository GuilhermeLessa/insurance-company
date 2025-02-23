<?php

namespace Tests\UseCases;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DateTime;

use App\Repositories\QuotationRepository;
use App\Repositories\TravelerQuotationRepository;
use App\UseCases\QuotationUseCase;
use App\UseCases\QuotationUseCaseOutput;

class QuotationUseCaseTest extends TestCase
{

    use RefreshDatabase;

    public function test_quotation_use_case(): void
    {
        $use_case = new QuotationUseCase(
            new QuotationRepository(),
            new TravelerQuotationRepository()
        );

        /** @var QuotationUseCaseOutput $output */
        $output = $use_case->execute(
            [29, 39],
            "EUR",
            new DateTime("2024-03-01"),
            new DateTime("2024-03-30"),
            1
        );

        $this->assertEquals($output->getTotal(), 117);
        $this->assertEquals($output->getCurrencyId(), "EUR");
        $this->assertEquals($output->getQuotationId(), 2);
    }
}

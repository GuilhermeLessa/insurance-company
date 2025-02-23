<?php

namespace Tests\UseCases;

use App\Domain\Exceptions\Base\DomainException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Mockery;
use TypeError;

use App\Http\Controllers\QuotationController;
use App\Http\Requests\QuotationRequest;
use App\Http\Transformers\QuotationRequestTransformer;
use App\Repositories\QuotationRepository;
use App\Repositories\TravelerQuotationRepository;
use App\UseCases\QuotationUseCase;

class QuotationControllerTest extends TestCase
{

    use RefreshDatabase;

    public function test_quotation_endpoint(): void
    {
        $transformer = new QuotationRequestTransformer(1);

        $request_mock = Mockery::mock(QuotationRequest::class, [$transformer])
            ->makePartial();

        $request_mock->shouldReceive('parentValidated')
            ->once()
            ->andReturn([
                "age" => "29,39",
                "currency_id" => "EUR",
                "start_date" => "2025-03-01",
                "end_date" => "2025-03-30"
            ]);

        $use_case = new QuotationUseCase(
            new QuotationRepository(),
            new TravelerQuotationRepository()
        );

        $controller = new QuotationController($use_case);

        /** @var Illuminate\Http\JsonResponse $response */
        $response = $controller->quote($request_mock);

        $data = json_decode($response->content());

        $this->assertEquals($data->total, 117);
        $this->assertEquals($data->currency_id, "EUR");
        $this->assertEquals($data->quotation_id, 1);
    }

    public function test_quotation_endpoint_domain_exception(): void
    {
        $transformer = new QuotationRequestTransformer(1);

        $request_mock = Mockery::mock(QuotationRequest::class, [$transformer])
            ->makePartial();

        $request_mock->shouldReceive('parentValidated')
            ->once()
            ->andReturn([
                "age" => "29,39",
                "currency_id" => "EUR",
                "start_date" => "2025-03-01",
                "end_date" => "2025-02-28"
            ]);

        $use_case = new QuotationUseCase(
            new QuotationRepository(),
            new TravelerQuotationRepository()
        );

        $controller = new QuotationController($use_case);

        /** @var Illuminate\Http\JsonResponse $response */
        $response = $controller->quote($request_mock);
        $data = json_decode($response->content());

        $this->assertEquals($response->getStatusCode(), 422);
        $this->assertEquals($data->message, "End date must be the equal or after start date");
    }

    public function test_quotation_endpoint_application_exception(): void
    {
        $transformer = new QuotationRequestTransformer(1);

        $request_mock = Mockery::mock(QuotationRequest::class, [$transformer])
            ->makePartial();

        $request_mock->shouldReceive('parentValidated')
            ->once()
            ->andReturn([
                "age" => "29,39",
                "currency_id" => null,
                "start_date" => "2025-03-01",
                "end_date" => "2025-03-30"
            ]);

        $use_case = new QuotationUseCase(
            new QuotationRepository(),
            new TravelerQuotationRepository()
        );

        $controller = new QuotationController($use_case);

        /** @var Illuminate\Http\JsonResponse $response */
        $response = $controller->quote($request_mock);
        $data = json_decode($response->content());

        $this->assertEquals($response->getStatusCode(), 500);
        $this->assertNotEmpty($data->message);
    }
}

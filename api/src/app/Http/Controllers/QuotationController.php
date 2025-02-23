<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Throwable;

use App\UseCases\QuotationUseCase;
use App\UseCases\QuotationUseCaseOutput;
use App\Domain\Exceptions\Base\DomainException;
use App\Http\Requests\QuotationRequest;

class QuotationController extends Controller
{

    private QuotationUseCase $quotationUseCase;

    function __construct(
        QuotationUseCase $quotationUseCase,
    ) {
        $this->quotationUseCase = $quotationUseCase;
    }

    public function quote(QuotationRequest $request): JsonResponse
    {

        [
            'ages' => $ages,
            'currency_id' => $currency_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'agent_id' => $agent_id,
        ] = $request->validated();

        try {

            /** @var QuotationUseCaseOutput $output */
            $output = $this->quotationUseCase->execute(
                $ages,
                $currency_id,
                $start_date,
                $end_date,
                $agent_id
            );

            return response()->json([
                'total' => $output->getTotal(),
                'currency_id' => $output->getCurrencyId(),
                'quotation_id' => $output->getQuotationId(),
            ]);
        } catch (DomainException $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 422);
        } catch (Throwable $e) {
            return response()->json([
                "message" => "Error quoting."
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use DateTime;

use App\UseCases\QuotationUseCase;
use App\UseCases\QuotationUseCaseOutput;
use App\Domain\Exceptions\Base\DomainException;

class QuotationController extends Controller
{

    private QuotationUseCase $quotationUseCase;

    function __construct(
        QuotationUseCase $quotationUseCase
    ) {
        $this->quotationUseCase = $quotationUseCase;
    }

    public function quote(Request $request): JsonResponse
    {

        $request->validate([
            'age' => 'required|regex:/^\d+(,\d+)*$/',
            'currency_id' => 'required|in:EUR,GBP,USD',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
        ]);

        try {
            $age = $request->get('age');
            $currency_id = $request->get('currency_id');
            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');

            $ages = array_map('intval', array_filter(explode(',', $age)));
            $start_date = DateTime::createFromFormat('Y-m-d', $start_date);
            $end_date = DateTime::createFromFormat('Y-m-d', $end_date);

            $agentId = Auth::id();

            /** @var QuotationUseCaseOutput $output */
            $output = $this->quotationUseCase->execute(
                $ages,
                $currency_id,
                $start_date,
                $end_date,
                $agentId
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
        } catch (Exception $e) {
            return response()->json([
                "message" => "Error quoting."
            ], 500);
        }
    }
}

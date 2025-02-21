<?php

namespace App\UseCases;

use DateTime;

use App\Repositories\QuotationRepository;
use App\Repositories\PersonalQuotationRepository;
use App\Domain\Entities\Quotation;
use App\Domain\Entities\PersonalQuotation;
use App\Models\QuotationModel;

class QuotationUseCase
{

    private QuotationRepository $quotationRepository;
    private PersonalQuotationRepository $personalQuotationRepository;

    function __construct(
        QuotationRepository $quotationRepository,
        PersonalQuotationRepository $personalQuotationRepository,
    ) {
        $this->quotationRepository = $quotationRepository;
        $this->personalQuotationRepository = $personalQuotationRepository;
    }

    function execute(
        array $ages,
        string $currency_id,
        Datetime $start_date,
        Datetime $end_date,
        string $agentId,
    ): QuotationUseCaseOutput {

        $quotation = new Quotation($ages, $currency_id, $start_date, $end_date);
        $quotationTotal = $quotation->getTotal();

        /** @var QuotationModel $quotationModel */
        $quotationModel = $this->quotationRepository->save(
            Quotation::RATE,
            $currency_id,
            $start_date,
            $end_date,
            $quotationTotal,
            $agentId
        );

        /** @var PersonalQuotation $personalQuotation */
        foreach ($quotation->getPersonalQuotations() as $personalQuotation) {
            $this->personalQuotationRepository->save(
                $quotationModel->id,
                $personalQuotation->getAge(),
                $personalQuotation->getAgeLoadFare(),
                $personalQuotation->getTotal()
            );
        }

        return new QuotationUseCaseOutput(
            $quotationTotal,
            $currency_id,
            $quotationModel->id
        );
    }
}

class QuotationUseCaseOutput
{

    private float $total;
    private string $currency_id;
    private int $quotation_id;

    function __construct(
        float $total,
        string $currency_id,
        int $quotation_id
    ) {
        $this->total = $total;
        $this->currency_id = $currency_id;
        $this->quotation_id = $quotation_id;
    }

    function getTotal(): float
    {
        return $this->total;
    }

    function getCurrencyId(): string
    {
        return $this->currency_id;
    }

    function getQuotationId(): int
    {
        return $this->quotation_id;
    }
}

<?php

namespace App\UseCases;

use DateTime;

use App\Domain\Entities\Quotation;
use App\Domain\Entities\Traveler;
use App\Domain\Entities\TravelerAge;
use App\Domain\Entities\TravelPeriod;
use App\Repositories\QuotationRepository;
use App\Repositories\TravelerQuotationRepository;
use App\Repositories\Interfaces\QuotationRepositoryInterface;
use App\Repositories\Interfaces\TravelerQuotationRepositoryInterface;
use App\Models\QuotationModel;

class QuotationUseCase
{

    private QuotationRepositoryInterface $quotationRepository;
    private TravelerQuotationRepositoryInterface $travelerQuotationRepository;

    function __construct(
        QuotationRepository $quotationRepository,
        TravelerQuotationRepository $travelerQuotationRepository,
    ) {
        $this->quotationRepository = $quotationRepository;
        $this->travelerQuotationRepository = $travelerQuotationRepository;
    }

    function execute(
        array $ages,
        string $currency_id,
        DateTime $start_date,
        DateTime $end_date,
        int $agent_id
    ): QuotationUseCaseOutput {

        $quotation = new Quotation($currency_id, $agent_id);

        foreach ($ages as $age) {
            $quotation->addTraveler(
                new Traveler(
                    new TravelerAge($age),
                    new TravelPeriod($start_date, $end_date)
                )
            );
        }

        /** @var QuotationModel $quotationModel */
        $quotationModel = $this->quotationRepository->save(
            Quotation::RATE,
            $quotation->getCurrencyId(),
            $quotation->getTotal(),
            $quotation->getAgentId()
        );

        /** @var Traveler $traveler */
        foreach ($quotation->getTravelers() as $traveler) {
            $this->travelerQuotationRepository->save(
                $quotationModel->id,
                $traveler->getTravelPeriod()->getStartDate(),
                $traveler->getTravelPeriod()->getEndDate(),
                $traveler->getTravelerAge()->getAge(),
                $traveler->getTravelerAge()->getLoad(),
                $traveler->getInsuranceCoast()
            );
        }

        return new QuotationUseCaseOutput(
            $quotation->getTotal(),
            $quotation->getCurrencyId(),
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

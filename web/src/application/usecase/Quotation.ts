import type UseCase from "./UseCase";
import { left, right, type Either } from "../shared/Either";
import type InsuranceApiInterface from "../insurance-api/InsuranceApiInterface";
import type { HttpErrorResponse } from "../http/HttpClient";

export default class Quotation implements UseCase {

    constructor(
        private insuranceApi: InsuranceApiInterface,
    ) { }

    execute(input: QuotationInput): QuotationOutput {
        const { ages, currencyId, startDate, endDate } = input;
        return this.insuranceApi.quotation(ages, currencyId, startDate, endDate);
    }
}

export type QuotationInput = {
    ages: string, currencyId: string, startDate: string, endDate: string, 
};

export type QuotationOutput = Promise<
    Either<
        HttpErrorResponse,
        { total: number, currencyId: "EUR" | "GBP" | "USD", quotationId: number }
    >
>;

import type InsuranceApiApiInterface from "../../application/insurance-api/InsuranceApiInterface";
import type HttpClient from "@/application/http/HttpClient";
import { HttpErrorResponse, InternalServerError, NoContent, OK, Unauthorized, UnprocessableEntity } from "@/application/http/HttpClient";
import { left, right, type Either } from "@/application/shared/Either";

export default class InsuranceApi implements InsuranceApiApiInterface {

    private constructor(
        private httpClient: HttpClient,
    ) { }

    static async create(
        httpClient: HttpClient,
    ): Promise<InsuranceApi | void> {
        const response = await httpClient.get("/sanctum/csrf-cookie");
        if (response.isRight()) {
            return new InsuranceApi(httpClient);
        }
    }

    login(email: string, password: string): Promise<
        Either<
            Unauthorized | HttpErrorResponse,
            NoContent
        >
    > {
        return this.httpClient.post("/login", { email, password });
    }

    logout(): Promise<
        Either<
            Unauthorized | HttpErrorResponse,
            NoContent
        >
    > {
        return this.httpClient.post("/logout");
    }

    isAuthenticated(): Promise<
        Either<
            Unauthorized | HttpErrorResponse,
            NoContent
        >
    > {
        return this.httpClient.get("/authenticated");
    }

    getAuthenticatedUser(): Promise<
        Either<
            Unauthorized | HttpErrorResponse,
            OK
        >
    > {
        return this.httpClient.get("/api/user");
    }

    register(name: string, email: string, password: string, passwordConfirmation: string): Promise<
        Either<
            HttpErrorResponse,
            NoContent
        >
    > {
        return this.httpClient.post("/register", { name, email, password, password_confirmation: passwordConfirmation });
    }

    async quotation(ages: string, currencyId: string, startDate: string, endDate: string): Promise<
        Either<
            Unauthorized | UnprocessableEntity | HttpErrorResponse,
            { total: number, currencyId: "EUR"|"GBP"|"USD", quotationId: number }
        >
    > {
        const quotationOrError = await this.httpClient.post("/api/quotation", { 
            age: ages, 
            currency_id: currencyId, 
            start_date: startDate,
            end_date: endDate
        });
        
        if (quotationOrError.isRight()) {
            const { total, currency_id, quotation_id } = quotationOrError.value.data;
            return right({
                total, currencyId: currency_id, quotationId: quotation_id
            });
        }

        const error = quotationOrError.value;
        return left(error);
    }

}

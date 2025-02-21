import type { Either } from "@/application/shared/Either";
import type { HttpErrorResponse, NoContent, OK, Unauthorized, UnprocessableEntity } from "../http/HttpClient";

export default interface InsuranceApiInterface {

    login(email: string, password: string): Promise<
        Either<
            Unauthorized | HttpErrorResponse,
            NoContent
        >
    >;

    logout(): Promise<
        Either<
            Unauthorized | HttpErrorResponse,
            NoContent
        >
    >;

    isAuthenticated(): Promise<
        Either<
            Unauthorized | HttpErrorResponse,
            NoContent
        >
    >;

    getAuthenticatedUser(): Promise<
        Either<
            Unauthorized | HttpErrorResponse,
            OK
        >
    >;

    register(name: string, email: string, password: string, passwordConfirmation:string): Promise<
        Either<
            HttpErrorResponse,
            NoContent
        >
    >;

    quotation(ages: string, currencyId: string, startDate: string, endDate: string): Promise<
        Either<
            Unauthorized | UnprocessableEntity | HttpErrorResponse,
            { total: number, currencyId: "EUR"|"GBP"|"USD", quotationId: number }
        >
    >;

}
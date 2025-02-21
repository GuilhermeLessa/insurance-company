import type UseCase from "./UseCase";
import { left, right, type Either } from "../../application/shared/Either";
import type InsuranceApiInterface from "../insurance-api/InsuranceApiInterface";
import type { HttpErrorResponse, Unauthorized } from "../http/HttpClient";

export default class Logout implements UseCase {

    constructor(
        private insuranceApi: InsuranceApiInterface,
    ) { }

    async execute(): LogoutOutput {
        const logoutResult = await this.insuranceApi.logout();
        if (logoutResult.isRight()) {
            return right("Unauthenticated");
        }

        return left(logoutResult.value);
    }
}

export type LogoutOutput = Promise<
    Either<
        Unauthorized | HttpErrorResponse,
        "Unauthenticated"
    >
>;

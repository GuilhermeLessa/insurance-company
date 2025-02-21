import { right, type Either, left } from "@/application/shared/Either";
import type UseCase from "./UseCase";
import type InsuranceApiInterface from "../insurance-api/InsuranceApiInterface";

export default class CheckIsAuthenticated implements UseCase {

    constructor(
        private insuranceApi: InsuranceApiInterface
    ) { }

    async execute(): CheckIsAuthenticatedOutput {
        const authenticatedOrNot = await this.insuranceApi.isAuthenticated();
        if (authenticatedOrNot.isRight()) {
            return right(true);
        }

        return left(false);
    }
}

export type CheckIsAuthenticatedOutput = Promise<
    Either<
        false,
        true
    >
>;

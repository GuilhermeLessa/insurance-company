import type UseCase from "./UseCase";
import { left, right, type Either } from "../../application/shared/Either";
import type InsuranceApiInterface from "../insurance-api/InsuranceApiInterface";
import DomainException from "../exceptions/DomainExceptions";
import type { HttpErrorResponse, Unauthorized } from "../http/HttpClient";

export default class Login implements UseCase {

    constructor(
        private insuranceApi: InsuranceApiInterface,
    ) { }

    async execute(input: LoginInput): LoginOutput {
        const { email, password } = input;

        if (!email) {
            return left(new DomainException("Email is required."));
        }

        if (!password) {
            return left(new DomainException("Password is required."));
        }

        const authenticatedOrUnauthorized = await this.insuranceApi.login(email, password);
        if (authenticatedOrUnauthorized.isRight()) {
            return right("Authenticated");
        }

        const error = authenticatedOrUnauthorized.value;
        return left(error);
    }
}

export type LoginInput = {
    email: string, password: string
};

export type LoginOutput = Promise<
    Either<
        DomainException | Unauthorized | HttpErrorResponse,
        "Authenticated"
    >
>;

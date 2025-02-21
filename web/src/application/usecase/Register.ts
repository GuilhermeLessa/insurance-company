import type UseCase from "./UseCase";
import { left, right, type Either } from "../shared/Either";
import type InsuranceApiInterface from "../insurance-api/InsuranceApiInterface";
import DomainException from "../exceptions/DomainExceptions";
import type { HttpErrorResponse } from "../http/HttpClient";

export default class Register implements UseCase {

    constructor(
        private insuranceApi: InsuranceApiInterface,
    ) { }

    async execute(input: RegisterInput): RegisterOutput {
        const { name, email, password, passwordConfirmation } = input;

        if (!name) {
            return left(new DomainException("Name is required."));
        }

        if (!email) {
            return left(new DomainException("Email is required."));
        }

        if (!password) {
            return left(new DomainException("Password is required."));
        }

        if (!passwordConfirmation) {
            return left(new DomainException("Password confirmation is required."));
        }

        const createdOrError = await this.insuranceApi.register(name, email, password, passwordConfirmation);
        if (createdOrError.isRight()) {
            return right("Created");
        }

        const error = createdOrError.value;
        return left(error);
    }
}

export type RegisterInput = {
    name: string, email: string, password: string, passwordConfirmation: string
};

export type RegisterOutput = Promise<
    Either<
        DomainException | HttpErrorResponse,
        "Created"
    >
>;

<script setup lang="ts">
import { inject, ref } from "vue";
import { useRouter } from "vue-router";
import LogoutButton from "../components/LogoutButton.vue";
import QuotationForm from "../components/QuotationForm.vue";
import Toaster from "../components/Toaster/Toaster.vue";
import CurrencyUtils from "../../utils/CurrencyUtils";
import Logout from "../../application/usecase/Logout";
import Quotation from "../../application/usecase/Quotation";

const router = useRouter();

const toasterQuotations: Toaster = ref();
const toaster: Toaster = ref();

const logoutUseCase: Logout = inject("logoutUseCase");
const quotationUseCase: Quotation = inject("quotationUseCase");

function showQuotation(quotation) {
    const total = CurrencyUtils.format(quotation.currencyId, quotation.total);
    toasterQuotations.value.error(
        `Quotation #${quotation.quotationId}, total ${total}.`,
        "QUOTATION RESULT"
    );
}

async function onSubmit(data: any) {
    const { ages, currencyId, startDate, endDate } = data;
    const quotationOrError = await quotationUseCase.execute({ ages, startDate, endDate, currencyId });

    if (quotationOrError.isRight()) {
        const quotation = quotationOrError.value;
        showQuotation(quotation);
        return;
    }

    const error = quotationOrError.value;
    toaster.value.error(error.message || "Error on quoting.");
}
</script>

<template>
    <div class="container" data-bs-theme="dark">
        <div class="d-flex justify-content-end mb-5">
            <LogoutButton @onClickConfirm="(
                async () => {
                    await logoutUseCase.execute();
                    router.push('/');
                }
            )"></LogoutButton>
        </div>

        <h2 class="mb-5">Quotation</h2>

        <QuotationForm @onSubmit="onSubmit"></QuotationForm>

        <Toaster ref="toasterQuotations" customClass="position-fixed top-0 start-50 translate-middle-x p-3">
        </Toaster>
        <Toaster ref="toaster"></Toaster>
    </div>
</template>

<style scoped>
.container {
    color: white;
    background-color: #363d45;
    padding: 2vw;
}
</style>

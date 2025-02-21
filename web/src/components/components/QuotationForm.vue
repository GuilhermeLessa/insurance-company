<script setup lang="ts">
import { defineEmits, ref } from "vue";
import DateUtils from "../../utils/DateUtils";

const today = (new Date()).toISOString().substring(0, 10);
const nextWeek = DateUtils.addDays(new Date(), 7).toISOString().substring(0, 10);

const defaultValues = {
    ages: "", currencyId: "EUR", startDate: today, endDate: nextWeek,
};

const ages = ref(defaultValues.ages);
const currencyId = ref(defaultValues.currencyId);
const startDate = ref(defaultValues.startDate);
const endDate = ref(defaultValues.endDate);

const filterAges = (() => {
    ages.value = ages.value
        .replace(/[^0-9,]/g, "") //only numbers and commas
        .replace(/,+/g, ","); //remove repeated commas
});

const trimAges = (() => {
    ages.value = ages.value
        .replace(/^,+|,+$/g, ""); //remove begin/end commas
});

const emit = defineEmits(["onSubmit"]);
</script>

<template>
    <div style="display: flex; flex-direction: row; justify-content: space-around;">
        <form class="row" @submit.prevent>
            <div class="col-md-3 mb-3">
                <input type="text" class="form-control form-control-lg" @input="filterAges" v-model="ages"
                    @blur="trimAges" placeholder="Ages sepparated by comma">
            </div>
            <div class="col-md-2 mb-3">
                <select class="form-select form-select-lg mb-3" v-model="currencyId">
                    <option value="EUR">EUR</option>
                    <option value="GBP">GBP</option>
                    <option value="USD">USD</option>
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <input type="text" class="form-control form-control-lg" v-model="startDate" placeholder="Start date">
            </div>
            <div class="col-md-2 mb-3">
                <input type="text" class="form-control form-control-lg" v-model="endDate" placeholder="End date">
            </div>
            <div class="col-md-3 mb-3">
                <button type="button" class="btn btn-primary btn-dark btn-lg" @click="(
                    () => {
                        $emit('onSubmit', { ages, currencyId, startDate, endDate });
                        ages = defaultValues.ages;
                        currencyId = defaultValues.currencyId;
                        startDate = defaultValues.startDate;
                        endDate = defaultValues.endDate;
                    }
                )">Search</button>
            </div>
        </form>
    </div>
</template>
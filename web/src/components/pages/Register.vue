<script setup lang="ts">
import { useRouter } from "vue-router";
import { inject, ref } from "vue";
import Toaster from "../components/Toaster/Toaster.vue";
import Register, { RegisterInput } from "../../application/usecase/Register";

const router = useRouter();
const toaster: Toaster = ref();

const name = ref("");
const email = ref("");
const password = ref("");
const passwordConfirmation = ref("");

const registerUseCase: Register = inject("registerUseCase");

async function onClickRegister() {
    const input: RegisterInput = {
        name: name.value,
        email: email.value,
        password: password.value,
        passwordConfirmation: passwordConfirmation.value
    };
    const registerResult = await registerUseCase.execute(input);
    if (registerResult.isRight()) {
        router.push("/");
        return;
    }

    const error = registerResult.value;
    toaster.value.error(error.message || "Register error.");
}
</script>

<template>
    <div data-bs-theme="dark">
        <div class="container mt-5">
            <h1 class="mb-3">New Account</h1>
            <form @submit.prevent>
                <div class="form-group">
                    <input type="text" class="form-control" rows="3" placeholder="Name" v-model="name" />
                </div>
                <div class="form-group mt-3">
                    <input type="text" class="form-control" rows="3" placeholder="Email" v-model="email" />
                </div>
                <div class="form-group mt-3">
                    <input type="password" class="form-control" rows="3" placeholder="Password" v-model="password" />
                </div>
                <div class="form-group mt-3">
                    <input type="password" class="form-control" rows="3" placeholder="Password confirmation"
                        v-model="passwordConfirmation" />
                </div>
                <div class="d-flex flex-column mt-3">
                    <button type="button" class="btn btn-light " @click="onClickRegister()">
                        Save
                    </button>
                    <RouterLink class="d-flex justify-content-end mt-4" to="/">
                        <i class="bi bi-arrow-return-left"></i> &nbsp; Login
                    </RouterLink>
                </div>

            </form>
        </div>
    </div>
    <Toaster ref="toaster"></Toaster>
</template>

<style scoped>
.container {
    max-width: 480px;
    color: white;
    background-color: #363d45;
    padding: 30px;
    border: 1px solid gray;
    border-radius: 4px;
}

p {
    margin: 0;
    padding: 0;
}
</style>

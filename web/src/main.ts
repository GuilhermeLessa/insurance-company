import "bootstrap/dist/css/bootstrap.min.css";
import { Toast, Modal } from "bootstrap";
const bootstrap = { Toast, Modal };
import "bootstrap-icons/font/bootstrap-icons.css";

import "./assets/styles/main.css";

import { createApp } from 'vue';
import { createPinia } from 'pinia';

import App from './App.vue';
import routerProvider from './router';

import type HttpClient from "./application/http/HttpClient";
import AxiosHttp from "./infra/http/AxiosHttp";

import type InsuranceApiInterface from "./application/insurance-api/InsuranceApiInterface";
import InsuranceApi from "./infra/insurance-api/InsuranceApi";

import CheckIsAuthenticated from "./application/usecase/CheckIsAuthenticated";
import Login from "./application/usecase/Login";
import Logout from "./application/usecase/Logout";
import Register from "./application/usecase/Register";
import Quotation from "./application/usecase/Quotation";

(async () => {
    const app = createApp(App);

    const insuranceApiHttpClient: HttpClient = new AxiosHttp(
        import.meta.env.VITE_INSURANCE_API_URL,
        {
            withCredentials: true,
            withXSRFToken: true
        }
    );
    const insuranceApi: InsuranceApiInterface | void = await InsuranceApi.create(insuranceApiHttpClient);

    const checkIsAuthenticatedUseCase = new CheckIsAuthenticated(insuranceApi!);
    app.provide("checkIsAuthenticatedUseCase", checkIsAuthenticatedUseCase);

    const loginUseCase = new Login(insuranceApi!);
    app.provide("loginUseCase", loginUseCase);

    const logoutUseCase = new Logout(insuranceApi!);
    app.provide("logoutUseCase", logoutUseCase);

    const registerUseCase = new Register(insuranceApi!);
    app.provide("registerUseCase", registerUseCase);

    const quotationUseCase = new Quotation(insuranceApi!);
    app.provide("quotationUseCase", quotationUseCase);

    app.provide("bootstrap", bootstrap);
    app.use(createPinia());
    app.use(routerProvider(checkIsAuthenticatedUseCase));
    app.mount('#app');
})();
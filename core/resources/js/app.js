import { createApp } from 'vue'
import axios from "axios";
//load components
import {getCurrencySymbolWithAmount} from "./vue/helpers";

(async () => {
    await axios.get(window.appUrl + "/api/tenant/v1/site-currency-symbol")
        .then((response) => {
            app.config.globalProperties.currencySymbol = response.data;
            window.currencySymbol = response.data;
        }).catch(function (errors) {

        });
})();

import TopHeader from "./vue/components/header/Header.vue";
import CartItems from "./vue/components/sidebar/CartItems.vue";

import AppLayout from "./vue/layouts/app.vue";

const app = createApp(AppLayout)
// global helper for all vue component
// plugin method load or initial globally

app.mixin({
    methods:{
        getCurrencySymbolWithAmount
    }
});


app.component('TopHeader', TopHeader);
app.component('CartItems', CartItems);
app.mount('#app');

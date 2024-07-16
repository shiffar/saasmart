

<template>
  <!-- Payment Method Modal -->
    <div class="modal fade" id="proceedCart">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Methods</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="paymentMethod">
                        <ul class="paymentMethod__card tabs">
                            <li @click="handleTabs('cash'); handleGateway('cash')" v-if="credentials.pos_payment_gateway_enable == 1" class="paymentMethod__card__item cash active">
                                <p class="paymentMethod__card__name" data-tab="cash"><span class="icon"><i class="las la-money-bill"></i></span> Cash</p>
                            </li>
                            <li @click="handleTabs('cards'); handleGateway('Cards')" v-if="credentials.pos_card_payment_gateway_enable == 1" class="paymentMethod__card__item card">
                                <p class="paymentMethod__card__name" data-tab="cards"><span class="icon"><i class="las la-credit-card"></i></span> Cards</p>
                            </li>
                        </ul>

                        <div class="tab_content_item active" id="cash">
                            <div class="paymentMethod__wrap">
                                <SelectedCustomer :customer="customer" />
                                <div class="paymentMethod__price mt-4">
                                    <p class="paymentMethod__price__para">Total</p>
                                    <p class="paymentMethod__price__title">{{ getCurrencySymbolWithAmount(totalAmount) }}</p>
                                </div>
                                <div class="paymentMethod__cash mt-4">
                                    <div class="paymentMethod__cash__paid">
                                        <p class="paymentMethod__cash__para">Enter amount customer paid</p>
                                        <div class="paymentMethod__cash__input">
                                            <input type="text" class="form--control" value="0" @keyup="handleCustomerPaid($event)">
                                            <span class="paymentMethod__cash__input__sign"><i class="material-symbols-outlined"></i></span>
                                        </div>
                                    </div>
                                    <div class="paymentMethod__cash__return mt-4">
                                        <p class="paymentMethod__cash__return__para">Change amount</p>
                                        <h4 class="paymentMethod__cash__return__price">{{ getCurrencySymbolWithAmount(changeAmount.toFixed(2)) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab_content_item" id="cards">
                            <div class="paymentMethod__wrap">
                                <SelectedCustomer :customer="customer" />
                                <div class="paymentMethod__price mt-4">
                                    <p class="paymentMethod__price__para">Total</p>
                                    <p class="paymentMethod__price__title">{{ getCurrencySymbolWithAmount(totalAmount) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="tab_content_item active" id="E-Wallet">
                            <div class="paymentMethod__wrap">
                                <SelectedCustomer :customer="customer" />

                                <div class="paymentMethod__price mt-4">
                                    <p class="paymentMethod__price__para">Total</p>
                                    <p class="paymentMethod__price__title">{{ getCurrencySymbolWithAmount(totalAmount) }}</p>
                                </div>
                                <div class="paymentMethod__type mt-4">
                                    <div v-for="credential in credentials.e_wallet_gateway_credential" @click="handleGateway(credential.name)" v-bind:data-name="credential.name" class="paymentMethod__type__item single_click">
                                        <img v-bind:src="credential.image" v-bind:alt="credential.name">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group d-flex gap-3 align-items-center">
                            <label for="send_customer_email">Send customer email</label>
                            <input type="checkbox" @change="sendCustomerEmail($event)" id="send_customer_email" class="form-check" />
                            <p class="info">If you want to send an e-mail by selecting this then you should select an customer first. </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <form @submit="handleSubmit($event)">
                        <input type="hidden" name="selected_gateway" value="" id="selected_gateway"/>
                        <input type="hidden" name="selected_customer" value="" id="selected_customer"/>
                        <input type="hidden" name="coupon" value="" id="form_coupon" />
                        <input type="hidden" name="send_email" value="" id="form_send_email" />

                        <button id="close-proceed-to-cart" type="button" class="btn btn-outline-secondary mx-2" data-bs-dismiss="modal">Cancel</button>
                        <button id="submit-proceed-to-cart-btn mx-2" type="submit" class="btn btn-primary" v-bind:disabled="disableSubmit">Confirm Paid <SubmitButtonLoader v-show="buttonLoader"/></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import {ref, watch} from "vue";
import SelectedCustomer from "../customer/SelectedCustomer.vue";
import SubmitButtonLoader from "../button/SubmitButtonLoader.vue";

export default {
    name: "ProceedToCart",
    components: {SubmitButtonLoader, SelectedCustomer},
    props: {
        totalAmount: 0,
        customer: null
    },
    setup(props, {emit}){
        const buttonLoader = ref(false);
        const customerPaidAmount = ref(0);
        const disableSubmit = ref(false);
        const totalAmount = ref();
        const changeAmount = ref(0);
        totalAmount.value = props.totalAmount;

        const credentials = ref({
            pos_payment_gateway_enable: false,
            pos_card_payment_gateway_enable: false,
            pos_e_wallet_payment_gateway_enable: false,
        });

        watch(() => props.totalAmount, (newValue, oldValue) => {
            totalAmount.value = newValue;
        });

        axios.get(window.appUrl + "/admin-home/pos/gateway-settings").then((response) => {
            credentials.value = response.data;
        }).catch((errors)=>{

        });

        function handleGateway(val){
            // first need to remove all active class
            let paymentGateway = document.querySelectorAll('.single_click');
            paymentGateway.forEach(function (element, key){
              element.classList.remove("active");
            })

            document.querySelector('.single_click[data-name='+ val +']').classList.add('active');

            document.querySelector("#selected_gateway").value = val;
        }

        function handleTabs(selector){
            document.querySelector("#cash").classList.remove("active");
            document.querySelector("#cards").classList.remove("active");

            document.querySelector("#" + selector).classList.add('active');

            document.querySelector(".paymentMethod__card__item").classList.remove('active');
            document.querySelector("li." + selector).classList.add('active');
        }

        function sendCustomerEmail(event){
            if(event.currentTarget.checked){
                document.querySelector("#form_send_email").value = "on";
            }else {
                document.querySelector("#form_send_email").value = "off";
            }
        }

        function handleCustomerPaid(event){
            changeAmount.value = event.target.value - totalAmount.value;
            customerPaidAmount.value = event.target.value;
        }

        function handleSubmit(event){
            event.preventDefault();

            if (customerPaidAmount.value < 1)
            {
                toastr.error("You must enter a amount");
                return;
            }

            if((Math.round(totalAmount.value) > 0) == false){
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Please add some product in to carts for purchase',
                    showConfirmButton: false,
                    timer: 1500
                });

                return ;
            }

            disableSubmit.value = true;
            buttonLoader.value = true;

            Swal.fire({
                position: 'top-end',
                icon: 'warning',
                title: 'Purchase request sent.',
                showConfirmButton: false,
                timer: 1500
            });


            axios.post(window.appUrl + "/admin-home/pos/order/submit", new FormData(event.target)).then((response) => {
                //todo:: emit an event
                emit('cartAdded');

                Swal.fire({
                    position: 'top-end',
                    icon: response.data.type,
                    title: response.data.msg,
                    showConfirmButton: false,
                    timer: 1500
                });

                document.querySelector("#close-proceed-to-cart").dispatchEvent(new MouseEvent("click"));
                disableSubmit.value = false;
                buttonLoader.value = false;
            });
        }

        return {
            credentials,
            handleTabs,
            handleGateway,
            handleCustomerPaid,
            handleSubmit,
            changeAmount,
            sendCustomerEmail,
            disableSubmit,
            customerPaidAmount,
            buttonLoader
        };
    }
}
</script>

<style scoped>
    #close-proceed-to-cart:hover{
        background: var(--delete-color);
        border-color: var(--delete-color);
        color: #ffffff;
    }
</style>

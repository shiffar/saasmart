<style>
@import "https://cdn.jsdelivr.net/npm/material-icons@1.13.12/iconfont/material-icons.min.css";
@import "../css/material-icon.css";
@import "../css/style.css";

.searching-product h3 {
    text-align: center;
    width: 100%;
}

.no-product-found h3 {
    text-align: center;
    color: orange;
    width: 100%;
}
.custom-form .form--control, .custom-form select{
    border-color: #cecece !important;
}
#proceedCart .modal-content{
    background: #ffffff;
}
.paymentMethod__card li{
    background: var(--search-bg);
}
.paymentMethod__card li:is(:hover, .active){
    color: #ffffff;
    background: #b66dff;
    border-color: #b66dff;
}
</style>

<template>
    <div class="body-overlay"></div>
    <div class="dashboard__area">
        <div class="container-fluid p-0">
            <div class="dashboard__contents__wrapper iocn_view">
                <div class="dashboard__right">
                    <div class="dashboard__body posPadding">
                        <div class="dashboard__inner">
                            <div class="dashboard_posSystem">
                                <div class="dashboard__inner__item">
                                    <div class="row g-4">
                                        <div class="col-xxl-8 col-lg-7">
                                            <div class="dashboard_posSystem__left">
                                                <div class="dashboard_posSystem__header">
                                                    <StoreLocation/>
                                                    <TopHeader @emitCategorySelected="handleCategorySelection"
                                                               @emitSearch="searchProduct"/>

                                                    <div class="selected-categories d-flex gap-1">
                                                        <div v-if="selectedCategories?.category?.name ?? false"
                                                             class="category">
                                                            {{ selectedCategories?.category?.name ?? "" }}
                                                            {{ selectedCategories?.sub_category?.name ? " > " : "" }}
                                                        </div>
                                                        <div v-if="selectedCategories?.sub_category?.name ?? false"
                                                             class="sub_category">
                                                            {{ selectedCategories?.sub_category?.name ?? "" }}
                                                            {{ selectedCategories?.child_category?.name ? " > " : "" }}
                                                        </div>
                                                        <div v-if="selectedCategories?.child_category?.name ?? false"
                                                             class="child_category">
                                                            {{ selectedCategories?.child_category?.name ?? "" }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="dashboard_posSystem__row mt-4">
                                                    <div class="dashboard_posSystem__item"
                                                         v-if="Products.products.length > 0"
                                                         v-for="product in Products.products" :key="product.prd_id">
                                                        <ProductCard :product="product" @cartAdded="testCallback"
                                                                     @loadProductView="loadProductData"
                                                                     :load-cart-items="loadCartItems"/>
                                                    </div>

                                                    <div
                                                        :class="isSearchProduct ? 'py-4 searching-product' : 'py-4 no-product-found'"
                                                        v-show="isSearchProduct || Products.length < 1">
                                                        <h3>{{
                                                                isSearchProduct ? "Searching product...." : "No product found"
                                                            }}</h3>
                                                    </div>
                                                </div>

                                                <div class="dashboard_posSystem__row justify-content-end mt-4">
                                                    <!-- Pagination Links -->
                                                    <nav aria-label="Page navigation">
                                                        <ul class="pagination">
                                                            <li class="page-item"
                                                                :class="{ disabled: !Products.pagination.previous_page }">
                                                                <a class="page-link" href="#0" aria-label="Previous"
                                                                   @click.prevent="fetchProductsPagination(Products.pagination.previous_page)">
                                                                    <span aria-hidden="true">Previous</span>
                                                                </a>
                                                            </li>

                                                            <li v-for="pageNum in pageNumbers" :class="{ active: currentPage === pageNum }" class="page-item" :key="pageNum">
                                                                <a class="page-link" href="#0" @click.prevent.self="fetchProductsPagination(`${getAppUrl()}/api/tenant/v1/product?&page=${pageNum}`)">{{ pageNum }}</a>
                                                            </li>

                                                            <li class="page-item"
                                                                :class="{ disabled: !Products.pagination.next_page }">
                                                                <a class="page-link" href="#0" aria-label="Next"
                                                                   @click.prevent="fetchProductsPagination(Products.pagination.next_page)">
                                                                    <span aria-hidden="true">Next</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-lg-5">
                                            <div class="dashboard_posSystem__sidebar">
                                                <Customer @selectedCustomer="selectedCustomer"/>
                                                <CartItems @cartAmountWithTaxAmount="get_cart_amount"
                                                           :load-cart-items="loadCartItems" @cartAdded="testCallback"/>
                                                <Calculate @orderCanceled="testCallback" @totalAmount="calculateTotal"
                                                           :data="cartTotalAmount"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ProductModal :product-details="productDetails" @cartAdded="testCallback"/>
    <AddCustomer/>
    <ProceedToCart v-if="cartTotalAmount.sub_total > 0" @cartAdded="testCallback" :customer="customer"
                   :total-amount="calculateTotalAmount"/>

    <div class="category_overlay" @click="handleCategoryOverlay"></div>
</template>

<script>
/*-----------------
 Select2 Js
------------------*/

import {ref, provide, reactive} from "vue";
import LeftSidebar from "../components/LeftSidebar.vue";
import Customer from "../components/sidebar/Customer.vue";
import Calculate from "../components/sidebar/Calculate.vue";
// import Swal from "sweetalert2"
import axios from "axios";
import ProductCard from "../components/products/ProductCard.vue";
import ProductModal from "../components/ProductModal.vue";
import AddCustomer from "../components/modal/AddCustomer.vue";
import ProceedToCart from "../components/modal/ProcedToCart.vue";
import StoreLocation from "../components/StoreLocation.vue";


export default {
    name: "app",
    components: {
        StoreLocation,
        ProceedToCart,
        AddCustomer,
        ProductModal,
        ProductCard,
        Calculate,
        LeftSidebar,
        Customer,
        // CartItems
    },
    setup: (props, {emit}) => {
        //data, function , state , mount
        const Products = reactive({products: "", pagination: ""});
        const Hello = ref(0);
        const loadCartItems = ref(false);
        const productDetails = ref(false);
        const loadProductDetails = ref(false);
        const cartTotalAmount = ref(0);
        const calculateTotalAmount = ref(0);
        const customer = ref(null);
        const isSearchProduct = ref(false);
        const selectedCategories = ref({category: {name: ''}, sub_category: {name: ''}, child_category: {name: ''},});
        const currentPage = ref(1);

        function Increase() {
            Hello.value = Hello.value + 1;
        }

        function selectedCustomer(value) {
            customer.value = value;
        }

        function get_cart_amount(data) {
            cartTotalAmount.value = data;
        }

        function fetchProductData() {
            axios.get(window.appUrl + '/api/tenant/v1/product')
                .then((response) => {
                    Products.products = response.data.data;
                    Products.pagination = response.data;
                    currentPage.value = response.data.current_page;
                    delete Products.pagination['data'];

                    setPageNumbers();
                }).catch((error) => {
            });
        }

        function searchProduct(data) {
            isSearchProduct.value = true;
            Products.value = [];

            axios.get(window.appUrl + '/api/tenant/v1/product?' + data)
                .then((response) => {
                    isSearchProduct.value = false;
                    Products.products = response.data.data;
                    Products.pagination = response.data;
                    currentPage.value = response.data.current_page;
                    delete Products.pagination['data'];

                    setPageNumbers();
                }).catch((error) => {
                isSearchProduct.value = false;
                    prepare_errors(error)
            });
        }

        function addToCartButton(product) {
            Swal.fire({
                title: 'Error!',
                text: 'Do you want to continue',
                icon: 'error',
                confirmButtonText: 'Cool'
            });
        }

        function testCallback() {
            loadCartItems.value = !loadCartItems.value;
            loadProductDetails.value = !loadProductDetails.value;
        }

        function changeLoadCartItems(value) {
            // return loadCartItems.value = !loadCartItems.value;
        }

        function loadProductData(emitData) {
            productDetails.value = emitData;
        }

        function calculateTotal(value) {
            calculateTotalAmount.value = value;
        }

        // document.querySelector('.body-overlay').addEventListener("click",function (event){
        //     this.classList.remove('show');
        //     document.querySelector('.searchParent .searchWrap').classList.remove("d-block");
        //     document.querySelector('.searchParent .searchWrap').classList.add("d-none");
        //     document.querySelector('.keyupInput').value = '';
        // });

        function handleCategoryOverlay() {
            document.querySelector(".dashboard_posSystem__category__nav").dispatchEvent(new MouseEvent('click'));
        }

        function handleCategorySelection(data) {
            selectedCategories.value = data.value;
        }

        function fetchProductsPagination(page) {
            if (page === "") return;

            axios.get(page)
                .then((response) => {
                    Products.products = response.data.data;
                    Products.pagination = response.data;
                    currentPage.value = response.data.current_page;

                    delete Products.pagination['data'];

                    setPageNumbers();
                }).catch((error) => {
            });
        }

        const pageNumbers = ref(1);
        function setPageNumbers() {
            let from = currentPage.value - 2;
            if (from < 1) {
                from = 1;
            }
            let to = from + 4;
            if (to >= Products.pagination.last_page) {
                to = Products.pagination.last_page;
                from = Products.pagination.last_page - 4 > 0 ? Products.pagination.last_page - 4 : 1;
            }

            let numbers = [];
            for (let page = from; page <= to; page++) {
                numbers.push(page);
            }

            pageNumbers.value = numbers;
        }

        const getAppUrl = () => {
            return window.appUrl;
        };

        provide('fetchProductData', fetchProductData)
        provide('selectedCategories', selectedCategories)

        return {
            Hello,
            Increase,
            Products,
            fetchProductData,
            addToCartButton,
            testCallback,
            loadCartItems,
            changeLoadCartItems,
            loadProductData,
            productDetails,
            searchProduct,
            cartTotalAmount,
            get_cart_amount,
            calculateTotal,
            calculateTotalAmount,
            selectedCustomer,
            customer,
            handleCategoryOverlay,
            isSearchProduct,
            handleCategorySelection,
            selectedCategories,
            fetchProductsPagination,
            pageNumbers,
            currentPage,
            getAppUrl
        }
    },
    mounted() {
        this.fetchProductData();
    }
}
</script>

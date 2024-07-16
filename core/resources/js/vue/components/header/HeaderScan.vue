<template>
  <div class="dashboard_posSystem__header__item__flex">
    <div class="dashboard_posSystem__header__scan">
      <div class="dashboard_posSystem__header__scan__flex tested">
        <div class="dashboard_posSystem__header__scan__input">
          <input id="search-sku" @change="searchProduct()" type="text" class="form--control radius-10" placeholder="Enter product code">
          <button  @click="searchProduct" class="search_icon tested"><i class='las la-search'></i> </button>
        </div>

        <div class="dashboard_posSystem__header__scan__code gap-4">
            <a href="#0" class="scan_btn radius-10 mx-1" @click="handleProductSearch">
                <span class="scan_icon"><i class="las la-barcode"></i></span>
                <span class="scan_title">Scan Code</span>
            </a>
            <a href="#0" class="scan_btn reset_btn radius-10 mx-1" @click="resetSearch">
                <span class="scan_icon">
                    <i class="las la-undo-alt"></i>
                </span>
                <span class="scan_title">Reset Search</span>
            </a>
        </div>
      </div>
    </div>

<!--    <RightCategory />-->
  </div>
</template>

<script>
  import RightCategory from "./RightCategory.vue";

  export default {
    name: "HeaderScan",
    components: {RightCategory},
    setup(props, {emit}){
      function searchProduct(){
          let key = document.querySelector("#search-sku").value;
          emit("emitSearch", "sku=" + key);
      }

      function resetSearch(){
          emit("emitSearch","reset=true");
      }

      function handleProductSearch(){
          document.getElementById("search-sku").focus();
      }

      return {
          searchProduct,
          resetSearch,
          handleProductSearch
      };
    }
  }
</script>

<style scoped>
    .reset_btn:hover{
        background: var(--delete-color);
        border-color: var(--delete-color);
        color: var(--white);
    }
</style>

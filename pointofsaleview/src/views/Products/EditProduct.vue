<template>
  <CRow>
    <CCol col="12">
      <CCard>
        <CAlert v-if="hasError" show color="danger">
          <span v-for="(error, key) in errorMessage" :key="key">{{ String(error) }}<br/></span>
        </CAlert>
        <CCardHeader>
          <h4>Edit product information</h4>
        </CCardHeader>
        <CCardBody>
          <CRow>
            <CCol>
              <CInput
                  label="product Name"
                  placeholder="Enter product Name"
                  v-model="product.name"
              />
            </CCol>
            <CCol>
              <CInput
                  label="code"
                  placeholder="code"
                  v-model="product.code"
              />
            </CCol>
          </CRow>
          <CRow>
            <CCol sm="6">
              <CInput
                  label="whole sale price"
                  placeholder="00000"
                  v-model="product.whole_sale_price"
              />
            </CCol>
            <CCol sm="6">
              <CInput
                  label="retail price"
                  placeholder="00000"
                  v-model="product.retail_price"
              />
            </CCol>
          </CRow>
          <select class="form-control" @change="changecategoryName($event)">
            <option value="" selected disabled>Choose Category</option>
            <option v-for="categoryName in categoryNames" :value="categoryName.id" :key="categoryName.id">{{ categoryName.name }}</option>
          </select>
        </CCardBody>
        <CCardFooter>
          <CRow>
            <CCol col="6" sm="4" md="2" class="mb-3 mb-xl-0">
              <CButton block color="success" @click="goBack">Back</CButton>
            </CCol>
            <CCol col="6" sm="4" md="2" class="mb-3 mb-xl-0">
              <CButton block color="primary" @click="saveProduct">Save</CButton>
            </CCol>
          </CRow>
        </CCardFooter>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import api from "../../repository/api"

export default {
  name: "EditProduct",

  data() {
    return {
      categoryNames: [],
      selectedCategoryName: null,
      product: {
        name: '',
        code: '',
        whole_sale_price: '',
        retail_price: '',
        category: '',
      },
      productId: 0,
      errorMessage: 'test error',
      hasError: false,
      categories: [],
    }
  },
  beforeMount() {
    api.get('business/product/'+this.$route.params.id,{
      headers: {Authorization: `Bearer ${this.$session.get('jwt')}`}
    })
      .then(response =>{
        this.product.name = response.data.name;
        this.product.code = response.data.code;
        this.product.whole_sale_price = response.data.whole_sale_price;
        this.product.retail_price = response.data.retail_price;
        this.product.category = response.data.product_category_id;
      })
      .catch(error => {
        this.errorMessage = error.response.data.errors;
      })
  },
  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.usersOpened = from.fullPath.includes('users')
    })
  },
  mounted() {
    this.productId = this.$route.params.id;
    this.getCategoryList();
  },
  methods: {
    goBack() {
      this.usersOpened ? this.$router.go(-1) : this.$router.push({path: '/product/products'})
    },
    saveProduct() {
      api.put('business/product/'+this.productId, {
            name: this.product.name,
            code: this.product.code,
            whole_sale_price: this.product.whole_sale_price,
            retail_price: this.product.retail_price,
            product_category: this.selectedCategoryName}, {
            headers: {Authorization: `Bearer ${this.$session.get('jwt')}`}
          })
          .then(response => {
            console.log("product Updated");
            this.$router.push({path: '/product/products'})
          })
          .catch(error => {
            this.errorMessage = error.response.data.errors;
            this.hasError = true;
          })
    },
    getCategoryList() {
      api.get('business/getAllCategories', {
            headers: {Authorization: `Bearer ${this.$session.get('jwt')}`}
          })
          .then(response => {
            console.log(response.data)
            this.categoryNames = response.data;
          })
          .catch(error => {
            this.errorMessage = error.response.data.errors;
            this.hasError = true;
          })
    },
    changecategoryName (event) {
      this.selectedCategoryName = event.target.options[event.target.options.selectedIndex].text
    },
  },
}
</script>

<style scoped>

</style>

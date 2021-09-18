<template>
  <CRow>
    <CCol col="12">
      <CCard>
        <CAlert v-if="hasError" show color="danger">
          <span v-for="(error, key) in errorMessage" :key="key">{{ String(error) }}<br/></span>
        </CAlert>
        <CCardHeader>
          <h4>Add new product</h4>
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
            <CCol>
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
          <CRow>
            <CCol>
            <select class="form-control" @change="changecategoryName($event)">
              <option value="" selected disabled>Choose Category</option>
              <option v-for="categoryName in categoryNames" :value="categoryName.id" :key="categoryName.id">{{ categoryName.name }}</option>
            </select>
            </CCol>
            <CCol sm="6">
            <select class="form-control" @change="changebusinesName($event)">
              <option value="" selected disabled>Choose business</option>
              <option v-for="businesName in businesNames" :value="businesName.id" :key="businesName.id">{{ businesName.name }}</option>
            </select>
            </CCol>
          </CRow>
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
  name: "AddProduct",

  data() {
    return {
      categoryNames: [],
      selectedCategoryName: null,
      businesNames: [],
    SelectedBusinesName: null,
      product: {
        name: '',
        code: '',
        whole_sale_price: '',
        retail_price: '',
        category: '1'
      },
      errorMessage: '',
      hasError: false,
      categories: [],
    }
  },
  mounted() {
    this.getCategoryList();
    this.getBusinessList();
  },
  methods: {
    goBack() {
      this.usersOpened ? this.$router.go(-1) : this.$router.push({name: 'products'})
    },
    saveProduct() {
      api
          .post('business/product', {
            name: this.product.name,
            code: this.product.code,
            retail_price: this.product.retail_price,
            whole_sale_price: this.product.whole_sale_price,
            product_category_id: this.selectedCategoryName,
            business_id: this.SelectedBusinesName}, {
            headers: {Authorization: `Bearer ${this.$session.get('jwt')}`}
          })
          .then(response => {
            this.$router.push('products')
          })
          .catch(error => {
            this.errorMessage = error.response.data.errors;
            this.hasError = true;
          })
    },
    getCategoryList() {
      api
          .get('business/getAllCategories', {
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
    getBusinessList() {
      api
          .get('business/getOwenedBusiness', {
            headers: {Authorization: `Bearer ${this.$session.get('jwt')}`}
          })
          .then(response => {
            console.log(response.data)
            this.businesNames = response.data;
          })
          .catch(error => {
            this.errorMessage = error.response.data.errors;
            this.hasError = true;
          })
    },
    changecategoryName (event) {
      this.selectedCategoryName = event.target.options[event.target.options.selectedIndex].text
    },
    changebusinesName (event) {
      this.SelectedBusinesName = event.target.options[event.target.options.selectedIndex].text
    }
  },
}
</script>

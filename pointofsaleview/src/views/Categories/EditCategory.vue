<template>
  <CRow>
    <CCol col="12">
      <CCard>
        <CAlert v-if="hasError" show color="danger">
          <span v-for="(error, key) in errorMessage" :key="key">{{ String(error) }}<br/></span>
        </CAlert>
        <CCardHeader>
          <h4>Edit category information</h4>
        </CCardHeader>
        <CCardBody>
          <CRow>
            <CCol>
              <CInput
                  label="Category Name"
                  placeholder="Enter Category Name"
                  v-model="category.name"
              />
            </CCol>
          </CRow>
        </CCardBody>
        <CCardFooter>
          <CRow>
            <CCol col="6" sm="4" md="2" class="mb-3 mb-xl-0">
              <CButton block color="success" @click="goBack">Back</CButton>
            </CCol>
            <CCol col="6" sm="4" md="2" class="mb-3 mb-xl-0">
              <CButton block color="primary" @click="saveCategory">Save</CButton>
            </CCol>
          </CRow>
        </CCardFooter>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from "axios";

export default {
  name: "EditCategory",
  data() {
    return {
      category: {
        name: '',
      },
      categoryId: 0,
      errorMessage: 'test error',
      hasError: false,
    }
  },

  beforeMount() {
    axios
        .get('http://localhost:8000/api/business/category/'+this.$route.params.id,{
          headers: {Authorization: `Bearer ${this.$session.get('jwt')}`}})
        .then(response =>{
          this.category.name = response.data.category.name;
        })
        .catch(error => {
          this.errorMessage = error.response.data.errors;
        })
  },
  mounted(){
    this.categoryId = this.$route.params.id;
  },
  methods: {
    goBack() {
      this.usersOpened ? this.$router.go(-1) : this.$router.push({name: 'Categories'})
    },
    saveCategory() {
      axios
          .put('http://localhost:8000/api/business/category/'+this.categoryId, {
            name: this.category.name,},
          {
            headers: {Authorization: `Bearer ${this.$session.get('jwt')}`}
          })
          .then(response => {
            this.$router.push({name: 'Categories'});
            this.hasError = false;
          })
          .catch(error => {
            this.errorMessage = error.response.data.errors;
            this.hasError = true;
          })
    },
  },
}
</script>

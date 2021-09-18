<template>
  <CRow>
    <CCol col="12">
      <CCard>
        <CAlert v-if="hasError" show color="danger">
          <span v-for="(error, key) in errorMessage" :key="key">{{ String(error) }}<br/></span>
        </CAlert>
        <CCardHeader>
          <h4>Add new vendor</h4>
        </CCardHeader>
        <CCardBody>
          <CRow>
            <CCol sm="6">
              <CInput
                  label="Vendor Name"
                  placeholder="Enter Vendor Name"
                  v-model="vendor.name"
              />
            </CCol>
            <CCol sm="6">
              <div>
                <label class="typo__label">Select Branch Name</label>
                <multiselect v-model="vendor.branchesName" tag-placeholder="Add this as branch" placeholder="Search a branch" label="name" track-by="name" :options="branchesList" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
              </div>
            </CCol>
          </CRow>
          <CRow>
            <CCol sm="6">
              <CInput
                  label="Email"
                  placeholder="Email"
                  v-model="vendor.email"
              />
            </CCol>
            <CCol sm="6">
              <CInput
                  label="Phone"
                  placeholder="+880-XXXXXXXXXX"
                  v-model="vendor.phone"
              />
            </CCol>
          </CRow>
          <CInput
              label="Address"
              placeholder="Address"
              v-model="vendor.address"
          />
        </CCardBody>
        <CCardFooter>
          <CRow>
            <CCol col="6" sm="4" md="2" class="mb-3 mb-xl-0">
              <CButton block color="success" @click="goBack">Back</CButton>
            </CCol>
            <CCol col="6" sm="4" md="2" class="mb-3 mb-xl-0">
              <CButton block color="primary" @click="saveVendor">Save</CButton>
            </CCol>
          </CRow>
        </CCardFooter>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import api from '../../repository/api'
import Multiselect from 'vue-multiselect'

export default {
  name: "AddVendor",
  components: {
    Multiselect
  },

  data() {
    return {

      branchesList: [],
      vendor: {
        name: '',
        address: '',
        phone: '',
        email: '',
        branchesName: [],
      },
      errorMessage: '',
      hasError: false,
    }
  },
  mounted() {
    this.getBranchesList();
  },
  methods: {
    goBack() {
      this.usersOpened ? this.$router.go(-1) : this.$router.push({name: 'Vendors'})
    },
    addTag (newTag) {
      const tag = {
        name: newTag,
        code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
      }
      this.options.push(tag)
      this.value.push(tag)
    },
    getBranchesList(){
      api
          .get('business/brancheslist', {
            headers: {Authorization: `Bearer ${this.$session.get('jwt')}`}
          })
          .then(response => {
            this.branchesList = response.data;
          })
          .catch(error => {
            this.errorMessage = error.response.data.errors;
          })
    },
    saveVendor() {
      api
          .post('business/vendor', {
            name: this.vendor.name,
            address: this.vendor.address,
            phone: this.vendor.phone,
            email: this.vendor.email,
            branches: this.vendor.branchesName,
          }, {
            headers: {Authorization: `Bearer ${this.$session.get('jwt')}`}
          })
          .then(response => {
            this.$router.push({name: 'Vendors'})
          })
          .catch(error => {
            this.errorMessage = error.response.data.errors;
            this.hasError = true;
          })
    },
  },
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>


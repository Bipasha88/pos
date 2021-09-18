<template>
  <CRow>
    <CCol col="12">
      <CCard>
        <CAlert v-if="hasError" show color="danger">
          <span v-for="(error, key) in errorMessage" :key="key">{{ String(error) }}<br/></span>
        </CAlert>
        <CCardHeader>
          <h4>Edit branch information</h4>
        </CCardHeader>
        <CCardBody>
          <CRow>
            <CCol>
              <CInput
                  label="Branch Name"
                  placeholder="Enter Branch Name"
                  v-model="branch.name"
              />
            </CCol>
          </CRow>
          <CRow>
            <CCol sm="6">
              <CInput
                  label="Email"
                  placeholder="Email"
                  v-model="branch.email"
              />
            </CCol>
            <CCol sm="6">
              <CInput
                  label="Phone"
                  placeholder="+880-XXXXXXXXXX"
                  v-model="branch.phone"
              />
            </CCol>
          </CRow>
          <CInput
              label="Address"
              placeholder="Address"
              v-model="branch.address"
          />
        </CCardBody>
        <CCardFooter>
          <CRow>
            <CCol col="6" sm="4" md="2" class="mb-3 mb-xl-0">
              <CButton block color="success" @click="goBack">Back</CButton>
            </CCol>
            <CCol col="6" sm="4" md="2" class="mb-3 mb-xl-0">
              <CButton block color="primary" @click="saveBranch">Save</CButton>
            </CCol>
          </CRow>
        </CCardFooter>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import api from '../../repository/api'

export default {
  name: "EditBranch",
  data() {
    return {
      branch: {
        name: '',
        address: '',
        phone: '',
        email: '',
      },
      branchId: 0,
      errorMessage: 'test error',
      hasError: false,
    }
  },

  beforeMount() {
    api
        .get('business/branch/' + this.$route.params.id, {
          headers: {Authorization: `Bearer ${this.$session.get('jwt')}`}
        })
        .then(response => {
          this.branch.name = response.data.branch.name;
          this.branch.email = response.data.branch.email;
          this.branch.phone = response.data.branch.phone;
          this.branch.address = response.data.branch.address;
        })
        .catch(error => {
          this.errorMessage = error.response.data.errors;
        })
  },
  mounted() {
    this.branchId = this.$route.params.id;
  },
  methods: {
    goBack() {
      this.usersOpened ? this.$router.go(-1) : this.$router.push({name: 'Branches'})
    },
    saveBranch() {
      api
          .put('business/branch/' + this.branchId, {
            name: this.branch.name,
            address: this.branch.address,
            phone: this.branch.phone,
            email: this.branch.email}, {
            headers: {Authorization: `Bearer ${this.$session.get('jwt')}`}
          })
          .then(response => {
            this.$router.push({name: 'Branches'});
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

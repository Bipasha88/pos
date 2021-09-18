<template>
  <CRow>
    <CCol col="12">
      <CCard>
        <CAlert v-if="hasError" show color="danger">
          <span v-for="(error, key) in errorMessage" :key="key">{{ String(error) }}<br/></span>
        </CAlert>
        <CCardHeader>
          <h4>Add new employee to a business</h4>
        </CCardHeader>
        <CCardBody>
          <CRow>
            <CCol>
              <CInput
                  label="Employee Name"
                  placeholder="Enter Business Employee Name"
                  v-model="employee.name"
              />
            </CCol>
          </CRow>
          <CRow>
            <CCol>
              <CInput
                  label="Email"
                  placeholder="Email"
                  v-model="employee.email"
              />
            </CCol>
            <CCol sm="6">
              <CInput
                  label="Phone"
                  placeholder="+880-XXXXXXXXXX"
                  v-model="employee.phone"
              />
            </CCol>
          </CRow>
          <CInput
              label="Address"
              placeholder="Address"
              v-model="employee.address"
          />
        </CCardBody>
        <CCardFooter>
          <CRow>
            <CCol col="6" sm="4" md="2" class="mb-3 mb-xl-0">
              <CButton block color="success" @click="goBack">Back</CButton>
            </CCol>
            <CCol col="6" sm="4" md="2" class="mb-3 mb-xl-0">
              <CButton block color="primary" @click="saveEmployee">Save</CButton>
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
  name: "AddEmployee",

  data() {
    return {
      employee: {
        name: '',
        address: '',
        phone: '',
        email: '',
      },
      errorMessage: '',
      hasError: false,
    }
  },
  methods: {
    goBack() {
      this.usersOpened ? this.$router.go(-1) : this.$router.push({name: 'Employees'})
    },
    saveEmployee() {
      api
          .post('business/employee', this.employee, {
            headers: {Authorization: `Bearer ${this.$session.get('jwt')}`}
          })
          .then(response => {
            this.$router.push('/settings/employees')
          })
          .catch(error => {
            this.errorMessage = error.response.data.errors;
            this.hasError = true;
          })
    },
  },
}
</script>
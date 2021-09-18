<template>
  <CRow>
    <CCol col="12">
      <CCard>
        <CAlert v-if="hasError" show color="danger">
          <span v-for="(error, key) in errorMessage" :key="key">{{ String(error) }}<br/></span>
        </CAlert>
        <CCardHeader>
          <h4>Edit employee information</h4>
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
            <CCol>
              <CSelect
                  label="Business"
                  :value.sync="employee.business_id"
                  :options="businesses"
                  placeholder="Please select"
              />
            </CCol>
          </CRow>
          <CRow>
            <CCol sm="6">
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
import axios from "axios";

export default {
  name: "EditEmployee",

  data() {
    return {
      employee: {
        name: '',
        address: '',
        phone: '',
        email: '',
        business_id: '1', // todo: update to actual business id
      },
      employeeId: 0,
      errorMessage: 'test error',
      hasError: false,
      businesses: [],
    }
  },
  beforeMount() {
    axios .get('http://localhost:8000/api/business/employee/'+this.$route.params.id,{
      headers: {Authorization: `Bearer ${this.$session.get('jwt')}`}
    })
      .then(response =>{
        this.employee.name = response.data.employee.name;
        this.employee.email = response.data.employee.email;
        this.employee.phone = response.data.employee.phone;
        this.employee.address = response.data.employee.address;
        this.employee.business_id = response.data.employee.business_id;
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
    this.employeeId = this.$route.params.id;
  },
  methods: {
    goBack() {
      this.usersOpened ? this.$router.go(-1) : this.$router.push({path: '/employees'})
    },
    saveEmployee() {
      axios
          .put('http://localhost:8000/api/business/employee/'+this.employeeId, {
            name: this.employee.name,
            address: this.employee.address,
            phone: this.employee.phone,
            email: this.employee.email,
            business_id: this.employee.business_id}, {
            headers: {Authorization: `Bearer ${this.$session.get('jwt')}`}
          })
          .then(response => {
            console.log("Employee Updated");
            this.$router.push('/settings/employees')
          })
          .catch(error => {
            this.errorMessage = error.response.data.errors;
            this.hasError = true;
          })
    },
  },
  computed: {
    getBusinessList() {
      api
          .get('business/list', {
            headers: {Authorization: `Bearer ${this.$session.get('jwt')}`}
          })
          .then(response => {
            // Todo: Select item doesn't load properly
            console.log(response.data)
            this.businesses = response.data
          })
          .catch(error => {
            this.errorMessage = error.response.data.errors;
            this.hasError = true;
          })
    }
  }
}
</script>

<style scoped>

</style>

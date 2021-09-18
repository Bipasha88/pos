<template>
  <div class="d-flex align-items-center min-vh-100">
    <CContainer fluid>
      <CRow class="justify-content-center">
        <CCol md="6">
          <CCard class="mx-4 mb-0">
            <CCardBody class="p-4">
              <CAlert v-if="hasError" show color="danger">
                <span v-for="(error, key) in errorMessage" :key="key">{{ String(error) }}<br/></span>
              </CAlert>
              <div v-if="isRegistered" class="card-body">
                <div data-v-2fef6abe="" role="alert" aria-live="polite" aria-atomic="true" class="alert alert-success">
                  <!----><h4 class="alert-heading">Well done!</h4>
                  <p>{{ successMessage }}</p>
                  <div class="mb-3 mb-xl-0 col-6 col-sm-4 col-md-2 col-xl">
                    <router-link
                        class="btn btn-success"
                        :to="{ name: 'Login' }"
                    >
                      Login
                    </router-link>
                  </div>
                </div>
              </div>
              <CForm @submit.prevent="register">
                <h1>Sign Up</h1>
                <p class="text-muted">Create your account</p>
                <CInput
                    placeholder="Business name"
                    autocomplete="name"
                    prepend="B"
                    name="name"
                    v-model="name"
                >
                </CInput>
                <CInput
                    placeholder="Email"
                    autocomplete="email"
                    prepend="@"
                    name="email"
                    v-model="email"
                />
                <CInput
                    placeholder="Password"
                    type="password"
                    autocomplete="new-password"
                    name="password"
                    v-model="password"
                >
                  <template #prepend-content>
                    <CIcon name="cil-lock-locked"/>
                  </template>
                </CInput>
                <CInput
                    placeholder="Repeat password"
                    type="password"
                    autocomplete="new-password"
                    class="mb-4"
                    name="password_confirmation"
                    v-model="password_confirmation"
                >
                  <template #prepend-content>
                    <CIcon name="cil-lock-locked"/>
                  </template>
                </CInput>
                <CButton type="submit" color="success" block :disabled='isDisabled'>Create Account</CButton>
              </CForm>
            </CCardBody>
            <CCardFooter class="p-4">
              <CRow>
                <CCol col="6">
                  <CButton block color="facebook">
                    Facebook
                  </CButton>
                </CCol>
                <CCol col="6">
                  <CButton block color="twitter">
                    Twitter
                  </CButton>
                </CCol>
              </CRow>
              <br>
              <CRow>
                <CCol col="12" class="text-center">
                  <router-link color="link" href="" :to="{name: 'Login'}" class="px-0">Already have an account? Login Here</router-link>
                </CCol>
              </CRow>
            </CCardFooter>
          </CCard>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script>
import api from '../../repository/api'

export default {
  name: 'SignUp',
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      errorMessage: '',
      successMessage: '',
      hasError: false,
      isRegistered: false,
      isDisabled: false,
    };
  },
  methods: {
    register() {
      this.isDisabled = true;
      api.post(
        'register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
        })
        .then(response => {
          this.successMessage = response.data.success;
          this.isRegistered = true;
          this.hasError = false;
          this.isDisabled = false;
        })
        .catch(error => {
          this.errorMessage = error.response.data.errors;
          this.hasError = true;
          this.isRegistered = false;
          this.isDisabled = false;
        });
    },
  },
}
</script>

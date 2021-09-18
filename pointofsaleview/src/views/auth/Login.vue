<template>
  <div class="c-app flex-row align-items-center">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol md="8">
          <div v-if="loading">
            <div class="spinner-5 m-auto"></div>
            <h3 class="text-center">Loading</h3>
          </div>
          <CCardGroup v-if="unauthorized">
            <CCard class="p-4">
              <CCardBody>
                <CForm>
                  <h1>Login</h1>
                  <p class="text-muted">Sign In to your account</p>
                  <CAlert color="danger" :show.sync="currentAlertCounter" closeButton>
                    {{ errorMessage }}
                  </CAlert>
                  <CInput placeholder="Email" v-model="email" type="email" autocomplete="email">
                    <template #prepend-content>
                      <CIcon name="cil-user"/>
                    </template>
                  </CInput>
                  <CInput placeholder="Password" v-model="password" type="password" autocomplete="current-password">
                    <template #prepend-content>
                      <CIcon name="cil-lock-locked"/>
                    </template>
                  </CInput>
                  <CRow>
                    <CCol col="6" class="text-left">
                      <CButton @click="login" color="primary" class="px-4">Login</CButton>
                    </CCol>
                    <CCol col="6" class="text-right">
                      <CButton color="link" class="px-0">Forgot password?</CButton>
                    </CCol>
                  </CRow>
                </CForm>
              </CCardBody>
            </CCard>
            <CCard color="primary" text-color="white" class="text-center py-5 d-md-down-none" body-wrapper>
              <CCardBody>
                <h2>Sign up</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                  et dolore magna aliqua.</p>
                  <router-link class="btn btn-lg btn-default btn-outline-light" :to="{name: 'SignUp'}">Register now!</router-link>
              </CCardBody>
            </CCard>
          </CCardGroup>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script>
import api from '../../repository/api'

export default {
  name: 'Login',
  mounted: function () {
    if (this.$session.exists()) {
      this.$router.replace('Dashboard');
    } else {
      this.loading = false;
      this.unauthorized = true;
    }
  },
  data() {
    return {
      'email': "",
      'password': "",
      'currentAlertCounter': 0,
      'errorMessage': '',
      'loading': true,
      'unauthorized': false,
    }
  },
  methods: {
    login() {
      api.post(
          'login', {
            email: this.email,
            password: this.password,
          })
          .then(response => {
            this.setToken(response.data.token);
            this.$router.replace('Dashboard');
          })
          .catch(reason => {
            this.errorMessage = reason.response.data.error;
            this.currentAlertCounter = 5;
          })
    },
    setToken(token) {
      this.$session.start();
      this.$session.set('jwt', token);
      this.$store.commit('setSessionError', false)
    },
  }
}
</script>

<style scoped>
.spinner-5 {
  width: 50px;
  height: 50px;
  display: grid;
  border: 4px solid #0000;
  border-radius: 50%;
  border-right-color: #25b09b;
  animation: s5 1s infinite linear;
}

.spinner-5::before,
.spinner-5::after {
  content: "";
  grid-area: 1/1;
  margin: 2px;
  border: inherit;
  border-radius: 50%;
  animation: s5 2s infinite;
}

.spinner-5::after {
  margin: 8px;
  animation-duration: 3s;
}

@keyframes s5 {
  100% {
    transform: rotate(1turn)
  }
}
</style>

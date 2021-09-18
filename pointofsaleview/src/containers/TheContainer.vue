<template>
  <div class="c-app">
    <TheSidebar/>
    <CWrapper>
      <TheHeader/>
      <div class="c-body">
        <main class="c-main">
          <CContainer fluid>
            <div v-if="sessionError">
              <CModal
                  title="Session Error"
                  size="sm"
                  centered=true
                  color="warning"
                  :show="sessionError"
              >
                Session Expired
                <template #footer>
                  <CButton @click="loginAgain" color="success">Login Again</CButton>
                </template>
              </CModal>
            </div>
            <transition name="fade" mode="out-in">
              <router-view :key="$route.path"></router-view>
            </transition>
          </CContainer>
        </main>
      </div>
      <TheFooter/>
    </CWrapper>
  </div>
</template>

<script>
import TheSidebar from './TheSidebar'
import TheHeader from './TheHeader'
import TheFooter from './TheFooter'

export default {
  name: 'TheContainer',
  components: {
    TheSidebar,
    TheHeader,
    TheFooter
  },
  beforeCreate: function () {
    if (!this.$session.exists()) {
      this.$router.replace('/login');
    }
  },
  methods: {
    loginAgain() {
      this.$router.replace('/login');
    }
  },
  computed: {
    sessionError() {
      return this.$store.state.sessionError
    }
  }
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>

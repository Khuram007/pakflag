<template>
    <div class="header">
        <div class="header-left">
            <a href="/" class="logo">
                <img src="/assets/img/logo.png" alt="Logo">
            </a>
            <a href="/" class="logo logo-small">
                <img src="/assets/img/logo-small.png" alt="Logo" width="30" height="30">
            </a>
        </div>
        <a class="mobile_btn" id="mobile_btn">
            <i class="fas fa-bars"></i>
        </a>
        <ul class="nav nav-tabs user-menu">
            <li class="nav-item dropdown has-arrow main-drop">
                    <a class="dropdown-item" href="javascript:void(0);" @click="logout">
                        <i data-feather="log-out" class="me-1"></i>Logout
                    </a>
            </li>
        </ul>
    </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex'

  export default {
    name: 'Header',
    methods: {
      ...mapActions({
        authLogout: 'auth/logout',
      }),
      logout() {
        this.authLogout()
        .then((res) => {
          // if (this.$route.name !== 'login')
            this.$router.push({
              name: 'login'
            })
        });
      }
    },
    computed: {
      ...mapGetters({
        // students: 'studentsModule/getAllStudents',
        authCheck: 'auth/authCheck',
        authUser: 'auth/authUser',
      }),
    }
  }
</script>

<style scoped>

</style>

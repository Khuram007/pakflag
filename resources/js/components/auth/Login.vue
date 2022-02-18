<template>
    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <img class="img-fluid logo-dark mb-2" src="assets/img/logo.png" alt="Logo">
                <div class="loginbox">
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Login</h1>
                            <p class="account-subtitle">Access to our dashboard</p>
                            <form>
                                <div class="form-group">
                                    <label class="form-control-label">Email Address</label>
                                    <input type="email" class="form-control"
                                           placeholder="Enter email" v-model="form.email"/>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Password</label>
                                    <div class="pass-group">
                                        <input type="password" class="form-control pass-input"
                                               v-model="form.password"
                                               placeholder="Enter Password"/>
<!--                                        <span class="fas fa-eye toggle-password"></span>-->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
<!--                                            <div class="custom-control custom-checkbox">-->
<!--                                                <input type="checkbox" class="custom-control-input" id="cb1">-->
<!--                                                <label class="custom-control-label" for="cb1">Remember me</label>-->
<!--                                            </div>-->
                                        </div>
<!--                                        <div class="col-6 text-end">-->
<!--                                            <a class="forgot-link" href="forgot-password.html">Forgot Password ?</a>-->
<!--                                        </div>-->
                                    </div>
                                </div>
                                <button class="btn btn-lg btn-block btn-primary w-100"
                                        type="button"
                                        @click="signIn">Login
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import { mapActions, mapGetters } from 'vuex'

  export default {
    name: 'Login',
    data () {
      return {
        form: {
          email: '',
          password: '',
        },
      }
    },
    mounted () {
      // console.log(this.authCheck );
    },
    methods: {
      ...mapActions({
        login: 'auth/login',
      }),
      ...mapGetters({
        authCheck: 'auth/authCheck',
      }),
      signIn () {
        this.login(this.form).then((res) => {
          window.location.href = '/dashboard'
        })
      },
    },
  }
</script>

<style scoped>

</style>

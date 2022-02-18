<template>
    <div v-if="authCheck" class="main-wrapper">
        <Header/>
        <SideBar/>
        <div class="page-wrapper">
<!--            <Transition-->
<!--                    enter-active-class="animate__animated animate__zoomIn"-->
<!--                    leave-active-class="animate__animated animate__zoomOut"-->
<!--                    mode="out-in">-->
<!--                <KeepAlive>-->
                    <router-view></router-view>
<!--                </KeepAlive>-->
<!--            </Transition>-->
        </div>
    </div>
    <Login v-else/>
</template>

<script>
  import Login from './auth/Login';
  import SideBar from './layouts/SideBar';
  import Header from './layouts/Header';
  import { mapGetters } from 'vuex';
  import 'animate.css';

  export default {
    name: 'App',
    components: {
      Login,
      SideBar,
      Header,
    },
    computed: {
      ...mapGetters({
        authCheck: 'auth/authCheck',
      }),
    },
    watch: {
      $route (to, from, next) {
        // let authCheck = this.$store.getters['auth/authCheck']
        //   console.log( authCheck);
        //   if (authCheck) {
        //     next();
        //   } else {
        //     next({ name: 'login' })
        // }
      },
    },
  };
</script>

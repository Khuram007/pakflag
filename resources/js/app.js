/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import auth from './store/modules/auth'

require('./bootstrap')

window.Vue = require('vue')
import Vuex from 'vuex'
import App from './components/App.vue'
import store from './store/index'
import router from './router'

Vue.config.productionTip = false
Vue.use(Vuex)

import VueRouter from 'vue-router'
Vue.use(VueRouter);
Vue.component('pagination', require('laravel-vue-pagination'));
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

require('./store/subscriber')

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('app', require('./components/App').default)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
store.dispatch('auth/getUser', localStorage.getItem('pf_user_token'))
.then((res) => {
  const app = new Vue({
    el: '#app',
    router,
    store,
  })
})



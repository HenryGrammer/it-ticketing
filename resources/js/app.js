
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueGoodTablePlugin from 'vue-good-table';
import 'vue-good-table/dist/vue-good-table.css'

import ToastPlugin from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';

import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

// Components
import Navbar from './components/NavbarComponent.vue';
import ActionButton from './components/ActionButtonComponent.vue';
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.use(VueGoodTablePlugin);
Vue.use(ToastPlugin)
Vue.component('v-select', vSelect)

// Login
Vue.component('login-component', require('./components/Login/LoginComponent.vue').default);
// User
Vue.component('users-component', require('./components/User/UserComponent.vue').default);
// Company
Vue.component('company-component', require('./components/Company/CompanyComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: {
        navbar: Navbar,
        actionButton: ActionButton
    }
});

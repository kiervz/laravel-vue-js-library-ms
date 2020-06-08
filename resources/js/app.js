/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
Vue.use(VueRouter)


import Vue from 'vue'
import { Form, HasError, AlertError } from 'vform'
window.Form = Form;

window.Fire = new Vue();

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '2px'
})

// ES6 Modules or TypeScript
import Swal from 'sweetalert2'
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.toast = Toast;

const routes = [
    { path: '/', name: "Dashboard", component: require('./components/pages/Dashboard.vue').default },
    { path: '/attendance', name: "Attendance", component: require('./components/pages/Attendance.vue').default },
    { path: '/book-entry', name: 'BookEntry', component: require('./components/pages/BookEntry.vue').default },
    { path: '/issued-return', name: 'IssuedReturn', component: require('./components/pages/IssuedReturn.vue').default },
    { path: '/borrowers', name: 'Borrowers', component: require('./components/pages/Borrowers.vue').default },
    { path: '/user-management', name: 'UserManagement', component: require('./components/pages/UserManagement.vue').default },
    { path: '/audit-log', name: 'AuditLog', component: require('./components/pages/AuditLog.vue').default },
    { path: '/reports', name: 'Reports', component: require('./components/pages/Reports.vue').default },
    { path: '/settings', name: 'Settings', component: require('./components/pages/Settings.vue').default }
]

Vue.component('pagination', require('laravel-vue-pagination'));

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});

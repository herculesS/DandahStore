/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('admin-lte');

window.moment = require('moment')
window.swal = require('sweetalert2')
window.Vue = require('vue');

import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
    { path: '/products', name:'products', component: require('./components/admin/Product.vue').default },
    { path: '/products/form/:id?',  component: require('./components/admin/ProductForm.vue').default },
    { path: '/categories', component: require('./components/admin/Category.vue').default },
    { path: '/categories/form/:id?', component: require('./components/admin/CategoryForm.vue').default}
  ]

const router = new VueRouter({
    mode: 'history',
    routes 
})  
  
import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
  color: 'rgb(0, 0, 199)',
  failedColor: 'red',
  height: '12px'
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

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.filter('dateFormatDMY', function (date) {
            return moment(date).format('D-M-Y');
        }
    )
Vue.filter('booleanFormat', function (arg) {
    return arg ? 'TRUE' : 'FALSE'
})

const app = new Vue({
    el: '#app',
    router,
    
}).$mount('#app');

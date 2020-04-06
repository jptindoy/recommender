/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Event = new Vue();

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
Vue.component('login-page', require('./components/Login.vue').default);
Vue.component('profile-page', require('./components/Profile.vue').default);
Vue.component('change-profile', require('./components/ChangeProfile.vue').default);
Vue.component('change-password', require('./components/ChangePassword.vue').default);
Vue.component('users-page', require('./components/Users.vue').default);
Vue.component('module-page', require('./components/Modules.vue').default);
Vue.component('import-data', require('./components/FileImport.vue').default);
Vue.component('sales-report', require('./components/Sales.vue').default);
Vue.component('top-sales', require('./components/TopSales.vue').default);
Vue.component('yesterday-sales', require('./components/YesterdaySales.vue').default);
Vue.component('frequent-item-set', require('./components/FrequentItemSet.vue').default);
Vue.component('salable-item', require('./components/SalableItem.vue').default);
Vue.component('draft-item', require('./components/DraftItem.vue').default);
Vue.component('predict-item', require('./components/PredictItem.vue').default);
Vue.component('request-item', require('./components/RequestItem.vue').default);
Vue.component('requested-item', require('./components/RequestedItem.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});


// Alert jQuery


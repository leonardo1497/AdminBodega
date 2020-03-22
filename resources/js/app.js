/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import axios from 'axios';
import {
    ValidationObserver,
    ValidationProvider,
    extend,
    localize
  } from "vee-validate";
  import en from "vee-validate/dist/locale/en.json";
  import * as rules from "vee-validate/dist/rules";

window.Vue = require('vue');
import {BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue';

// Install VeeValidate rules and localization
Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
  });
  
  localize("en", en);
  
  // Install VeeValidate components globally
  Vue.component("ValidationObserver", ValidationObserver);
  Vue.component("ValidationProvider", ValidationProvider);

Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('store-component', require('./components/StoreComponent.vue').default);
Vue.component('main-store-component', require('./components/MainStoreComponent.vue').default);
Vue.component('store-detail', require('./components/StoreDetail.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',

});

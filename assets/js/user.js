// JS Librairies styling

require('vue-good-table/dist/vue-good-table.css');

require('vue2-dropzone/dist/vue2Dropzone.min.css');

require('vue-select/dist/vue-select.css');

// Js Librairies

import 'babel-polyfill'

import Vue from 'vue'
import Vuex from 'vuex'

import TokenService from './services/token'
import ApiService from './services/api'


import VueRouter from 'vue-router'

import router from './router';
import store from './store';

import VueGoodTablePlugin from 'vue-good-table';

import vSelect from 'vue-select'

import Datepicker from 'vuejs-datepicker';

import moment from 'moment';


import VeeValidate from 'vee-validate';

const veeValidateConfig = {
    errorBagName: 'errors', // change if property conflicts
    locale: 'fr',
    events: 'change'
};

moment.locale("fr");

require('../css/user.css');

// Set the base URL of the API
ApiService.init(process.env.VUE_APP_ROOT_API);

// If token exists set header
if (TokenService.getToken()) {
    ApiService.setHeader();
}


Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(VeeValidate, veeValidateConfig);
Vue.use(VueGoodTablePlugin);

Vue.component('v-select', vSelect);
Vue.component('vuejs-datepicker',Datepicker);

new Vue({
    el: '#root',
    router: router,
    store
});



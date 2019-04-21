import 'babel-polyfill'

import Vue from 'vue'
import Vuex from 'vuex'

import TokenService from './services/token'
import ApiService from './services/api'


import VueRouter from 'vue-router'

import router from './router';
import store from './store';

require('../css/user.css');


// Set the base URL of the API
ApiService.init(process.env.VUE_APP_ROOT_API);

// If token exists set header
if (TokenService.getToken()) {
    ApiService.setHeader();
}


Vue.use(VueRouter);
Vue.use(Vuex);


new Vue({
    el: '#root',
    router: router,
    store
});



import Vue from 'vue';
import Vuex from 'vuex';

import UserModule from './user'
import securityModule from './security'
import mobileMenu from './mobileMenu'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        user: UserModule,
        mobileMenu: mobileMenu,
        security: securityModule
    }
});
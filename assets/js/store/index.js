import Vue from 'vue';
import Vuex from 'vuex';

import UserModule from './user'
import securityModule from './security'
import mobileMenuModule from './mobileMenu'
import AppCommonModule from './appCommon'
import SideBarModule from './sideBar'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        user: UserModule,
        mobileMenu: mobileMenuModule,
        security: securityModule,
        common: AppCommonModule,
        sideBar: SideBarModule
    }
});
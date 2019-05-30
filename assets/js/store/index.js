import Vue from 'vue';
import Vuex from 'vuex';

import UserModule from './user'
import securityModule from './security'
import NavbarModule from './navbar'
import AppCommonModule from './appCommon'
import SideBarModule from './sideBar'
import ActivityModule from './activity'
import PromotionModule from './promotion'
import InformationModule from './information'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        user: UserModule,
        navbar: NavbarModule,
        security: securityModule,
        common: AppCommonModule,
        sideBar: SideBarModule,
        activity: ActivityModule,
        promotion: PromotionModule,
        information: InformationModule
    }
});
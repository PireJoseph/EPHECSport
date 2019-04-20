import Vue from 'vue'
import Vuex from 'vuex'

import { mapGetters } from 'vuex'
import { mapMutations } from 'vuex'


import VueRouter from 'vue-router'

import router from './router';
import store from './store';

require('../css/user.css');

// import Example from './components/Example'

// import App from './views/app'

Vue.use(VueRouter)
Vue.use(Vuex)


new Vue({
    el: '#root',
    router: router,
    store,
    // components: {App},
    // computed: {
    //     // mobileMenuShowed ()
    //     // {
    //     //     return store.getters['mobileMenu/isMobileMenuShowed']
    //     // }
    //     ...mapGetters({
    //         isAuthenticated:  'security/isAuthenticated',
    //         mobileMenuShowed: 'mobileMenu/isMobileMenuShowed',
    //         // currentUserId: 'user/currentUserId'
    //     })
    // },
    // methods: {
    //     // toggleNavMenu() {
    //     //     store.commit('mobileMenu/TOGGLE_MOBILE_MENU')
    //     // },
    //     // closeNavMenu() {
    //     //     store.commit('mobileMenu/CLOSE_MOBILE_MENU')
    //     // },
    //     // makeApiCall(){
    //     //     this.$store.dispatch('user/fetchCurrentUser')
    //     // },
    //     ...mapMutations({
    //         toggleNavMenu : 'mobileMenu/TOGGLE_MOBILE_MENU',
    //         closeNavMenu : 'mobileMenu/CLOSE_MOBILE_MENU'
    //     })
    // },
    // mounted: function(){
    //     this.makeApiCall()
    // }
})



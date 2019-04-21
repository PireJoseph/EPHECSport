export default {
    namespaced: true,
    state: {
        isMobileMenuOpen: false,
    },
    getters: {
        isMobileMenuShowed (state) {
            return state.isMobileMenuOpen;
        },
    },
    mutations: {
        ['TOGGLE_MOBILE_MENU'](state) {
            state.isMobileMenuOpen = !state.isMobileMenuOpen;
        },
        ['CLOSE_MOBILE_MENU'](state) {
            state.isMobileMenuOpen = false;
        },
    },
    actions : {
        toggleNavMenu({commit}){
            commit('TOGGLE_MOBILE_MENU');
        },
        closeNavMenu({commit}){
            commit('CLOSE_MOBILE_MENU');
        },
    },


}
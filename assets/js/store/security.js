import SecurityAPI from '../api/security';

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        isAuthenticated: false,
        token: null,
    },
    getters: {
        isLoading (state) {
            return state.isLoading;
        },
        hasError (state) {
            return state.error !== null;
        },
        error (state) {
            return state.error;
        },
        isAuthenticated (state) {
            return state.isAuthenticated;
        },
        token (state) {
            return state.token
        },
    },
    mutations: {
        ['AUTHENTICATING'](state) {
            state.isLoading = true;
            state.error = null;
            state.isAuthenticated = false;
            state.token = null;
        },
        ['AUTHENTICATING_SUCCESS'](state, data) {
            let token = data.token;
            localStorage.setItem('token', token);
            state.isLoading = false;
            state.error = null;
            state.isAuthenticated = true;
            state.token = token;
            // console.log( localStorage.getItem('token'));
            this.dispatch('user/fetchCurrentUser')
        },
        ['AUTHENTICATING_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error.message;
            state.isAuthenticated = false;
            state.token = null;
        },
        ['LOGOUT'](state) {
            localStorage.removeItem('token');
            state.isLoading = false;
            state.error = null;
            state.isAuthenticated = false;
            state.token = null;
        },
    },
    actions: {
        login ({commit}, payload) {
            commit('AUTHENTICATING');
            return SecurityAPI.login(payload.login, payload.password)
                .then(res => commit('AUTHENTICATING_SUCCESS', res.data))
                .catch(err => commit('AUTHENTICATING_ERROR', err));
        },
    },
}
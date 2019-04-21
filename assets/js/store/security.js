import SecurityAPI from '../api/security';

import TokenService from '../services/token'
import ApiService from '../services/api'

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        isAuthenticated: false,
        token: null,
        refreshToken: null,
        refreshTokenPromise: null,
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
        refreshToken (state) {
            return state.refreshToken
        },
        refreshTokenPromise (state) {
            return state.refreshTokenPromise
        }
    },
    mutations: {
        ['AUTHENTICATING'](state) {

            state.isLoading = true;
            state.error = null;
            state.isAuthenticated = false;
            state.token = null;
            state.refreshToken = null;
        },
        ['AUTHENTICATING_SUCCESS'](state, data) {
            let token = data.token;
            let refresh_token = data.refresh_token;
            TokenService.saveToken(token);
            TokenService.saveRefreshToken(refresh_token);

            state.isLoading = false;
            state.error = null;
            state.isAuthenticated = true;
            state.token = token;
            state.refreshToken = refresh_token;

            ApiService.setHeader();

        },
        ['AUTHENTICATING_ERROR'](state, error) {
            TokenService.removeToken();
            TokenService.removeRefreshToken();

            state.isLoading = false;
            state.error = error.message;
            state.isAuthenticated = false;
            state.token = null;
            state.refreshToken = null;

        },
        ['REFRESHING_TOKEN'](state) {

            state.isLoading = true;
            state.error = null;
            state.isAuthenticated = false;
            state.token = null;
            state.refreshToken = null;
        },
        ['REFRESHING_TOKEN_SUCCESS'](state, data) {
            let token = data.token;
            let refresh_token = data.refresh_token;
            TokenService.saveToken(token);
            TokenService.saveRefreshToken(refresh_token);

            state.isLoading = false;
            state.error = null;
            state.isAuthenticated = true;
            state.token = token;
            state.refreshToken = refresh_token;

            ApiService.setHeader();
        },
        ['REFRESHING_TOKEN_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error.message;
            state.isAuthenticated = false;
            state.token = null;
            state.refreshToken = null;
        },
        ['REFRESH_TOKEN_PROMISE'](state, promise){
            state.refreshTokenPromise = promise;
        },
        ['LOGOUT'](state) {
            localStorage.removeItem('token');
            localStorage.removeItem('refresh_token');

            state.isLoading = false;
            state.error = null;
            state.isAuthenticated = false;
            state.token = null;
            state.refreshToken = null;
        },
    },
    actions: {
        login ({commit}, payload) {
            commit('AUTHENTICATING');
            return SecurityAPI.login(payload.login, payload.password)
                .then(res => commit('AUTHENTICATING_SUCCESS', res.data))
                .catch(err => commit('AUTHENTICATING_ERROR', err));
        },
        refreshToken({commit, state}, payload) {
            commit('REFRESHING_TOKEN');
            // If this is the first time the refreshToken has been called, make a request
            // otherwise return the same promise to the caller
            if(!state.refreshTokenPromise) {
                const p = SecurityAPI.refreshToken(payload.token, payload.refresh_token);
                commit('REFRESH_TOKEN_PROMISE', p);
                // Wait for the UserService.refreshToken() to resolve. On success set the token and clear promise
                // Clear the promise on error as well.
                p.then(
                    response => {
                        commit('REFRESHING_TOKEN_SUCCESS', response.data);
                        commit('REFRESH_TOKEN_PROMISE', null)
                    },
                    error => {
                        commit('REFRESHING_TOKEN_ERROR', error);
                        commit('REFRESH_TOKEN_PROMISE', null)
                    }
                )
            }
            return state.refreshTokenPromise
        }
    },
}
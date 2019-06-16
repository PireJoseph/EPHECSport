import SecurityAPI from '../api/security';

import TokenService from '../services/token'
import ApiService from '../services/api'
import Router from '../router/index'

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
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
        refreshTokenPromise (state) {
            return state.refreshTokenPromise
        }
    },
    mutations: {
        ['AUTHENTICATING'](state) {
            state.isLoading = true;
            state.error = null;

        },
        ['AUTHENTICATING_SUCCESS'](state, data) {
            let token = data.token;
            let refresh_token = data.refresh_token;
            let refresh_token_expiration = data.data.refresh_token_expiration;

            TokenService.saveToken(token);
            TokenService.saveRefreshToken(refresh_token);
            TokenService.saveRefreshTokenExpiration(refresh_token_expiration);

            state.isLoading = false;
            state.error = null;

            ApiService.setHeader();

        },
        ['AUTHENTICATING_ERROR'](state, error) {
            TokenService.removeToken();
            TokenService.removeRefreshToken();
            TokenService.removeRefreshTokenExpiration();
            state.isLoading = false;
            state.error = error.message;


        },
        ['REFRESHING_TOKEN'](state) {

            state.isLoading = true;
            state.error = null;

        },
        ['REFRESHING_TOKEN_SUCCESS'](state, data) {
            let token = data.token;
            let refresh_token = data.refresh_token;
            let refresh_token_expiration = data.data.refresh_token_expiration;

            TokenService.saveToken(token);
            TokenService.saveRefreshToken(refresh_token);
            TokenService.saveRefreshTokenExpiration(refresh_token_expiration);

            state.isLoading = false;
            state.error = null;
            ApiService.setHeader();
        },
        ['REFRESHING_TOKEN_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error.message;
        },
        ['REFRESH_TOKEN_PROMISE'](state, promise){
            state.refreshTokenPromise = promise;
        },
        ['LOGOUT'](state) {
            TokenService.removeToken();
            TokenService.removeRefreshToken();
            TokenService.removeRefreshTokenExpiration();
            Router.push({path: '/user/login'});

            state.isLoading = false;
            state.error = null;
        },
    },
    actions: {
        login ({commit}, payload) {
            commit('AUTHENTICATING');
            return SecurityAPI.login(payload.login, payload.password)
                .then(
                    res => {
                        commit('AUTHENTICATING_SUCCESS', res.data)
                    }
                )
                .catch(
                    err => {
                        commit('AUTHENTICATING_ERROR', err)
                    }
                );
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
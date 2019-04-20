import UserAPI from '../api/user';

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        currentUser: null,
        currentUserId: '0'
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
        currentUser (state) {
            return state.currentUser
        },
        currentUserId (state) {
            return state.currentUserId
        }
    },
    mutations: {

        // ['UPDATING_CURRENT_USER'](state) {
        //     state.isLoading = true;
        //     state.error = null;
        // },
        // ['UPDATING_CURRENT_USER_SUCCESS'](state, user) {
        //     state.isLoading = false;
        //     state.error = null;
        //     state.currentUser = user
        // },
        // ['UPDATING_CURRENT_USER_ERROR'](state, error) {
        //     state.isLoading = false;
        //     state.error = error;
        //     state.currentUser = null
        // },

        ['FETCHING_CURRENT_USER'](state) {
            state.isLoading = true;
            state.error = null;
            state.currentUser = null;
        },
        ['FETCHING_CURRENT_USER_SUCCESS'](state, user) {
            state.isLoading = false;
            state.error = null;
            state.currentUser = user;
        },
        ['FETCHING_CURRENT_USER_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error.message;
            state.currentUser = null;
        },

    },
    actions : {
        // updateCurrentUser({commit}, user){
        //     commit('UPDATING_CURRENT_USER');
        //     return UserAPI.post
        // }
        fetchCurrentUser({commit}, id){
            commit('FETCHING_CURRENT_USER');
            return UserAPI.get(id)
                .then(res => commit('FETCHING_CURRENT_USER_SUCCESS', res.data))
                .catch(err => commit('FETCHING_CURRENT_USER_ERROR', err))
        }
    }

}
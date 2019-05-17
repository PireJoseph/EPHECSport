import AppCommonApi from "../api/appCommon";

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        baseDataLoaded: false
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
        baseDataLoaded (state) {
            return state.baseDataLoaded;
        },
    },
    mutations: {
        ['GETTING_BASE_DATA'](state) {
            state.isLoading = true;
            state.error = null;
            // state.baseDataLoaded = false;
        },
        ['GETTING_BASE_DATA_SUCCESS'](state, data) {
            // commit changement dans useStore
            state.isLoading = false;
            state.error = null;
            state.baseDataLoaded = true;
        },
        ['GETTING_BASE_DATA_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error.message;
            state.baseDataLoaded = false;
        },
    },
    actions : {
        loadBaseData ({commit}, payload) {
            commit('GETTING_BASE_DATA');
            return AppCommonApi.get(payload.userId)
                .then(
                    res => {
                        commit('GETTING_BASE_DATA_SUCCESS', res.data);
                        commit('user/SET_USER_BASE_DATA', res.data.userDTO, { root: true });
                        commit('activity/SET_SPORT_DTOS', res.data.sportDTOs, {root: true})
                    }
                )
                .catch(
                    err => {
                        commit('GETTING_BASE_DATA_ERROR', err)
                    }
                );
        },
    }


}
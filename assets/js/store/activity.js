
export default {
    namespaced: true,
    state: {
        sportDTOs: []
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
        sportDTOs (state) {
            return state.sportDTOs;
        }
    },
    mutations: {
        ['SET_SPORT_DTOS'](state, sportDTOS) {
            state.sportDTOs = sportDTOS;
        },
    },
    actions : {
    }

}
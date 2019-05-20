import PromotionAPI from "../api/promotion";

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        crucialMeetings : null,
        crucialMeetingsLoading : false,
        crucialMeetingsErrors : null,
        officialTeams : null,
        officialTeamsLoading: false,
        officialTeamsErrors : null

    },
    getters : {
        isLoading (state) {
            return state.isLoading;
        },
        hasError (state) {
            return state.error !== null;
        },
        error (state) {
            return state.error;
        },
        crucialMeetings (state) {
            return state.crucialMeetings;
        },
        crucialMeetingsLoading (state) {
            return state.crucialMeetingsLoading;
        },
        crucialMeetingsErrors (state) {
            return state.crucialMeetingsErrors;
        },
        officialTeams (state) {
            return state.officialTeams;
        },
        officialTeamsLoading (state) {
            return state.officialTeamsLoading;
        },
        officialTeamsErrors (state) {
            return state.officialTeamsErrors;
        },
    },
    mutations: {

        ['GETTING_CRUCIAL_MEETINGS_DATA'](state){
            state.isLoading = true;
            state.error = null;
            state.crucialMeetings = null;
            state.crucialMeetingsLoading = true;
            state.crucialMeetingsErrors = null;
        },
        ['GET_CRUCIAL_MEETINGS_DATA_SUCCESS'](state, crucialMeetings){
            state.isLoading = false;
            state.error = null;
            state.crucialMeetings = crucialMeetings;
            state.crucialMeetingsLoading = false;
            state.crucialMeetingsErrors = null;
        },
        ['GET_CRUCIAL_MEETINGS_DATA_ERROR'](state, error){
            state.isLoading = false;
            state.error = error.message;
            state.crucialMeetings = null;
            state.crucialMeetingsLoading = false;
            state.crucialMeetingsErrors = error.message;
        },
        ['GETTING_CRUCIAL_MEETINGS_DATA'](state){
            state.isLoading = true;
            state.error = null;
            state.crucialMeetings = null;
            state.crucialMeetingsLoading = true;
            state.crucialMeetingsErrors = null;
        },
        ['GET_CRUCIAL_MEETINGS_DATA_SUCCESS'](state, crucialMeetings){
            state.isLoading = false;
            state.error = null;
            state.crucialMeetings = crucialMeetings;
            state.crucialMeetingsLoading = false;
            state.crucialMeetingsErrors = null;
        },
        ['GET_CRUCIAL_MEETINGS_DATA_ERROR'](state, error){
            state.isLoading = false;
            state.error = error.message;
            state.crucialMeetings = null;
            state.crucialMeetingsLoading = false;
            state.crucialMeetingsErrors = error.message;
        },

    },
    actions : {

        getCrucialMeetingsData({commit}) {
            commit('GETTING_CRUCIAL_MEETINGS_DATA');
            return PromotionAPI.getCrucialMeetingsData()
                .then(
                    function(res){
                        commit('GET_CRUCIAL_MEETINGS_DATA_SUCCESS', res.data['hydra:member'])
                    }
                )
                .catch(err => commit('GET_CRUCIAL_MEETINGS_DATA_ERROR', err))
        },
        getOfficialTeamsData({commit}) {
            commit('GETTING_OFFICIAL_TEAMS_DATA');
            return PromotionAPI.getOfficialTeamsData()
                .then(
                    function(res){
                        commit('GET_OFFICIAL_TEAMS_DATA_SUCCESS', res.data['hydra:member'])
                    }
                )
                .catch(err => commit('GET_OFFICIAL_TEAMS_DATA_ERROR', err))
        },


    }

}
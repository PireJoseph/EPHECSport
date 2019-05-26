import PromotionAPI from "../api/promotion";

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,

        crucialMeetings : [],
        crucialMeetingsLoading : false,
        crucialMeetingsErrors : null,

        officialTeams : [],
        officialTeamsLoading: false,
        officialTeamsErrors : null,

        shoutOutsForSelectedTeam: [],
        shoutOutsForSelectedTeamLoading : false,
        shoutOutsForSelectedTeamError : null,

        postTeamShoutOutLoading : false,
        postTeamShoutOutLoadingError : null

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
            state.crucialMeetings = [];
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
            state.crucialMeetings = [];
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


        ['GETTING_OFFICIAL_TEAMS_DATA'](state){
            state.isLoading = true;
            state.error = null;
            state.officialTeams = [];
            state.officialTeamsLoading = true;
            state.officialTeamsErrors = null;
        },
        ['GET_OFFICIAL_TEAMS_DATA_SUCCESS'](state, officialTeams){
            state.isLoading = false;
            state.error = null;
            state.officialTeams = officialTeams;
            state.officialTeamsLoading = false;
            state.officialTeamsErrors = null;
        },
        ['GET_OFFICIAL_TEAMS_DATA_ERROR'](state, error){
            state.isLoading = false;
            state.error = error.message;
            state.officialTeams = null;
            state.officialTeamsLoading = false;
            state.officialTeamsErrors = error.message;
        },


        ['GETTING_SHOUT_OUTS_FOR_SELECTED_TEAM_DATA'](state){
            state.isLoading = true;
            state.error = null;
            state.shoutOutsForSelectedTeam = [];
            state.shoutOutsForSelectedTeamLoading = true;
            state.shoutOutsForSelectedTeamError = null;
        },
        ['GET_SHOUT_OUTS_FOR_SELECTED_TEAM_DATA_SUCCESS'](state, shoutOuts){
            state.isLoading = false;
            state.error = null;
            state.shoutOutsForSelectedTeam = shoutOuts;
            state.shoutOutsForSelectedTeamLoading = false;
            state.shoutOutsForSelectedTeamError = null;
        },
        ['GET_SHOUT_OUTS_FOR_SELECTED_TEAM_DATA_ERROR'](state, error){
            state.isLoading = false;
            state.error = error.message;
            state.shoutOutsForSelectedTeam = [];
            state.shoutOutsForSelectedTeamLoading = false;
            state.shoutOutsForSelectedTeamError = error.message;
        },


        ['POSTING_SHOUT_OUT'](state){
            state.isLoading = true;
            state.error = null;
            state.postTeamShoutOutLoading = true;
            state.postTeamShoutOutLoadingError = null;
        },
        ['POST_SHOUT_OUT_SUCCESS'](state){
            state.isLoading = false;
            state.error = null;
            state.postTeamShoutOutLoading = false;
            state.postTeamShoutOutLoadingError = null;
        },
        ['POST_SHOUT_OUT_ERROR'](state, error){
            state.isLoading = false;
            state.error = error.message;
            state.postTeamShoutOutLoading = true;
            state.postTeamShoutOutLoadingError = error.message;
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
        getShoutOutsForSelectedTeam({commit}, payload) {
            commit('GETTING_SHOUT_OUTS_FOR_SELECTED_TEAM_DATA');
            return PromotionAPI.getShoutOutsForAnOfficialTeam(payload)
                .then(
                    function(res){
                        commit('GET_SHOUT_OUTS_FOR_SELECTED_TEAM_DATA_SUCCESS', res.data['hydra:member'])
                    }
                )
                .catch(err => commit('GET_SHOUT_OUTS_FOR_SELECTED_TEAM_DATA_ERROR', err))
        },
        postShoutOut({commit}, payload) {
            console.log(payload)
            commit('POSTING_SHOUT_OUT');
            return PromotionAPI.postShoutOut(payload)
                .then(
                    function(res){
                        commit('POST_SHOUT_OUT_SUCCESS')
                    }
                )
                .catch(err => commit('POST_SHOUT_OUT_ERROR', err))
        }


    }

}
import ActivityAPI from "../api/activity";

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        sportDTOs: [],
        activityHistory: [],
        invitations: [],
        activityAvailable: [],
        participations: [],
        isActivityHistoryFeedbackLoading : false,
        activityHistoryFeedbackLoadingError : false,
        activityHistoryFeedback : null,
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
        },
        activityHistory (state) {
            return state.activityHistory;
        },
        invitations (state) {
            return state.invitations;
        },
        activityAvailable (state) {
            return state.activityAvailable;
        },
        participations (state) {
            return state.participations;
        },
        activityHistoryFeedback (state) {
            return state.activityHistoryFeedback;
        },
        isActivityHistoryFeedbackLoading (state) {
            return state.isActivityHistoryFeedbackLoading;
        },
        activityHistoryFeedbackLoadingError (state) {
            return state.activityHistoryFeedbackLoadingError;
        }

    },
    mutations: {
        ['SET_SPORT_DTOS'](state, sportDTOS) {
            state.sportDTOs = sportDTOS;
        },
        ['GETTING_ACTIVITY_HISTORY_DATA'](state){
            state.isLoading = true;
            state.error = null;
        },
        ['GET_ACTIVITY_HISTORY_DATA_SUCCESS'](state, activityHistory){
            state.isLoading = false;
            state.error = null;
            state.activityHistory = activityHistory;
        },
        ['GET_ACTIVITY_HISTORY_DATA_ERROR'](state, error){
            state.isLoading = false;
            state.error = error.message;
        },
        ['GETTING_ACTIVITY_HISTORY_FEEDBACK'](state){
            state.isActivityHistoryFeedbackLoading = true;
            state.activityHistoryFeedbackLoadingError = null;
        },
        ['GET_ACTIVITY_HISTORY_FEEDBACK_SUCCESS'](state, activityFeedback){
            state.isActivityHistoryFeedbackLoading = false;
            state.activityHistoryFeedbackLoadingError = null;
            state.activityHistoryFeedback = activityFeedback;
        },
        ['GET_ACTIVITY_HISTORY_FEEDBACK_ERROR'](state, error){
            state.isActivityHistoryFeedbackLoading = false;
            state.activityHistoryFeedbackLoadingError = error.message;
        },
        ['POSTING_ACTIVITY_HISTORY_FEEDBACK'](state){
            state.isActivityHistoryFeedbackLoading = true;
            state.activityHistoryFeedbackLoadingError = null;
        },
        ['POST_ACTIVITY_HISTORY_FEEDBACK_SUCCESS'](state, activityFeedback){
            state.isActivityHistoryFeedbackLoading = false;
            state.activityHistoryFeedbackLoadingError = null;
            state.activityHistoryFeedback = activityFeedback;
        },
        ['POST_ACTIVITY_HISTORY_FEEDBACK_ERROR'](state, error){
            state.isActivityHistoryFeedbackLoading = false;
            state.activityHistoryFeedbackLoadingError = error.message;
        },
        ['PUTTING_ACTIVITY_HISTORY_FEEDBACK'](state){
            state.isActivityHistoryFeedbackLoading = true;
            state.activityHistoryFeedbackLoadingError = null;
        },
        ['PUT_ACTIVITY_HISTORY_FEEDBACK_SUCCESS'](state, activityFeedback){
            state.isActivityHistoryFeedbackLoading = false;
            state.activityHistoryFeedbackLoadingError = null;
            state.activityHistoryFeedback = activityFeedback;
        },
        ['PUT_ACTIVITY_HISTORY_FEEDBACK_ERROR'](state, error){
            state.isActivityHistoryFeedbackLoading = false;
            state.activityHistoryFeedbackLoadingError = error.message;
        },
    },
    actions : {

        getActivityHistory({commit}) {
            commit('GETTING_ACTIVITY_HISTORY_DATA');
            return ActivityAPI.getActivityHistory()
                .then(
                    function(res){
                        commit('GET_ACTIVITY_HISTORY_DATA_SUCCESS', res.data['hydra:member'])
                    }
                )
                .catch(err => commit('GET_ACTIVITY_HISTORY_DATA_ERROR', err))
        },
        getActivityHistoryFeedback({commit},payload) {
            commit('GETTING_ACTIVITY_HISTORY_FEEDBACK');
            return ActivityAPI.getActivityHistoryFeedback(payload)
                .then(
                    function(res){
                        commit('GET_ACTIVITY_HISTORY_FEEDBACK_SUCCESS', res.data)
                    }
                )
                .catch(
                    function(err) {
                        if(404 === err.response.status) {
                            commit('GET_ACTIVITY_HISTORY_FEEDBACK_SUCCESS', null)
                        } else {
                            commit('GET_ACTIVITY_HISTORY_FEEDBACK_ERROR', err)
                        }
                    }
                )

        },
        postActivityHistoryFeedback({commit}, payload) {
            commit('POSTING_ACTIVITY_HISTORY_FEEDBACK');
            return ActivityAPI.postActivityHistoryFeedback(payload)
                .then(
                    function(res){
                        commit('POST_ACTIVITY_HISTORY_FEEDBACK_SUCCESS', res.data)
                    }
                )
                .catch(err => commit('POST_ACTIVITY_HISTORY_FEEDBACK_ERROR', err))
        },
        putActivityHistoryFeedback({commit}, payload) {
            commit('PUTTING_ACTIVITY_HISTORY_FEEDBACK');
            let id = payload.activityRelatedFeedbackId;
            console.log(payload)
            return ActivityAPI.putActivityHistoryFeedback(id, payload)
                .then(
                    function(res){
                        commit('PUT_ACTIVITY_HISTORY_FEEDBACK_SUCCESS',res.data)
                    }
                )
                .catch(err => commit('PUT_ACTIVITY_HISTORY_FEEDBACK_ERROR', err))
        },

    }

}
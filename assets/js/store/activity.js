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
        availableActivities : [],
        activityJoiningRequestLoading : false,
        activityJoiningRequestError : null,
        activityInvitations : [],
        activityInvitationAnswerLoading : false,
        activityInvitationAnswerError : null,
        activityParticipations : [],
        activityParticipationConfirmationLoading : false,
        activityParticipationConfirmationError: null,
        activityCancellationLoading: false,
        activityCancellationError: null,
        activityParticipationsForAnActivity : null,
        activityParticipationsForAnActivityLoading : false,
        activityParticipationsForAnActivityError : null,
        userRelatedFeedbacksForAnActivity : [],
        userRelatedFeedbacksForAnActivityLoading : false,
        userRelatedFeedbacksForAnActivityError : null,
        postUserRelatedFeedbackLoading : false,
        postUserRelatedFeedbackError: null

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
        },
        availableActivities (state) {
            return state.availableActivities
        },
        activityJoiningRequestLoading (state) {
            return state.activityJoiningRequestLoading;
        },
        activityJoiningRequestError (state) {
            return state.activityJoiningRequestError
        },
        activityInvitations (state) {
            return state.activityInvitations
        },
        activityInvitationAnswerLoading (state) {
            return state.activityInvitationAnswerLoading
        },
        activityInvitationAnswerError (state) {
            return state.activityInvitationAnswerError
        },
        activityParticipations (state) {
            return state.activityParticipations
        },
        activityParticipationConfirmationLoading (state) {
            return state.activityParticipationConfirmationLoading
        },
        activityParticipationConfirmationError (state) {
            return state.activityParticipationConfirmationError
        },
        activityCancellationLoading (state) {
            return state.activityCancellationLoading
        },
        activityCancellationError (state) {
            return state.activityCancellationError
        },
        activityParticipationsForAnActivity (state) {
            return state.activityParticipationsForAnActivity
        },
        activityParticipationsForAnActivityLoading (state) {
            return state.activityParticipationsForAnActivityLoading
        },
        activityParticipationsForAnActivityError (state) {
            return state.activityParticipationsForAnActivityError
        },
        userRelatedFeedbacksForAnActivity (state) {
            return state.userRelatedFeedbacksForAnActivity
        },
        userRelatedFeedbacksForAnActivityLoading (state) {
            return state.userRelatedFeedbacksForAnActivityLoading
        },
        userRelatedFeedbacksForAnActivityError (state) {
            return state.userRelatedFeedbacksForAnActivityLoading
        },
        postUserRelatedFeedbackLoading (state) {
            return state.postUserRelatedFeedbackLoading
        },
        postUserRelatedFeedbackError (state) {
            return state.postUserRelatedFeedbackError
        },

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
        ['GETTING_AVAILABLE_ACTIVITIES_DATA'](state){
            state.isLoading = true;
            state.error = null;
        },
        ['GET_AVAILABLE_ACTIVITIES_DATA_SUCCESS'](state, availableActivities){
            state.isLoading = false;
            state.error = null;
            state.availableActivities = availableActivities;
        },
        ['GET_AVAILABLE_ACTIVITIES_DATA_ERROR'](state, error){
            state.isLoading = false;
            state.error = error.message;
        },
        ['MAKING_ACTIVITY_JOINING_REQUEST'](state){
            state.activityJoiningRequestLoading = true;
            state.activityJoiningRequestError = null;
        },
        ['MAKE_ACTIVITY_JOINING_REQUEST_SUCCESS'](state){
            state.activityJoiningRequestLoading = false;
            state.activityJoiningRequestError = null;
        },
        ['MAKE_ACTIVITY_JOINING_REQUEST_ERROR'](state, error){
            state.activityJoiningRequestLoading = false;
            state.activityJoiningRequestError = error.message;
        },
        ['GETTING_ACTIVITY_INVITATIONS_DATA'](state){
            state.isLoading = true;
            state.error = null;
        },
        ['GET_ACTIVITY_INVITATIONS_DATA_SUCCESS'](state, activityInvitations){
            state.isLoading = false;
            state.error = null;
            state.activityInvitations = activityInvitations;
        },
        ['GET_ACTIVITY_INVITATIONS_DATA_ERROR'](state, error){
            state.isLoading = false;
            state.error = error.message;
        },
        ['ANSWERING_ACTIVITY_INVITATION'](state){
            state.activityInvitationAnswerLoading = true;
            state.activityInvitationAnswerError = null;
        },
        ['ANSWER_ACTIVITY_INVITATION_SUCCESS'](state){
            state.activityInvitationAnswerLoading = false;
            state.activityInvitationAnswerError = null;
        },
        ['ANSWER_ACTIVITY_INVITATION_ERROR'](state, error){
            state.activityInvitationAnswerLoading = false;
            state.activityInvitationAnswerError = error.message;
        },
        ['GETTING_ACTIVITY_PARTICIPATIONS_DATA'](state){
            state.isLoading = true;
            state.error = null;
        },
        ['GET_ACTIVITY_PARTICIPATIONS_DATA_SUCCESS'](state, activityParticipations){
            state.isLoading = false;
            state.error = null;
            state.activityParticipations = activityParticipations;
        },
        ['GET_ACTIVITY_PARTICIPATIONS_DATA_ERROR'](state, error){
            state.isLoading = false;
            state.error = error.message;
        },
        ['CONFIRMING_ACTIVITY_PARTICIPATION'](state){
            state.activityParticipationConfirmationLoading = true;
            state.activityParticipationConfirmationError = null;
        },
        ['CONFIRM_ACTIVITY_PARTICIPATION_SUCCESS'](state){
            state.activityParticipationConfirmationLoading = false;
            state.activityParticipationConfirmationError = null;
        },
        ['CONFIRM_ACTIVITY_PARTICIPATION_ERROR'](state, error){
            state.activityParticipationConfirmationLoading = false;
            state.activityParticipationConfirmationError = error.message;
        },
        ['POSTING_ACTIVITY_CANCELLATION'](state){
            state.activityCancellationLoading = true;
            state.activityCancellationError = null;
        },
        ['POST_ACTIVITY_CANCELLATION_SUCCESS'](state){
            state.activityCancellationLoading = false;
            state.activityCancellationError = null;
        },
        ['POST_ACTIVITY_CANCELLATION_ERROR'](state, error){
            state.activityCancellationLoading = false;
            state.activityCancellationError = error.message;
        },
        ['GETTING_ACTIVITY_PARTICIPATION_FOR_AN_ACTIVITY'](state){
            state.activityParticipationsForAnActivity = [];
            state.isLoading = true;
            state.activityParticipationsForAnActivityLoading = true;
            state.error = null;
            state.activityParticipationsForAnActivityError = null;
        },
        ['GET_ACTIVITY_PARTICIPATION_FOR_AN_ACTIVITY_SUCCESS'](state, activityParticipations){
            state.activityParticipationsForAnActivity = activityParticipations;
            state.isLoading = false;
            state.activityParticipationsForAnActivityLoading = false;
            state.error = null;
            state.activityParticipationsForAnActivityError = null;
        },
        ['GET_ACTIVITY_PARTICIPATION_FOR_AN_ACTIVITY_ERROR'](state, error){
            state.activityParticipationsForAnActivity = [];
            state.isLoading = false;
            state.activityParticipationsForAnActivityLoading = false;
            state.error = error.message;
            state.activityParticipationsForAnActivityError = error.message;
        },
        ['GETTING_USER_RELATED_FEEDBACKS_FOR_AN_ACTIVITY'](state){
            state.userRelatedFeedbacksForAnActivity = null;
            state.isLoading = true;
            state.userRelatedFeedbacksForAnActivityLoading = true;
            state.error = null;
            state.userRelatedFeedbacksForAnActivityError = null;
        },
        ['GET_USER_RELATED_FEEDBACKS_FOR_AN_ACTIVITY_SUCCESS'](state, userRelatedFeedbacksForAnActivity){
            state.userRelatedFeedbacksForAnActivity = userRelatedFeedbacksForAnActivity;
            state.isLoading = false;
            state.userRelatedFeedbacksForAnActivityLoading = false;
            state.error = null;
            state.userRelatedFeedbacksForAnActivityError = null;
        },
        ['GET_USER_RELATED_FEEDBACKS_FOR_AN_ACTIVITY_ERROR'](state, error){
            state.userRelatedFeedbacksForAnActivity = null;
            state.isLoading = false;
            state.userRelatedFeedbacksForAnActivityLoading = false;
            state.error = error.message;
            state.userRelatedFeedbacksForAnActivityError = error.message;
        },
        ['POSTING_USER_RELATED_FEEDBACK'](state){
            state.postUserRelatedFeedbackLoading = true;
            state.postUserRelatedFeedbackError = null;
        },
        ['POST_USER_RELATED_FEEDBACK_SUCCESS'](state){
            state.postUserRelatedFeedbackLoading = false;
            state.postUserRelatedFeedbackError = null;
        },
        ['POST_USER_RELATED_FEEDBACK_ERROR'](state, error){
            state.postUserRelatedFeedbackLoading = false;
            state.postUserRelatedFeedbackError = error.message;
        }

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
            return ActivityAPI.putActivityHistoryFeedback(id, payload)
                .then(
                    function(res){
                        commit('PUT_ACTIVITY_HISTORY_FEEDBACK_SUCCESS',res.data)
                    }
                )
                .catch(err => commit('PUT_ACTIVITY_HISTORY_FEEDBACK_ERROR', err))
        },
        getAvailableActivities({commit}) {
            commit('GETTING_AVAILABLE_ACTIVITIES_DATA');
            return ActivityAPI.getAvailableActivities()
                .then(
                    function(res){
                        console.log(res.data);
                        commit('GET_AVAILABLE_ACTIVITIES_DATA_SUCCESS', res.data['hydra:member'])
                    }
                )
                .catch(err => commit('GET_AVAILABLE_ACTIVITIES_DATA_ERROR', err))
        },
        makeActivityJoiningRequest({commit}, payload) {
            commit('MAKING_ACTIVITY_JOINING_REQUEST');
            return ActivityAPI.makeActivityJoiningRequest(payload)
                .then(res => commit('MAKE_ACTIVITY_JOINING_REQUEST_SUCCESS'))
                .catch(err => commit('MAKE_ACTIVITY_JOINING_REQUEST_ERROR', err))
        },
        getActivityInvitations({commit}, payload) {
            commit('GETTING_ACTIVITY_INVITATIONS_DATA');
            return ActivityAPI.getActivityInvitations(payload)
                .then(res => commit('GET_ACTIVITY_INVITATIONS_DATA_SUCCESS',res.data['hydra:member']))
                .catch(err => commit('GET_ACTIVITY_INVITATIONS_DATA_ERROR', err))
        },
        answerActivityInvitation({commit}, payload) {
            commit('ANSWERING_ACTIVITY_INVITATION');
            let id = payload.id;
            return ActivityAPI.answerActivityInvitation(id, payload)
                .then(res => commit('ANSWER_ACTIVITY_INVITATION_SUCCESS'))
                .catch(err => commit('ANSWER_ACTIVITY_INVITATION_ERROR', err))
        },
        getActivityParticipations({commit}, payload) {
            commit('GETTING_ACTIVITY_PARTICIPATIONS_DATA');
            return ActivityAPI.getActivityParticipations(payload)
                .then(res => commit('GET_ACTIVITY_PARTICIPATIONS_DATA_SUCCESS',res.data['hydra:member']))
                .catch(err => commit('GET_ACTIVITY_PARTICIPATIONS_DATA_ERROR', err))
        },
        confirmActivityParticipation({commit}, payload) {
            commit('CONFIRMING_ACTIVITY_PARTICIPATION');
            let id = payload.id;
            return ActivityAPI.confirmActivityParticipation(id, payload)
                .then(res => commit('CONFIRM_ACTIVITY_PARTICIPATION_SUCCESS'))
                .catch(err => commit('CONFIRM_ACTIVITY_PARTICIPATION_ERROR', err))
        },
        postActivityCancellation({commit}, payload) {
            commit('POSTING_ACTIVITY_CANCELLATION');
            return ActivityAPI.postActivityCancellation(payload)
                .then(res => commit('POST_ACTIVITY_CANCELLATION_SUCCESS'))
                .catch(err => commit('POST_ACTIVITY_CANCELLATION_ERROR', err))
        },
        getActivityParticipationsForAnActivity({commit}, id) {
            commit('GETTING_ACTIVITY_PARTICIPATION_FOR_AN_ACTIVITY');
            return ActivityAPI.getActivityParticipationsForAnActivity(id)
                .then(res => commit('GET_ACTIVITY_PARTICIPATION_FOR_AN_ACTIVITY_SUCCESS',res.data['hydra:member']))
                .catch(err => commit('GET_ACTIVITY_PARTICIPATION_FOR_AN_ACTIVITY_ERROR', err))
        },
        getUserRelatedFeedbackForAnActivity({commit}, id) {
            commit('GETTING_USER_RELATED_FEEDBACKS_FOR_AN_ACTIVITY');
            return ActivityAPI.getUserRelatedFeedbackForAnActivity(id)
                .then(res => commit('GET_USER_RELATED_FEEDBACKS_FOR_AN_ACTIVITY_SUCCESS',res.data['hydra:member']))
                .catch(err => commit('GET_USER_RELATED_FEEDBACKS_FOR_AN_ACTIVITY_ERROR', err))
        },
        postUserRelatedFeedback({commit}, payload) {
            commit('POSTING_USER_RELATED_FEEDBACK');
            return ActivityAPI.postUserRelatedFeedback(payload)
                .then(res => commit('POST_USER_RELATED_FEEDBACK_SUCCESS'))
                .catch(err => commit('POST_USER_RELATED_FEEDBACK_ERROR', err))
        }
    }

}
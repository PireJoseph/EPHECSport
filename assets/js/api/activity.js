import ApiService from '../services/api'

export default {
    getActivityHistory() {
        return ApiService.get(
            '/api/activities/history',
        );
    },
    getActivityHistoryFeedback(id) {
        return ApiService.get(
            '/api/activities/'+ id + '/feedbacks/'
        )
    },
    postActivityHistoryFeedback(payload) {
        return ApiService.post(
            '/api/activities/feedbacks/',
            payload
        )
    },
    putActivityHistoryFeedback(id, payload) {
        return ApiService.put(
            '/api/activities/feedbacks/' + id,
            payload
        )
    },
    getAvailableActivities() {
        return ApiService.get(
            '/api/activities/available'
        );
    },
    makeActivityJoiningRequest(payload) {
        return ApiService.post(
            '/api/activities/requests/',
            payload
        )
    },
    getActivityInvitations() {
        return ApiService.get(
            '/api/activities/invitations/'
        );
    },
    answerActivityInvitation(id, payload) {
        return ApiService.put(
            '/api/activities/invitations/' + id,
            payload
        )
    },
    getActivityParticipations() {
        return ApiService.get(
            '/api/activities/participations/'
        );
    },
    confirmActivityParticipation(id, payload) {
        return ApiService.put(
            '/api/activities/participations/' + id,
            payload
        )
    },
    postActivityCancellation(payload) {
        return ApiService.post(
            '/api/activities/cancellations/',
            payload
        )
    },
    getActivityParticipationsForAnActivity(id) {
        return ApiService.get(
            '/api/activities/'+ id + '/participations/'
        )
    },
    getUserRelatedFeedbackForAnActivity(id) {
        return ApiService.get(
            '/api/user/feedbacks/activities/' + id
        )
    },
    postUserRelatedFeedback(payload) {
        return ApiService.post(
            '/api/user/feedbacks/',
            payload
        )
    },
}
import ApiService from '../services/api'

export default {
    getActivityHistory() {
        return ApiService.get(
            '/api/activities/history',
        );
    },
    getActivityHistoryFeedback(id) {
        return ApiService.get(
            '/api/activities/'+ id + '/feedbacks'
        )
    },
    postActivityHistoryFeedback(payload) {
        return ApiService.post(
            '/api/activity_related_feedbacks',
            payload
        )
    },
    putActivityHistoryFeedback(id, payload) {
        return ApiService.put(
            '/api/activity_related_feedbacks/' + id,
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
    }
}
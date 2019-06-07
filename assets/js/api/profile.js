import ApiService from '../services/api'

export default {
    put(id, data) {
        return ApiService.put(
            '/api/profiles/' + id,
           data
        );
    },
    getAll() {
        return ApiService.get(
            '/api/profiles/',
        );
    },
    postSportProfile(data) {
        return ApiService.post(
            '/api/sportprofiles/',
            data
        );
    },
    putSportProfile(id, data) {
        return ApiService.put(
            '/api/sportprofiles/' + id,
            data
        );
    },
    addPreferredPartner(id, data) {
        return ApiService.put(
            '/api/profiles/' + id  + '/partner/add',
            data
        );
    },
    removePreferredPartner(id, data) {
        return ApiService.put(
            '/api/profiles/' + id + '/partner/remove',
            data
        );
    }
}
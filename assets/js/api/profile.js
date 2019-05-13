import ApiService from '../services/api'

export default {
    put(id, data) {
        return ApiService.put(
            '/api/profile/' + id,
           data
        );
    },
    getAll() {
        return ApiService.get(
            '/api/profile/',
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
            '/api/profile/' + id  + '/partner/add',
            data
        );
    },
    removePreferredPartner(id, data) {
        return ApiService.put(
            '/api/profile/' + id + '/partner/remove',
            data
        );
    }
}
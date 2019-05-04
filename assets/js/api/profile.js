import ApiService from '../services/api'

export default {
    put(id, data) {
        return ApiService.put(
            '/api/profile/' + id,
            {
                username : data.username,
            }
        );
    },
}
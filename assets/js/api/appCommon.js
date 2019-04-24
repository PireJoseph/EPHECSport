import ApiService from '../services/api'

export default {
    // return basic info
    get(id) {
        return ApiService.get(
            '/api/app/' + id,
        );
    },
}
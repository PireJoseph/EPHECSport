import ApiService from '../services/api'

export default {
    get(id) {
        return ApiService.get(
            '/api/user/75',
        );
    },
}
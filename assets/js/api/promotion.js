import ApiService from '../services/api'

export default {
    getCrucialMeetingsData() {
        return ApiService.get(
            '/api/meetings/',
        );
    }
}
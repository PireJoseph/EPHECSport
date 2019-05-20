import ApiService from '../services/api'

export default {
    getCrucialMeetingsData() {
        return ApiService.get(
            '/api/meetings/',
        );
    },
    getOfficialTeamsData(){
        return ApiService.get(
            '/api/teams/',
        );
    }
}
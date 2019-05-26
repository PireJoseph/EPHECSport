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
    },
    getShoutOutsForAnOfficialTeam(id){
        return ApiService.get(
            '/api/teams/' + id +'/shoutouts/',
        );
    },
    postShoutOut(payload) {
        console.log(payload)
        return ApiService.post(
            '/api/shoutouts/',
            payload
        );
    }
}
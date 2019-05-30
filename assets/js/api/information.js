import ApiService from '../services/api'

export default {

    getExternalLinksData() {
        return ApiService.get(
            '/api/links/',
        );
    },

    getHealthProfessionalsData() {
        return ApiService.get(
            '/api/professionals/',
        );
    },


}
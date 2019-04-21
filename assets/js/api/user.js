import ApiService from '../services/api'

export default {
    get(id) {
        return ApiService.get(
            '/api/user/75',
        );
    },
    // put(user){
    //     return axios.put(
    //         '/api/user/' + id,
    //         {
    //             user: user
    //         }
    //     )
    // }
}
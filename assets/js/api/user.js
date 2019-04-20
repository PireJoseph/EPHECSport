import customAxios from './customAxios';

export default {
    get(id) {
        // console.log(localStorage.token)
        return customAxios.get(
            // '/api/user/75'/* + id*/,
            'user/75',
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
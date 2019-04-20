import axios from 'axios';

export default {
    login (login, password) {
        return axios.post(
            '/login_check',
            {
                username: login,
                password: password
            }
        );
    },
}
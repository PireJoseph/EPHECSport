
import ApiService from '../services/api'

export default {

    login (login, password) {
        return ApiService.post(
            '/login_check',
            {
                username: login,
                password: password
            }
        );
    },
    refreshToken(token, refreshToken) {
        return ApiService.post(
            '/api/token/refresh',
            {
                token: token,
                refresh_token: refreshToken
            }
        )
    }


}
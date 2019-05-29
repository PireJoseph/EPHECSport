// import jwt_decode from 'jwt-decode';

const TOKEN_KEY = 'access_token'
const REFRESH_TOKEN_KEY = 'refresh_token'
const REFRESH_TOKEN_EXPIRATION_KEY = 'refresh_token_expiration'


/**
 * Manage the how Access Tokens are being stored and retreived from storage.
 *
 * Current implementation stores to localStorage. Local Storage should always be
 * accessed through this instace.
 **/
const TokenService = {
    getToken() {
        return localStorage.getItem(TOKEN_KEY)
    },

    saveToken(accessToken) {
        localStorage.setItem(TOKEN_KEY, accessToken)
    },

    removeToken() {
        localStorage.removeItem(TOKEN_KEY)
    },

    getRefreshToken() {
        return localStorage.getItem(REFRESH_TOKEN_KEY)
    },

    saveRefreshToken(refreshToken) {
        localStorage.setItem(REFRESH_TOKEN_KEY, refreshToken)
    },

    removeRefreshToken() {
        localStorage.removeItem(REFRESH_TOKEN_KEY)
    },

    getRefreshTokenExpiration() {
        return localStorage.getItem(REFRESH_TOKEN_EXPIRATION_KEY)
    },

    saveRefreshTokenExpiration(refreshTokenExpiration) {
        localStorage.setItem(REFRESH_TOKEN_EXPIRATION_KEY, refreshTokenExpiration)
    },

    removeRefreshTokenExpiration() {
        localStorage.removeItem(REFRESH_TOKEN_EXPIRATION_KEY)
    },

    tokenArePresent () {
        return (!!this.getToken() && !!this.getRefreshToken() && !!this.getRefreshTokenExpiration());
    },

    refreshTokenIsStillValid() {
        if(this.tokenArePresent) {
            let nowDate = new Date;
            let RefreshTokenExpirationDate = new Date(this.getRefreshTokenExpiration());
            return (RefreshTokenExpirationDate > nowDate);
        }
        return false
    },

};

export default TokenService
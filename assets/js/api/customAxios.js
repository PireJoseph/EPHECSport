import axios from 'axios'

import  store  from '../store'

// const API_URL = '/api/'

let customAxiosInstance = axios.create({
    // baseURL: API_URL,
    headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + localStorage.getItem('token')
    }
});

customAxiosInstance.interceptors.response.use(

    (response) => {
        console.log('interceptor success');
        return response
    },
    async (error) => {
        console.log('interceptor error');
        const originalRequest = error.config;

        if (error.code !== "ECONNABORTED" && error.response.status === 401) {
            if (error.config.url.includes('api/token/refresh')) {

                // Refresh token has failed. Logout the user
                console.log('Refresh token has failed');
                store.commit('security/LOGOUT');
                throw error
            } else {

                // Refresh the access token
                try{
                    let token = localStorage.getItem('token');
                    let refresh_token = localStorage.getItem('refresh_token');
                    let refreshTokenPayload = {
                        'token' : token,
                        'refresh_token' : refresh_token
                    };
                    return store
                        .dispatch('security/refreshToken', refreshTokenPayload)
                        .then(function(){
                                console.log('relaunch initial request');
                                console.log(JSON.stringify(originalRequest));
                                return customAxiosInstance(originalRequest);
                             }
                        );

                } catch (e) {
                    // Refresh has failed - reject the original request
                    throw error
                }
            }
        }
        // If error was not 401 just reject as is
        throw error
    }

    // (response) => {
    //     console.log("customAxiosInstance success");
    //     return response;
    // },
    // async (error) => {
    //     const originalRequest = error.config;
    //
    //     console.log("customAxiosInstance error");
    //
    //     if (error.code !== "ECONNABORTED" && error.response.status === 401) {
    //         if (!originalRequest._retry) {
    //             originalRequest._retry = true;
    //             return customAxiosInstance
    //                 .post("/tokens/auth", {
    //                     refreshToken: getRefreshToken(),
    //                     grantType: "refresh_token",
    //                     clientId : "website"
    //                 })
    //                 .then(response => {
    //                     localStorage.authentication = JSON.stringify(response.data);
    //                     updateAuthInstant();
    //                     return axiosInstance(originalRequest);
    //                 });
    //         } else {
    //             localStorage.removeItem("authentication")
    //             console.log("fafaf")
    //             browserHistory.push({
    //                 pathname: '/login',
    //             });
    //         }
    //
    //     }
    //     return Promise.reject(error);
    // }
);




export default customAxiosInstance
import axios from 'axios'

import TokenService  from '../services/token'
import CookieService from '../services/cookie'

import store from "../store";

const ApiService = {

    // Stores the 401 response interceptor position so that it can be later ejected when needed
    _401interceptor: null,

    // Stores the  request interceptor
    _requestInterceptor: null,

    init(baseURL) {
        axios.defaults.baseURL = baseURL;
        this.mount401Interceptor();
        this.mountRequestInterceptor();
    },

    setHeader() {
        axios.defaults.headers.common["Authorization"] = `Bearer ${TokenService.getToken()}`
    },

    removeHeader() {
        axios.defaults.headers.common = {}
    },

    get(resource) {
        return axios.get(resource)
    },

    post(resource, data) {
        return axios.post(resource, data)
    },

    put(resource, data) {
        return axios.put(resource, data)
    },

    delete(resource) {
        return axios.delete(resource)
    },

    /**
     * Perform a custom Axios request.
     *
     * data is an object containing the following properties:
     *  - method
     *  - url
     *  - data ... request payload
     *  - auth (optional)
     *    - username
     *    - password
     **/
    customRequest(data) {
        return axios(data)
    },

    mount401Interceptor() {
        this._401interceptor = axios.interceptors.response.use(
            (response) => {
                return response
            },
            async (error) => {

                // check if we got 401 response from the server (typically a bad JSON web token)
                if (error.request.status == 401) {
                    if (error.config.url.includes('login_check')) {
                        // Refresh token has failed. Logout the user
                        store.commit('security/LOGOUT');
                        throw error
                    } else {
                        // Refresh the access token
                        try{
                            let refreshTokenPayload = {
                                'token' : TokenService.getToken(),
                                'refresh_token' : TokenService.getRefreshToken()
                            };
                            await store.dispatch('security/refreshToken', refreshTokenPayload);
                            // Retry the original request
                            return this.customRequest({
                                method: error.config.method,
                                url: error.config.url,
                                data: error.config.data
                            })
                        } catch (e) {
                            // Refresh has failed - reject the original request
                            throw error
                        }
                    }
                }

                // If error was not 401 just reject as is
                throw error
            }
        )
    },

    mountRequestInterceptor(){
        this._requestInterceptor = axios.interceptors.request.use(
             (config) => {

                 // If we are calling the API
                 if (config.url.includes('/api/')) {

                     // verify that the xscf token is in the cookies
                     if(!CookieService.isXSRFTokenPresentInCookie()) {

                         // get token from user app twig template
                         let xsrf_token = document.querySelector('#root').dataset.xsrfTokenBearer;

                         // reset cookie
                         CookieService.setXSFRTokenInCookie(xsrf_token);

                     }

                 }

            return config;
        },  (error) => {
            // Do something with request error
            return Promise.reject(error);
        });
    },



    unmount401Interceptor() {
        // Eject the interceptor
        axios.interceptors.response.eject(this._401interceptor)
    }
};

export default ApiService
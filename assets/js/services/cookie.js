import Cookies from 'js-cookie';

// be careful the value is used in twig template of user app, change it there if needed
const XSRF_TOKEN_COOKIE_KEY = 'XSRF-TOKEN';
const XSRF_TOKEN_HTTP_HEADER_KEY = 'X-XSRF-TOKEN';

const CookieService = {

    getXSRFTokenCookieKey(){
        return XSRF_TOKEN_COOKIE_KEY;
    },

    getXSRFTokenHTTPHeaderKey(){
        return XSRF_TOKEN_HTTP_HEADER_KEY;
    },

    getXSRFTokenFromCookie(){
        return Cookies.get(XSRF_TOKEN_COOKIE_KEY);
    },

    removeXSRFTokenFromCookie(){
        Cookies.remove(XSRF_TOKEN_COOKIE_KEY);
    },

    setXSFRTokenInCookie(token){
        Cookies.set(XSRF_TOKEN_COOKIE_KEY, token, { expires: 30 })
    },

    isXSRFTokenPresentInCookie(){
        let xsrfToken = this.getXSRFTokenFromCookie();
        return ( (!!xsrfToken) && (xsrfToken.length > 0) )
    },



};

export default CookieService;
import Vue from 'vue';
import VueRouter from 'vue-router';

import store from '../store';

import TokenService from '../services/token';

// 1. Define route components.
import Home from '../views/home';
import Activity from '../views/activity';
import Information from '../views/information';
import Promotion from '../views/promotion';
import Profile from '../views/profile';
import Login from '../views/login';
import App from '../views/app'


// 2. Define some routes
const routes = [
    {
        path: '/user/login',
        components: {
            default: Login
        }
    },
    {
        path: '/user/',
        redirect: '/user/home',
        components: {
            default: App
        },
        meta: { requiresAuth: true },
        children:[
            {
                path: '/user/home',
                components: {
                    content: Home
                },
            },
            {
                path: '/user/profile',
                components: {
                    content: Profile
                },
            },
            {
                path: '/user/activity',
                components: {
                    content: Activity
                },
            },
            {
                path: '/user/promotion',
                components: {
                    content: Promotion
                },
            },
            {
                path: '/user/information',
                components: {
                    content: Information
                },
            }
        ]
    },
    { path: '*', redirect: '/user/home' }
];

Vue.use(VueRouter);

// 3. Create the router instance and pass the `routes` option
let router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (TokenService.refreshTokenIsStillValid()) {
            next();
        } else {
            next({
                path: '/user/login',
                query: { redirect: to.fullPath }
            });
        }
    } else {
        next(); // make sure to always call next()!
    }
});

export default router;



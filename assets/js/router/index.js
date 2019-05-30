import Vue from 'vue';
import VueRouter from 'vue-router';

// token service
import TokenService from '../services/token';

// cookie service
import CookieService from '../services/cookie'

// 1. Define route components.
import Home from '../views/home';
import Activity from '../views/activity';
import Information from '../views/information';
import Promotion from '../views/promotion';
import Profile from '../views/profile';
import Login from '../views/login';
import App from '../views/app'


// profile
import MyProfile from '../views/profile/myProfile';
import MySportProfiles from '../views/profile/mySportProfiles';
import OtherMembers from '../views/profile/otherMembers';

// activity
import ActivityHistory from '../views/activity/activityHistory';
import ActivityInvitation from '../views/activity/activityInvitations';
import ActivityParticipations from '../views/activity/activityParticipations';
import AvailableActivities from '../views/activity/availableActivities';

// promotion
import CrucialMeetings from '../views/promotion/crucialMeetings';
import EmeritusSportmen from '../views/promotion/emeritusSportmen';
import OfficialTeams from '../views/promotion/officialTeams';

// information
import ExternalLinks from '../views/information/externalLinks';
import HealthProfessionals from '../views/information/healthProfessionals';


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

            //
            // HOME
            //

            {
                path: '/user/home',
                components: {
                    content: Home
                },
            },

            //
            // PROFILE
            //

            {
                path: '/user/profile',
                components: {
                    content: Profile
                },
                redirect: '/user/profile/mine',
                children: [
                    {
                        path: '/user/profile/mine',
                        components : {
                            profileContent: MyProfile
                        }
                    },
                    {
                        path: '/user/profile/sport',
                        components : {
                            profileContent: MySportProfiles
                        }
                    },
                    {
                        path: '/user/profile/others',
                        components : {
                            profileContent: OtherMembers
                        }
                    },

                ],
            },

            //
            // ACTIVITY
            //

            {
                path: '/user/activity',
                components: {
                    content: Activity
                },
                redirect: '/user/activity/history',
                children: [
                    {
                        path: '/user/activity/history',
                        components : {
                            activityContent: ActivityHistory
                        }
                    },
                    {
                        path: '/user/activity/available',
                        components : {
                            activityContent: AvailableActivities
                        }
                    },
                    {
                        path: '/user/activity/invitations',
                        components : {
                            activityContent: ActivityInvitation
                        }
                    },
                    {
                        path: '/user/activity/participations',
                        components : {
                            activityContent: ActivityParticipations
                        }
                    },
                ],
            },

            //
            // PROMOTION
            //

            {
                path: '/user/promotion',
                components: {
                    content: Promotion
                },
                redirect: '/user/promotion/meetings',
                children: [
                    {
                        path: '/user/promotion/meetings',
                        components : {
                            promotionContent: CrucialMeetings
                        }
                    },
                    {
                        path: '/user/promotion/teams',
                        components : {
                            promotionContent: OfficialTeams
                        }
                    },
                    {
                        path: '/user/promotion/sportmen',
                        components : {
                            promotionContent: EmeritusSportmen
                        }
                    },
                ],
            },

            //
            // INFORMATION
            //

            {
                path: '/user/information',
                components: {
                    content: Information
                },
                redirect: '/user/information/links',
                children: [
                    {
                        path: '/user/information/links',
                        components : {
                            informationContent: ExternalLinks
                        }
                    },
                    {
                        path: '/user/information/pros',
                        components : {
                            informationContent: HealthProfessionals
                        }
                    },
                ],
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

    //logout and deny access to app while cookies are not allowed by client



    // get app root container
    // let rootAppContainer = document.querySelector('#root');
    // // check if the xsfToken is present in the the right data attribute of the app container
    // if(!rootAppContainer.dataset.xsrfTokenBearer) {
    //     console.log('token not present in DOM');
    //     // assign xsfr token as a data
    //     rootAppContainer.dataset.xsrfTokenBearer = CookieService.getXSRFTokenFromCookie();
    // }


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



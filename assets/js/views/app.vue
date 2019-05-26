<style scoped>

    #appContainer {
        background-color: gainsboro;
    }

    #loadingScreen{
        display: flex;
        flex-direction: row;
        flex-grow: 1;
        align-items: center;
        justify-content: center;
        font-size: 100px;
        color: lightslategray;
    }

    #appContainer {
        display: flex;
        flex-flow: column;
        flex-grow: 1;
    }

    #app {
        display: flex;
        flex-flow: column;
        flex-grow: 1;
        justify-content: space-between;
    }


    #footerContainer{
        font-size: small;
        display: flex;
        flex-direction: column;
    }
    #footerContainer h6, #footerContainer p {
        margin: 5px;
    }

    @media only screen and (max-width: 600px) {
        #contentContainer {
            display: flex;
            justify-content: space-between;
            flex-grow: 1;
        }

        #leftColumn {
            display:none;
        }
        #centerColumn {
            width: 100%;
            display: flex;
            flex-direction: column;
        }
        #rightColumn {
            display: none;
        }

    }

    @media only screen and (min-width: 601px) and (max-width: 1199px) {

        #contentContainer {
            margin: 12px;
            display: flex;
            justify-content: space-between;
            flex-grow: 1;
        }

        #leftColumn {
           display:none;
        }
        #centerColumn {
            width: 100%;
            display: flex;
            flex-direction: column;
        }
        #rightColumn {
            display: none;
        }
    }

    @media only screen and (min-width: 1200px) and (max-width: 1499px) {

        #contentContainer {
            margin: 12px 16px;
            display: flex;
            justify-content: space-between;
            flex-grow: 1;
        }

        #leftColumn {
            width: 20%
        }
        #centerColumn {
            padding: 0 32px;
            display: flex;
            flex-direction: column;
            width: 80%;
        }
        #rightColumn {
            display: none;
        }
    }

    @media only screen and (min-width: 1500px) {

        #contentContainer {
            margin: 12px 16px;
            display: flex;
            justify-content: space-between;
            flex-grow: 1;
        }

        #leftColumn {
            width: 15%
        }
        #centerColumn {
            padding: 0 32px;
            display: flex;
            flex-direction: column;
            width: 73%;
        }
        #rightColumn {
            width: 12%;
        }
    }

</style>

<template>

        <div id="appContainer">

            <!-- Loading screen -->
            <div id="loadingScreen"  v-show="!baseDataLoaded">
                <i class="fas fa-spinner fa-spin"></i>
            </div>

            <div id="app" v-show="baseDataLoaded">

                <!-- Navbar -->
                <Navbar></Navbar>

                <!-- content Container -->
                <div id="contentContainer"  >

                    <!-- Left Column -->
                    <aside id="leftColumn" class="w3-hide-small w3-hide-medium">

                        <user-tile></user-tile>

                        <br />

                        <side-bar-accordion></side-bar-accordion>

                        <br />

                        <side-bar-success-widget></side-bar-success-widget>

                        <br v-show="!!userSuccessArray.length"/>

                        <side-bar-user-feedback-widget></side-bar-user-feedback-widget>

                    </aside>

                    <!-- Middle Column -->
                    <main id="centerColumn" class="w3-center">

                        <router-view name="content"></router-view>

                        <!-- End Middle Column -->
                    </main>

                    <!-- Right Column -->
                    <aside id="rightColumn" class="w3-hide-small w3-hide-medium">

                        <side-bar-next-activity-participation-widget></side-bar-next-activity-participation-widget>

                        <br v-show="(!! nextActivityParticipation && !!nextCrucialMeeting)">

                        <side-bar-next-crucial-meeting-widget></side-bar-next-crucial-meeting-widget>

                    </aside>

                </div>

                <!--Footer-->
                <footer id="footerContainer">

                    <div class="w3-theme-d3 w3-hide-small" >
                        <h6><img src="/images/favicon.png" style="width: 18px; height: 18px;"> EPHEC Sport </h6>
                    </div>

                    <div class="w3-theme-d5 w3-hide-small w3-hide-medium w3-tiny" >
                        <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
                    </div>

                    <!-- End Footer -->
                </footer>

            </div>

        </div>

</template>



<script>
    import { mapGetters } from 'vuex'
    import { mapMutations } from 'vuex'

    import jwt_decode from 'jwt-decode';

    import TokenService from '../services/token'

    import Navbar from '../components/common/navbar'
    import sideBarAccordion from '../components/common/sideBarAccordion';
    import UserTile from '../components/common/userTile';
    import SideBarSuccessWidget from '../components/common/sideBarSuccessWidget'
    import SideBarUserFeedbackWidget from '../components/common/sideBarUserFeedbackWidget'
    import SideBarNextActivityParticipationWidget from '../components/common/sideBarNextActivityParticipationWidget'
    import SideBarNextCrucialMeetingWidget from '../components/common/sideBarNextCrucialMeetingWidget'

    export default {
        name: 'app',
        components : {SideBarSuccessWidget, UserTile, Navbar, sideBarAccordion, SideBarUserFeedbackWidget, SideBarNextActivityParticipationWidget, SideBarNextCrucialMeetingWidget},
        computed: {
            ...mapGetters({
                mobileMenuShowed: 'navbar/isMobileMenuShowed',
                nextActivityParticipation: 'user/nextActivityParticipation',
                nextCrucialMeeting: 'user/nextCrucialMeeting',
                baseDataLoaded: 'common/baseDataLoaded',
                userSuccessArray: 'user/userSuccess'
                // currentUserId: 'user/currentUserId'
            })
        },
        methods: {
            initApp() {
                let accessToken = TokenService.getToken();
                let decodedToken = jwt_decode(accessToken);
                let userId = decodedToken.userId;
                this.$store.commit('user/SET_USER_ID', userId);
                this.loadData()
            },
            loadData () {
                let payload = {
                    userId: this.$store.getters['user/userId'],
                };
                this.$store.dispatch('common/loadBaseData', payload)
            },

            ...mapMutations({
                toggleNavMenu: 'navbar/TOGGLE_MOBILE_MENU',
                closeNavMenu: 'navbar/CLOSE_MOBILE_MENU'
            })
        },
        mounted: function() {
            this.initApp()
        }

        
    }
</script>
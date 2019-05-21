<style scoped>
    #appContainer {
        background-color: gainsboro;
    }

    #contentContainer {
        margin-top: 0;
    }

    @media only screen and (min-width: 993px) {
        #centerColumn {
            padding: 0 32px;
            /*margin-top: 16px;*/
        }
    }

    @media only screen and (min-width: 1200px) {

        #contentContainer {
            margin: 16px 32px 0 32px;
        }
    }

</style>

<template>

        <div id="appContainer">

            <!-- Navbar -->
            <Navbar></Navbar>

            <div id="loadingPage" class="w3-center" v-show="!baseDataLoaded" >
                <h1>Chargement ...</h1>
            </div>

            <!-- Page Container -->
            <div id="contentContainer" v-show="baseDataLoaded" class="w3-row" >


                <!-- Left Column -->
                <div class="w3-col w3-hide-small w3-hide-medium l2">

                    <!-- Profile -->
                    <user-tile></user-tile>

                    <br>

                    <side-bar-accordion></side-bar-accordion>

                    <br>

                    <side-bar-success-widget></side-bar-success-widget>

                    <br>

                    <side-bar-user-feedback-widget></side-bar-user-feedback-widget>

                    <!-- End Left Column -->
                </div>

                <!-- Middle Column -->
                <div id="centerColumn" class="w3-col m12 l8">

                    <div class="w3-center">


                        <router-view name="content"></router-view>


                    </div>

                    <!-- End Middle Column -->

                </div>


                <!-- Right Column -->
                <div class="w3-col w3-hide-small w3-hide-medium l2 ">

                    <!-- Next activity participation widget -->
                    <side-bar-next-activity-participation-widget></side-bar-next-activity-participation-widget>

                    <br  v-if="nextActivityParticipation" />

                    <side-bar-next-crucial-meeting-widget></side-bar-next-crucial-meeting-widget>

                    <!--<div class="w3-card w3-round w3-white w3-center">-->
                    <!--<div class="w3-container">-->
                    <!--<p>Friend Request</p>-->
                    <!--<img src="/w3images/avatar6.png" alt="Avatar" style="width:50%"><br>-->
                    <!--<span>Jane Doe</span>-->
                    <!--<div class="w3-row w3-opacity">-->
                    <!--<div class="w3-half">-->
                    <!--<button class="w3-button w3-block w3-green w3-section" title="Accept"><i class="fa fa-check"></i></button>-->
                    <!--</div>-->
                    <!--<div class="w3-half">-->
                    <!--<button class="w3-button w3-block w3-red w3-section" title="Decline"><i class="fa fa-remove"></i></button>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!---->

                    <br v-if="nextCrucialMeeting" />

                    <!--<div class="w3-card w3-round w3-white w3-padding-16 w3-center">-->
                    <!--<p>ADS</p>-->
                    <!--</div>-->
                    <!--<br>-->

                    <!--<div class="w3-card w3-round w3-white w3-padding-32 w3-center">-->
                    <!--<p><i class="fa fa-bug w3-xxlarge"></i></p>-->
                    <!--</div>-->

                    <!-- End Right Column -->
                </div>


                <!-- End Page Container -->
            </div>

            <br>

            <div id="footerContainer">
                <!-- Footer -->
                <footer class="w3-container w3-theme-d3 w3-padding-16">
                    <h5><img src="/images/favicon.png" style="width: 18px; height: 18px;"> EPHEC Sport </h5>
                </footer>

                <footer class="w3-container w3-theme-d5">
                    <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
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
                baseDataLoaded: 'common/baseDataLoaded'
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
                console.log(payload);
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
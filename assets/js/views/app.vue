<template>

    <div id="appContainer">

        <!-- Navbar -->
        <Navbar></Navbar>


        <!-- Page Container -->
        <div id="contentContainer" class="w3-container w3-row" >


            <!-- Left Column -->
            <div class="w3-col m3 l2">
                <!-- Profile -->
                <user-tile></user-tile>

                <br>

                <side-bar-accordion></side-bar-accordion>

                <br>

                <!-- Interests -->
                <div class="w3-card w3-round w3-white w3-hide-small">
                    <div class="w3-container">
                        <p>Interests</p>
                        <p>
                            <span class="w3-tag w3-small w3-theme-d5">News</span>
                            <span class="w3-tag w3-small w3-theme-d4">W3Schools</span>
                            <span class="w3-tag w3-small w3-theme-d3">Labels</span>
                            <span class="w3-tag w3-small w3-theme-d2">Games</span>
                            <span class="w3-tag w3-small w3-theme-d1">Friends</span>
                            <span class="w3-tag w3-small w3-theme">Games</span>
                            <span class="w3-tag w3-small w3-theme-l1">Friends</span>
                            <span class="w3-tag w3-small w3-theme-l2">Food</span>
                            <span class="w3-tag w3-small w3-theme-l3">Design</span>
                            <span class="w3-tag w3-small w3-theme-l4">Art</span>
                            <span class="w3-tag w3-small w3-theme-l5">Photos</span>
                        </p>
                    </div>
                </div>
                <br>

                <!-- Alert Box -->
                <div class="w3-container w3-display-container w3-round w3-theme-l4 w3-border w3-theme-border w3-margin-bottom w3-hide-small">
        <span onclick="this.parentElement.style.display='none'" class="w3-button w3-theme-l3 w3-display-topright">
          <i class="fa fa-remove"></i>
        </span>
                    <p><strong>Hey!</strong></p>
                    <p>People are looking at your profile. Find out who.</p>
                </div>

                <!-- End Left Column -->
            </div>


            <!-- Middle Column -->
            <div class="w3-col m7 l8 w3-padding w3-container">

                <router-view name="content"></router-view>

            <!-- End Middle Column -->

            </div>


            <!-- Right Column -->
            <div class="w3-col m2 l2">
                <div class="w3-card w3-round w3-white w3-center">
                    <div class="w3-container">
                        <p>Upcoming Events:</p>
                        <img src="/w3images/forest.jpg" alt="Forest" style="width:100%;">
                        <p><strong>Holiday</strong></p>
                        <p>Friday 15:00</p>
                        <p><button class="w3-button w3-block w3-theme-l4">Info</button></p>
                    </div>
                </div>
                <br>

                <div class="w3-card w3-round w3-white w3-center">
                    <div class="w3-container">
                        <p>Friend Request</p>
                        <img src="/w3images/avatar6.png" alt="Avatar" style="width:50%"><br>
                        <span>Jane Doe</span>
                        <div class="w3-row w3-opacity">
                            <div class="w3-half">
                                <button class="w3-button w3-block w3-green w3-section" title="Accept"><i class="fa fa-check"></i></button>
                            </div>
                            <div class="w3-half">
                                <button class="w3-button w3-block w3-red w3-section" title="Decline"><i class="fa fa-remove"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <div class="w3-card w3-round w3-white w3-padding-16 w3-center">
                    <p>ADS</p>
                </div>
                <br>

                <div class="w3-card w3-round w3-white w3-padding-32 w3-center">
                    <p><i class="fa fa-bug w3-xxlarge"></i></p>
                </div>

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

    import Navbar from '../components/navbar'
    import sideBarAccordion from '../components/sideBarAccordion';
    import UserTile from '../components/userTile';

    export default {
        name: 'app',
        components : {UserTile, Navbar, sideBarAccordion},
        computed: {
            // mobileMenuShowed ()
            // {
            //     return this.$store.getters['mobileMenu/isMobileMenuShowed']
            // }
            ...mapGetters({
                mobileMenuShowed: 'mobileMenu/isMobileMenuShowed',
                // currentUserId: 'user/currentUserId'
            })
        },
        methods: {
            // toggleNavMenu() {
            //     this.$store.commit('mobileMenu/TOGGLE_MOBILE_MENU')
            // },
            // closeNavMenu() {
            //     this.$store.commit('mobileMenu/CLOSE_MOBILE_MENU')
            // },
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
                    // .then(() => {
                    //     if (!this.$store.getters['appCommon/hasError']) {
                    //         if (typeof redirect !== 'undefined') {
                    //             this.$router.push({path: redirect});
                    //         } else {
                    //             this.$router.push({path: '/user/home'});
                    //         }
                    //     }
                    // })

                // let redirect = this.$route.query.redirect;
                // this.$store.dispatch('security/login', payload)
                //     .then(() => {
                //         if (!this.$store.getters['security/hasError']) {
                //             if (typeof redirect !== 'undefined') {
                //                 this.$router.push({path: redirect});
                //             } else {
                //                 this.$router.push({path: '/user/home'});
                //             }
                //         }
                //     })
                // .then(() => {
                //     this.$store.dispatch('user/fetchCurrentUser')
                // })
            },

            ...mapMutations({
                toggleNavMenu: 'mobileMenu/TOGGLE_MOBILE_MENU',
                closeNavMenu: 'mobileMenu/CLOSE_MOBILE_MENU'
            })
        },
        mounted: function() {
            this.initApp()
        }

        
    }
</script>
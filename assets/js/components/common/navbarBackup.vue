<style scoped>

    /*
    /* TOPNAV BIGSCREEN
    */


    /*
    /* TOPNAV MOBILE
    */


    /* Add a black background color to the top navigation */
    .topnav {
        background-color: #333;
        overflow: hidden;
    }

    /* Style the links inside the navigation bar */
    .topnav a {
        float: left;
        display: block;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
    }

    /*    !* Add an active class to highlight the current page *!
        .active {
            background-color: #4CAF50;
            color: white;
        }*/

    /* Hide the link that should open and close the topnav on small screens */
    .topnav .icon {
        display: none;
    }

    /* Dropdown container - needed to position the dropdown content */
    .dropdown {
        float: left;
        overflow: hidden;
    }

    /* Style the dropdown button to fit inside the topnav */
    .dropdown .dropbtn {
        font-size: 17px;
        border: none;
        outline: none;
        color: white;
        padding: 14px 16px;
        background-color: inherit;
        font-family: inherit;
        margin: 0;
    }

    /* Style the dropdown content (hidden by default) */
    .dropdown-content {
        /*display: none;*/
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    /* Style the links inside the dropdown */
    .dropdown-content a {
        float: none;
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }

    /* Add a dark background on topnav links and the dropdown button on hover */
    .topnav a:hover, .dropdown:hover .dropbtn {
        background-color: #555;
        color: white;
    }

    /* Add a grey background to dropdown links on hover */
    .dropdown-content a:hover {
        background-color: #ddd;
        color: black;
    }

    /* Show the dropdown menu when the user moves the mouse over the dropdown button */
    .dropdown:hover .dropdown-content {
        display: block;
    }

    /* The "responsive" class is added to the topnav with JavaScript when the user clicks on the icon. This class makes the topnav look good on small screens (display the links vertically instead of horizontally) */
    @media screen and (max-width: 600px) {
        .topnav a:not(:first-child), .dropdown .dropbtn {
            display: none;
        }
        .topnav a.icon {
            float: right;
            display: block;
        }
        .topnav.responsive {
            position: relative;
        }
        .topnav.responsive a.icon {
            position: absolute;
            right: 0;
            top: 0;
        }
        .topnav.responsive a {
            float: none;
            display: block;
            text-align: left;
        }
        .topnav.responsive .dropdown {
            float: none;
        }
        .topnav.responsive .dropdown-content {
            position: relative;
        }
        .topnav.responsive .dropdown .dropbtn {
            display: block;
            width: 100%;
            text-align: left;
        }
    }

</style>

<template>
    <div id="navbarContainer">

        <!-- Navbar -->
        <div  id="myTopnav" class="w3-bar w3-theme-d2 w3-left-align w3-large topnav"  v-bind:class="{ responsive: mobileMenuShowed }" @mouseleave="closeNavMenu">
            <router-link to="/user/home" class="w3-bar-item w3-button w3-padding-large w3-theme-d4" ><span  @click="closeNavMenu"><i class="fa fa-home w3-margin-right" ></i>Home</span></router-link>
            <div class="dropdown" @mouseleave="deactivateDropdown" >
                <button class="dropbtn" @mouseenter="activateDropdown('profile')" ><i class="fa fa-user"></i> Profil <i class="fa fa-caret-down"></i></button>
                <div class="dropdown-content" v-show="isProfileDropDownActive" @click="clickDropdownItem">
                    <router-link to="/user/profile/mine" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Mon profil</router-link>
                    <router-link to="/user/profile/sport" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Profils sportifs</router-link>
                    <router-link to="/user/profile/others" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Autres membres</router-link>
                </div>
            </div>
            <div class="dropdown" @mouseleave="deactivateDropdown">
                <button class="dropbtn" @mouseenter="activateDropdown('activity')" ><i class="fa fa-bolt"></i> Activités <i class="fa fa-caret-down"></i></button>
                <div class="dropdown-content" v-show="isActivityDropDownActive">
                    <router-link to="/user/activity/history" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Historique</router-link>
                    <router-link to="/user/activity/available" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Disponibles</router-link>
                    <router-link to="/user/activity/invitations" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Invitations</router-link>
                    <router-link to="/user/activity/participations" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Participations</router-link>
                </div>
            </div>
            <div class="dropdown" @mouseleave="deactivateDropdown">
                <button class="dropbtn" @mouseenter="activateDropdown('promotion')" ><i class="fa fa-star"></i> Promotion <i class="fa fa-caret-down"></i></button>
                <div class="dropdown-content" v-show="isPromotionDropDownActive" @click="clickDropdownItem">
                    <router-link to="/user/promotion/meetings" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Rencontres importantes</router-link>
                    <router-link to="/user/promotion/teams" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Equipes officielles</router-link>
                    <router-link to="/user/promotion/sportmen" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Sportif émérite</router-link>
                </div>
            </div>
            <div class="dropdown"  @mouseleave="deactivateDropdown">
                <button class="dropbtn" @mouseenter="activateDropdown('information')" ><i class="fa fa-search"></i> Information <i class="fa fa-caret-down"></i></button>
                <div class="dropdown-content" v-show="isInformationDropDownActive" @click="clickDropdownItem">
                    <router-link to="/user/information/links" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Lien externe</router-link>
                    <router-link to="/user/information/pros" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Professionnel de la santé</router-link>
                </div>
            </div>
            <!--<router-link to="/user/profile" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Profile" ><i class="fa fa-user"></i></router-link>-->
            <!--<router-link to="/user/activity" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Activités" ><i class="fa fa-bolt"></i></router-link>-->
            <!--<router-link to="/user/promotion" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Promotion" ><i class="fa fa-star"></i></router-link>-->
            <!--<router-link to="/user/information" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Information" ><i class="fa fa-search"></i></router-link>-->
            <!--<a href="#" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white" @click="testFetchUser" >call api</a>-->
            <!--<a href="#" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white" @click="testRefreshToken" >refresh token</a>-->
            <a href="#" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white" @click="logout" title="Se déconnecter"><i class="fa fa-user-times w3-margin-right"></i>Se déconnecter</a>
            <a id='mobileMenuBtn' class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-theme-d2 icon" href="javascript:void(0);" @click="toggleNavMenu" ><i class="fa fa-bars"></i></a>
        </div>

        <!--&lt;!&ndash; Navbar on small screens &ndash;&gt;-->
        <!--<div id="navDemo" v-show="mobileMenuShowed" @click="toggleNavMenu" class="w3-bar-block w3-theme-d2 w3-hide-large w3-hide-medium w3-large">-->
        <!--<router-link to="/user/profile" class="w3-bar-item w3-button w3-padding-large" >Profile</router-link>-->
        <!--<router-link to="/user/activity" class="w3-bar-item w3-button w3-padding-large" >Activités</router-link>-->
        <!--<router-link to="/user/promotion" class="w3-bar-item w3-button w3-padding-large" >Promotion</router-link>-->
        <!--<router-link to="/user/information" class="w3-bar-item w3-button w3-padding-large"  >Information</router-link>-->
        <!--</div>-->
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import { mapMutations } from 'vuex'
    import TokenService from '../../services/token'

    export default {
        name: 'navbar',
        computed: {
            ...mapGetters({
                // isAuthenticated:  'security/isAuthenticated',
                mobileMenuShowed: 'mobileMenu/isMobileMenuShowed',
                isProfileDropDownActive: 'mobileMenu/isProfileDropDownActive',
                isActivityDropDownActive: 'mobileMenu/isActivityDropDownActive',
                isPromotionDropDownActive: 'mobileMenu/isPromotionDropDownActive',
                isInformationDropDownActive: 'mobileMenu/isInformationDropDownActive',
            })
        },
        methods: {
            logout() {
                this.$store.commit('security/LOGOUT');
                this.$router.push({path: '/user/login'});
            },
            // testFetchUser(){
            //     this.$store.dispatch('user/fetchCurrentUser')
            // },
            // testRefreshToken(){
            //     let token = localStorage.getItem('token');
            //     let refresh_token = localStorage.getItem('refresh_token');
            //     let refreshTokenPayload = {
            //         'token' : token,
            //         'refresh_token' : refresh_token
            //     };
            //     this.$store.dispatch('security/refreshToken', refreshTokenPayload)
            // },
            clickDropdownItem(event) {
                console.log(event.target);
                this.$store.commit('mobileMenu/DEACTIVATE_ALL_MENU_DROPDOWN');
                this.$store.commit('mobileMenu/CLOSE_MOBILE_MENU');
            },
            activateDropdown(dropdownId) {
                console.log('active dropdown');
                this.$store.commit('mobileMenu/ACTIVE_MENU_DROPDOWN', dropdownId)
            },
            deactivateDropdown(){
                console.log('deactive dropdown');
                this.$store.commit('mobileMenu/DEACTIVATE_ALL_MENU_DROPDOWN');
            },
            ...mapMutations({
                toggleNavMenu: 'mobileMenu/TOGGLE_MOBILE_MENU',
                closeNavMenu: 'mobileMenu/CLOSE_MOBILE_MENU',
                deactivateAllDropdown: 'mobileMenu/DEACTIVATE_ALL_MENU_DROPDOWN'
            })
        }
    }

</script>
<style scoped>

    @media only screen and (max-width: 600px){
        #navbarContainer{
            margin-bottom: 50px;
        }
    }
    #mobileNavBar {
        position: fixed;
        width: 100%;
        z-index: 9999;
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

     .dropdown-content a.router-link-active{
        color: #ee7102!important;
    }

    .dropdown .dropbtn.moduleactive i:nth-child(2), .dropdown .dropbtn.moduleactive svg:nth-child(2), button.w3-bar-item.moduleactive i, button.w3-bar-item.moduleactive svg{
        color: #ee7102!important;
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
        background-color: #4d636f;
        font-family: inherit;
        margin: 0;
    }

    /* Style the dropdown content (hidden by default) */
    .dropdown-content {
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
        background-color: rgb(58, 75, 83)!important;
        color: white;
    }

    div.dropdown button.dropbtn:hover,  a.w3-button:hover{
        /*background-color: rgb(58, 75, 83)!important;*/
        /*color: white!important;*/
        color: black!important;
        background-color: rgb(204, 204, 204)!important;
    }
    div.dropdown button.dropbtn {
        cursor: pointer;
    }


    /* Add a grey background to dropdown links on hover */
    .dropdown-content a {
        background-color: rgb(58, 75, 83)!important;
        color: white!important;
    }

    .dropdown-content a:hover {
        color: black!important;
        background-color: rgb(204, 204, 204)!important;
        /*color: #ee7102!important;*/
    }

    /* Show the dropdown menu when the user moves the mouse over the dropdown button */
    .dropdown:hover .dropdown-content {
        display: block;
    }


</style>

    <template>
    <div id="navbarContainer">

        <!-- Navbar -->
        <div class="w3-bar w3-theme-d2 w3-left-align w3-card w3-large w3-hide-small ">

            <router-link to="/user/home" class="w3-bar-item w3-button w3-padding-large w3-theme-d4" ><span  @click="closeNavMenu"><i class="fa fa-home w3-margin-right" ></i>Home</span></router-link>

            <div @mouseleave="deactivateAllDropdown">
                <div class="dropdown" >
                    <button v-bind:class="{ moduleactive: moduleProfileActive }" class="dropbtn" @mouseenter="activeDropdown('profile')" ><i class="fa fa-user"></i> <i  v-bind:class="{ 'fa-rotate-90': isProfileDropDownActive }" class="fa fa-caret-right"></i></button>
                    <div class="dropdown-content w3-theme-d4" v-show="isProfileDropDownActive" @click="clickDropdownItem">
                        <router-link to="/user/profile/mine" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Mon profil</router-link>
                        <router-link to="/user/profile/sport" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Profils sportifs</router-link>
                        <router-link to="/user/profile/others" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Autres membres</router-link>
                    </div>
                </div>

                <div class="dropdown" >
                    <button v-bind:class="{ moduleactive: moduleActivityActive }" class="dropbtn" @mouseenter="activeDropdown('activity')" ><i class="fa fa-bolt"></i> <i v-bind:class="{ 'fa-rotate-90': isActivityDropDownActive }" class="fa fa-caret-right"></i></button>
                    <div class="dropdown-content w3-theme-d4" v-show="isActivityDropDownActive" @click="clickDropdownItem">
                        <router-link to="/user/activity/history" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Historique</router-link>
                        <router-link to="/user/activity/available" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Disponibles</router-link>
                        <router-link to="/user/activity/invitations" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Invitations</router-link>
                        <router-link to="/user/activity/participations" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Participations</router-link>
                    </div>
                </div>

                <div class="dropdown" >
                    <button v-bind:class="{ moduleactive: modulePromotionActive }" class="dropbtn" @mouseenter="activeDropdown('promotion')" ><i class="fa fa-star"></i> <i v-bind:class="{ 'fa-rotate-90': isPromotionDropDownActive }" class="fa fa-caret-right"></i></button>
                    <div class="dropdown-content w3-theme-d4" v-show="isPromotionDropDownActive" @click="clickDropdownItem">
                        <router-link to="/user/promotion/meetings" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Rencontres importantes</router-link>
                        <router-link to="/user/promotion/teams" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Equipes officielles</router-link>
                        <router-link to="/user/promotion/sportmen" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Sportifs émérites</router-link>
                    </div>
                </div>

                <div class="dropdown" >
                    <button v-bind:class="{ moduleactive: moduleInformationActive }" class="dropbtn" @mouseenter="activeDropdown('information')" ><i class="fa fa-search"></i> <i v-bind:class="{ 'fa-rotate-90': isInformationDropDownActive }" class="fa fa-caret-right"></i></button>
                    <div class="dropdown-content w3-theme-d4" v-show="isInformationDropDownActive" @click="clickDropdownItem">
                        <router-link to="/user/information/links" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Liens externes</router-link>
                        <router-link to="/user/information/pros" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Professionnels de la santé</router-link>
                    </div>
                </div>
            </div>

            <a href="#" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white" @click="logout"><i class="fa fa-user-times w3-margin-right"></i>Se déconnecter</a>

        </div>




        <!-- Navbar on small screens -->
        <div id="mobileNavBar" class="3-bar w3-card w3-theme-d3 w3-left-align w3-large w3-hide-large w3-hide-medium">
            <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-large w3-theme-d2" href="javascript:void(0);" @click="toggleNavMenu" ><i class="fa fa-bars"></i></a>
            <router-link to="/user/home" class="w3-bar-item w3-button w3-padding-large w3-theme-d4" ><span  @click="closeNavMenu"><i class="fa fa-home w3-margin-right" ></i>Home</span></router-link>
            <div  v-show="mobileMenuShowed" class="w3-bar-block w3-theme-d2 w3-large">

                <button v-bind:class="{ moduleactive: moduleProfileActive }" class="w3-bar-item w3-button w3-padding-large" @click="activeMenuAccordion('profile')" > Profil <i  v-bind:class="{ 'fa-rotate-90': isProfileAccordionActive }" class="fa fa-caret-right"></i></button>
                <div  v-show="isProfileAccordionActive" class="w3-theme-d4" @click="closeNavMenu">
                    <router-link to="/user/profile/mine" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Mon profil</router-link>
                    <router-link to="/user/profile/sport" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Profils sportifs</router-link>
                    <router-link to="/user/profile/others" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Autres membres</router-link>
                </div>

                <button v-bind:class="{ moduleactive: moduleActivityActive }" class="w3-bar-item w3-button w3-padding-large" @click="activeMenuAccordion('activity')" > Activités <i  v-bind:class="{ 'fa-rotate-90': isActivityAccordionActive }" class="fa fa-caret-right"></i></button>
                <div v-show="isActivityAccordionActive" class="w3-theme-d4" @click="closeNavMenu">
                    <router-link to="/user/activity/history" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Historique</router-link>
                    <router-link to="/user/activity/available" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Disponibles</router-link>
                    <router-link to="/user/activity/invitations" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Invitations</router-link>
                    <router-link to="/user/activity/participations" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Participations</router-link>
                </div>

                <button v-bind:class="{ moduleactive: modulePromotionActive }" class="w3-bar-item w3-button w3-padding-large" @click="activeMenuAccordion('promotion')" > Promotion <i  v-bind:class="{ 'fa-rotate-90': isPromotionAccordionActive }" class="fa fa-caret-right"></i></button>
                <div v-show="isPromotionAccordionActive" class="w3-theme-d4" @click="closeNavMenu">
                    <router-link to="/user/promotion/meetings" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Rencontres importantes</router-link>
                    <router-link to="/user/promotion/teams" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Equipes officielles</router-link>
                    <router-link to="/user/promotion/sportmen" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Sportifs émérites</router-link>
                </div>

                <button v-bind:class="{ moduleactive: moduleInformationActive }" class="w3-bar-item w3-button w3-padding-large" @click="activeMenuAccordion('information')" > Information <i  v-bind:class="{ 'fa-rotate-90': isInformationAccordionActive }" class="fa fa-caret-right"></i></button>
                <div v-show="isInformationAccordionActive" class="w3-theme-d4" @click="closeNavMenu">
                    <router-link to="/user/information/links" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Lien externe</router-link>
                    <router-link to="/user/information/pros" class="w3-bar-item w3-button w3-padding-large w3-hover-white" >Professionnel de la santé</router-link>
                </div>

                <a href="#" class="w3-bar-item w3-button w3-padding-large" @click="logout" >Se déconnecter</a>
                <a href="#" class="w3-bar-item w3-button w3-padding-large"@click="closeNavMenu" >Fermer</a>
            </div>
        </div>


    </div>

</template>

<script>
    import { mapGetters } from 'vuex'
    import { mapMutations } from 'vuex'

    export default {
        name: 'navbar',
        computed: {

            moduleProfileActive() {
                return this.$route.path.includes("profile")
            },
            moduleActivityActive() {
                return this.$route.path.includes("activity")
            },
            modulePromotionActive() {
                return this.$route.path.includes("promotion")
            },
            moduleInformationActive() {
                return this.$route.path.includes("information")
            },

            ...mapGetters({
                isProfileDropDownActive: 'navbar/isProfileDropDownActive',
                isActivityDropDownActive: 'navbar/isActivityDropDownActive',
                isPromotionDropDownActive: 'navbar/isPromotionDropDownActive',
                isInformationDropDownActive: 'navbar/isInformationDropDownActive',

                mobileMenuShowed: 'navbar/isMobileMenuShowed',

                isProfileAccordionActive: 'navbar/isProfileAccordionActive',
                isActivityAccordionActive: 'navbar/isActivityAccordionActive',
                isPromotionAccordionActive: 'navbar/isPromotionAccordionActive',
                isInformationAccordionActive: 'navbar/isInformationAccordionActive',
            })
        },
        methods: {
            logout() {
                this.$store.commit('security/LOGOUT');
                this.$router.push({path: '/user/login'});
            },
            clickDropdownItem() {
                this.$store.commit('navbar/DEACTIVATE_ALL_MENU_DROPDOWN');
            },
            activeDropdown(dropdownId) {
                this.$store.commit('navbar/ACTIVE_MENU_DROPDOWN', dropdownId)
            },
            activeMenuAccordion(accordionId) {
                this.$store.commit('navbar/ACTIVE_MENU_ACCORDION', accordionId)
            },
            ...mapMutations({
                toggleNavMenu: 'navbar/TOGGLE_MOBILE_MENU',
                closeNavMenu: 'navbar/CLOSE_MOBILE_MENU',
                deactivateAllDropdown: 'navbar/DEACTIVATE_ALL_MENU_DROPDOWN',
                closeAllMenuAccordion: 'navbar/CLOSE_ALL_MENU_ACCORDION',
            })
        }
    }

</script>
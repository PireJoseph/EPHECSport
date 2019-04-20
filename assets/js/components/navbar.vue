<template>
    <div id="nav">

        <!-- Navbar -->
        <div class="w3-top">
            <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
                <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-theme-d2" href="javascript:void(0);" @click="toggleNavMenu" ><i class="fa fa-bars"></i></a>
                <router-link to="/user/home" class="w3-bar-item w3-button w3-padding-large w3-theme-d4" ><span  v-on:click="closeNavMenu"><i class="fa fa-home w3-margin-right" ></i>Home</span></router-link>
                <router-link to="/user/profile" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Profile" ><i class="fa fa-user"></i></router-link>
                <router-link to="/user/activity" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Activités" ><i class="fa fa-bolt"></i></router-link>
                <router-link to="/user/promotion" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Promotion" ><i class="fa fa-star"></i></router-link>
                <router-link to="/user/information" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white" title="Information" ><i class="fa fa-search"></i></router-link>

                <a href="#" class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large w3-hover-white" @click="logout" title="My Account"><i class="fa fa-user-times w3-margin-right"></i>Se déconnecter</a>
            </div>
        </div>

        <!-- Navbar on small screens -->
        <div id="navDemo" v-bind:class="{ 'w3-show': mobileMenuShowed }" v-on:click="toggleNavMenu" class="w3-bar-block w3-theme-d2 w3-hide w3-hide-large w3-hide-medium w3-large">
            <router-link to="/user/profile" class="w3-bar-item w3-button w3-padding-large" >Profile</router-link>
            <router-link to="/user/activity" class="w3-bar-item w3-button w3-padding-large" >Activités</router-link>
            <router-link to="/user/promotion" class="w3-bar-item w3-button w3-padding-large" >Promotion</router-link>
            <router-link to="/user/information" class="w3-bar-item w3-button w3-padding-large"  >Information</router-link>
        </div>

    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import { mapMutations } from 'vuex'

    export default {
        name: 'navbar',
        computed: {
            // mobileMenuShowed ()
            // {
            //     return this.$store.getters['mobileMenu/isMobileMenuShowed']
            // }
            ...mapGetters({
                isAuthenticated:  'security/isAuthenticated',
                mobileMenuShowed: 'mobileMenu/isMobileMenuShowed',
            })
        },
        methods: {
            // toggleNavMenu() {
            //     this.$store.commit('mobileMenu/TOGGLE_MOBILE_MENU')
            // },
            // closeNavMenu() {
            //     this.$store.commit('mobileMenu/CLOSE_MOBILE_MENU')
            // },
            logout() {
                this.$store.commit('security/LOGOUT');
                this.$router.push({path: '/user/login'});
            },
            ...mapMutations({
                toggleNavMenu: 'mobileMenu/TOGGLE_MOBILE_MENU',
                closeNavMenu: 'mobileMenu/CLOSE_MOBILE_MENU'
            })
        }
    }

</script>
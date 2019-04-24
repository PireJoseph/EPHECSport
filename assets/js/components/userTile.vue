<template>
    <div v-show="baseDataLoaded" class="w3-card w3-round w3-white">
        <div class="w3-container">
            <h4 class="w3-center">{{username}}</h4>
            <p class="w3-center"><img v-bind:src="picture" class="w3-circle" style="width:64px" alt="Avatar"></p>
            <hr>
            <p  class="w3-center"><i class="fa fa-envelope fa-fw w3-margin-right w3-text-theme"></i>{{email}}</p>
            <p  v-show="schoolSection" class="w3-center"><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i>{{schoolSection}}</p>
            <!--<p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i> London, UK</p>-->
            <p v-show="birthDate" class="w3-center" ><i class="fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme"></i>{{birthDate}}</p>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import { mapMutations } from 'vuex'


    export default {
        name: 'user-tile',
        state: {

        },
        computed: {
            ...mapGetters({
                username: 'user/username',
                email: 'user/userMail',
                picture: 'user/userPicture',
                schoolSection: 'user/userSchoolSection',
                birthDate: 'user/userBirthDate',
                baseDataLoaded: 'common/baseDataLoaded'
                // isAuthenticated:  'security/isAuthenticated',
                // mobileMenuShowed: 'mobileMenu/isMobileMenuShowed',
            })
        },
        methods: {
            ...mapMutations({
                // toggleNavMenu: 'mobileMenu/TOGGLE_MOBILE_MENU',
                // closeNavMenu: 'mobileMenu/CLOSE_MOBILE_MENU'
            })
        }
    }

</script>
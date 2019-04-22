<template>
    <div id="nav">

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
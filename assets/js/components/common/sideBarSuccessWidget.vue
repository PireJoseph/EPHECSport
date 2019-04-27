<style scoped>

    .w3-tag {
        padding: 5px;
        height: 25px;
        overflow: hidden;
    }

</style>

<template>

    <!-- Interests -->
    <div class="w3-card w3-round w3-white w3-hide-small">
        <div class="w3-container">
            <p>Succès</p>
            <p>
                <span v-for="userSuccess in userSuccessAray" :key="userSuccess.id" class="w3-tag w3-small" v-bind:class="userSuccess.themeColor" style="width: 100%">{{ userSuccess.label }}</span>
            </p>
        </div>
    </div>

</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        name: 'side-bar-success-widget',
        computed: {
            ...mapGetters({
                userSuccessAray: 'user/userSuccess',
            })
        },
    }

</script>
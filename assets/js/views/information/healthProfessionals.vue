<style scoped>

</style>

<template>

    <div>

        <div class="w3-card w3-round w3-white w3-padding-32 w3-hide-small">
            <h3>>Professionel de la santé</h3>
        </div>

        <div v-show="healthProfessionalsLoading">

        </div>

        <div v-show="!healthProfessionalsLoading && !!healthProfessionals">

        </div>

    </div>

</template>

<script>

    import {mapState} from "vuex";

    export default {
        name: 'health-professionals',
        components: {

        },
        data() {
            return {

            }
        },
        computed: {

            ...mapState({

                healthProfessionals : (state) => state.information.healthProfessionals,
                healthProfessionalsLoading : (state) => state.information.healthProfessionalsLoading,

            }),

        },
        methods: {

            getHealthProfessionalsData() {
                this.$store.dispatch('information/getHealthProfessionalsData')
            },

        },
        mounted() {
            this.getHealthProfessionalsData();
        },
    }
</script>
<style scoped>



</style>



<template>
    <div>

        <div class="w3-card w3-round w3-white w3-padding-32">
            <h1>Equipes officielles</h1>
        </div>


    </div>
</template>


<script>

    import {mapGetters} from "vuex";
    import moment from "moment"

    export default {
        name: 'official-teams',
        data() {
            return {

            }
        },
        computed: {

            ...mapGetters({
                officialTeams : 'promotion/officialTeams'
                // userId: 'user/userId'
            }),


        },
        methods: {
            getCrucialMeetingsData() {
                this.$store.dispatch('promotion/getOfficialTeamsData')
            },

        },
        mounted() {
            this.getCrucialMeetingsData();
        },
    }
</script>
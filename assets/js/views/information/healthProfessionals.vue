<style scoped>
    .pro-header {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .pro-info {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-start;
    }
</style>

<template>

    <div>

        <div class="w3-card w3-round w3-white w3-padding-32 w3-hide-small">
            <h3>Professionel de la santé</h3>
        </div>

        <div v-show="!!healthProfessionals">
            <div v-for="pro in healthProfessionals" :key="pro.id" class="w3-container w3-card w3-white w3-round w3-margin-top"><br>
                <div class="pro-header">
                    <div class="w3-opacity pro-info">
                        <p >{{pro.title}}</p>
                        <p>  <i class="fas fa-phone"></i> {{pro.phoneNumber}}</p>
                        <p> <i class="fas fa-envelope"></i> {{pro.email}}</p>
                    </div>
                    <span>{{pro.firstName}} {{pro.lastName}}</span><br>
                    <img class=" w3-circle w-image" style="width:60px"
                         v-if="!!pro.picture"
                         v-bind:src="(getPicturePath()  + pro.picture.image)"
                         v-bind:title="pro.picture.label"
                         v-bind:alt="pro.picture.label"
                    >
                </div>



                <hr class="w3-clear">
                <p>{{pro.presentation}}</p>
            </div>
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

            getPicturePath(){
                return   '/images/pictures/';
            },

        },
        mounted() {
            this.getHealthProfessionalsData();
        },
    }
</script>
<style scoped>
    .pro-header {
/*        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;*/
    }
    .pro-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .pro-info {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-start;
        flex: 1 1 50%;
    }
    .pro-image {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        flex: 1 0 50%;
    }
    .pro-image img{
        width: 100px;
        height: 100px;
    }

</style>

<template>

    <div>

        <div class="w3-card w3-round w3-white w3-padding-32 w3-hide-small">
            <h3>Professionel de la santé</h3>
        </div>

        <div v-show="!!healthProfessionals">

            <article v-for="pro in healthProfessionals" :key="pro.id" class="w3-container w3-card w3-white w3-round w3-margin-top"><br>
                <header class="pro-header">
                    <span>{{pro.firstName}} {{pro.lastName}}</span><br>
                </header>
                <div class="pro-details">
                    <div class="pro-image">
                        <img class="w3-circle w3-image"
                             v-if="!!pro.picture"
                             v-bind:src="(getPicturePath()  + pro.picture.image)"
                             v-bind:title="pro.picture.label"
                             v-bind:alt="pro.picture.label"
                        >
                    </div>
                    <div class="w3-opacity pro-info">
                        <div>
                            <span><i class="fas fa-user-tie"></i></span>
                            <span>{{pro.title}}</span>
                        </div>
                        <div>
                            <span><i class="fas fa-phone"></i></span>
                            <span>{{pro.phoneNumber}}</span>
                        </div>
                        <div>
                            <span><i class="fas fa-envelope"></i></span>
                            <span>{{pro.email}}</span>
                        </div>
                    </div>
                </div>
                <footer class="pro-footer">
                    <p>{{pro.presentation}}</p>
                </footer>
            </article>

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
                idsOfProfessionalExpanded : []
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
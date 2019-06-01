<style scoped>

    .external-link{
        padding: 24px;
        height: 120px;
        display: flex;
        justify-content: flex-start;
    }

    .external-link-picture-container{
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 50px;
        width: 100px;
    }
    .external-link-picture {
        width: 80px;
    }
    .external-link-details{
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
    }
    .external-link-details{
        width: 100%;
    }
    .external-link-description{
        align-self: flex-end;
        font-size: medium;
    }



    @media only screen and (max-width: 600px) {
        .external-link {
            padding: 16px;
            height: 100px;
        }
        .external-link-picture-container{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 20px;
        }
        .external-link-picture {
            width: 100px;
        }
        .external-link-picture {
            width: 60px;
        }

    }

    @media screen and (max-width: 992px) {
        .external-link-description{
            align-self: flex-start;
            font-size: small;
        }
    }

</style>

<template>

    <div>

        <div class="w3-card w3-round w3-white w3-padding-32 w3-hide-small">
            <h3>Lien externes</h3>
        </div>



        <div v-show="!externalLinksLoading && !!externalLinks" class=" w3-margin-top">

            <a  v-for="link in externalLinks" :key="link.id" v-bind:href="link.url" target="_blank" class="external-link w3-button w3-btn w3-card w3-round w3-theme-l1 w3-padding-16  w3-margin-bottom" >
                <div class="external-link-picture-container">
                    <img class="w3-image external-link-picture"
                    v-if="!!link.picture"
                    v-bind:src="(getPicturePath()  + link.picture.image)"
                    v-bind:title="link.picture.label"
                    v-bind:alt="link.picture.label"
                    >
                </div>
                <div class="external-link-details">
                    <h4 class="external-link-label ">
                        {{ link.label }}
                    </h4>
                    <p class="external-link-description w3-opacity w3-hide-small">
                        {{ link.description}}
                    </p>
                </div>
            </a>

        </div>

    </div>

</template>

<script>

    import {mapState} from "vuex";

    export default {
        name: 'external-links',
        components: {

        },
        data() {
            return {

            }
        },
        computed: {

            ...mapState({

                externalLinks : (state) => state.information.externalLinks,
                externalLinksLoading : (state) => state.information.externalLinksLoading,

            }),

        },
        methods: {

            getExternalLinksData() {
                this.$store.dispatch('information/getExternalLinksData')
            },

            openLink(url) {

            },

            getPicturePath(){
                return   '/images/pictures/';
            },

        },
        mounted() {
            this.getExternalLinksData();
        },
    }
</script>
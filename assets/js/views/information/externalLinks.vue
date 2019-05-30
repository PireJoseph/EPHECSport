<style scoped>

</style>

<template>

    <div>

        <div class="w3-card w3-round w3-white w3-padding-32 w3-hide-small">
            <h3>>Lien externes</h3>
        </div>

        <div v-show="externalLinksLoading">

        </div>

        <div v-show="!externalLinksLoading && !!externalLinks">

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

        },
        mounted() {
            this.getExternalLinksData();
        },
    }
</script>
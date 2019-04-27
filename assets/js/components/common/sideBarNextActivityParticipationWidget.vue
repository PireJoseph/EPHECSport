<style scoped>

    #sideBarNextActivityStartAt, #sideBarNextActivityLocation {
        color: #4d636f;
    }
    #sideBarNextActivityStartAt {
        margin-bottom: 3px;
    }
    #sideBarNextActivityLocation {
        margin-top: 3px;
    }

</style>

<template>

    <div v-if="nextActivityParticipation" class="w3-card w3-round w3-white w3-center">
        <div class="w3-container">
            <h6><strong>Prochaine activité</strong></h6>
            <p id="sideBarNextActivityLabel" >{{ nextActivityParticipation.activityLabel }}</p>
            <p id="sideBarNextActivityStartAt"  v-if="nextActivityParticipation.activityStartAt"  >le {{ nextActivityParticipation.activityStartAt }}</p>
            <p id="sideBarNextActivityLocation" v-if="nextActivityParticipation.activityLocation" >à {{ nextActivityParticipation.activityLocation }}</p>
        </div>

    </div>

</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        name: 'side-bar-next-activity-participation-widget',
        computed: {
            ...mapGetters({
                nextActivityParticipation: 'user/nextActivityParticipation',
            })
        },
    }

</script>
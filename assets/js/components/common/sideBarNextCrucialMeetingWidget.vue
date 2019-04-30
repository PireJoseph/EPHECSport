<style scoped>

#sideBarNextCrucialMeetingStartAt, #sideBarNextCrucialMeetingLocation {
    color: #4d636f;
}

#sideBarNextCrucialMeetingStartAt {
    margin-bottom: 3px;
}

#sideBarNextCrucialMeetingLocation {
    margin-top: 3px;
}

</style>

<template>

    <div v-if="Object.keys(nextCrucialMeeting).length" class="w3-card w3-round w3-white w3-center">
        <div class="w3-container">
            <h6><strong>Prochaine rencontre importante</strong></h6>
            <p id="sideBarNextCrucialMeetingLabel" >{{ nextCrucialMeeting.label }}</p>
            <p id="sideBarNextCrucialMeetingStartAt"  v-if="nextCrucialMeeting.startAt"  >le {{ nextCrucialMeeting.startAt }}</p>
            <p id="sideBarNextCrucialMeetingLocation" v-if="nextCrucialMeeting.location" >à {{ nextCrucialMeeting.location }}</p>
        </div>

    </div>

</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        name: 'side-bar-next-crucial-meeting-widget',
        computed: {
            ...mapGetters({
                nextCrucialMeeting: 'user/nextCrucialMeeting',
            })
        },
    }

</script>
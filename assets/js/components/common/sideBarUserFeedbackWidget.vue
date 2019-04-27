<style scoped>

    .progressBarContainer {
        position: relative;
        width: 100%;
        background-color: #ddd;
        margin-bottom: 5px;
        height: 25px;
    }

    .progressBar {
        height: 25px;
        background-color: #3a4b53;
        z-index: -1;
    }

    .progressBarLabel {
        position: absolute;
        height: 25px;
        line-height: 25px;
        color: white;
        z-index: 1;
        width: 100%;
        text-align: left;
        display: flex;
        justify-content: space-between;
        padding: 0 5px;
        font-size: 12px;
    }

    #progressBarWidgetContainer {
        padding-bottom: 15px;
    }

</style>

<template>

    <!-- Interests -->
    <div id="progressBarWidgetContainer" class="w3-card w3-round w3-white w3-hide-small">
        <div class="w3-container">
            <p>Feedbacks reçus</p>
            <div v-for="addressedUserRelatedFeedbackLabelsCumuled in addressedUserRelatedFeedbackLabelsCumuledArray" :key="addressedUserRelatedFeedbackLabelsCumuled.value" class="progressBarContainer">
                <div class="progressBar" v-bind:style="{ width: addressedUserRelatedFeedbackLabelsCumuled.percent + '%' }">
                    <div class="progressBarLabel">
                        <span>{{ addressedUserRelatedFeedbackLabelsCumuled.label }}</span><span>{{ addressedUserRelatedFeedbackLabelsCumuled.count }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        name: 'side-bar-user-feedback-widget',
        computed: {
            ...mapGetters({
                addressedUserRelatedFeedbackLabelsCumuledArray: 'user/addressedUserRelatedFeedbackLabelsCumuled',
            })
        },
    }

</script>
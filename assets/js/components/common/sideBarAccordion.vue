<style scoped>

    .w3-container {
        overflow: hidden;
    }

    button:disabled{
        opacity: 0.6;
    }

</style>

<template>

    <!-- Accordion -->
    <div class="w3-card w3-round">
        <div class="w3-white">
            <button @click="togglePreferredPartnersAccordion" class="w3-button w3-block w3-theme-l1 w3-left-align" :disabled="!userPreferredPartners.length"><i class="fa fa-users fa-fw w3-margin-right"></i> Partenaires</button>
            <div v-show="(isPreferredPartnersAccordionOpen && userPreferredPartners.length) " class="w3-container">
                <p v-for="userPreferredPartner in userPreferredPartners" :key="userPreferredPartner.id">{{ userPreferredPartner.username }}</p>
            </div>
            <button @click="toggleDisponibilityAccordion" class="w3-button w3-block w3-theme-l1 w3-left-align" :disabled="!userDisponibilityPatterns.length"><i class="fa fa-calendar-check-o fa-fw w3-margin-right"></i> Disponibilités</button>
            <div v-show="(isDisponibilityAccordionOpen && userDisponibilityPatterns.length)" class="w3-container">
                <p v-for="userDisponibilityPattern in userDisponibilityPatterns" :key="userDisponibilityPattern.value">{{ userDisponibilityPattern.label }}</p>
            </div>
            <button @click="togglePictureAccordion" class="w3-button w3-block w3-theme-l1 w3-left-align" :disabled="!userPictures.length" ><i class="fa fa-camera fa-fw w3-margin-right"></i> Photos</button>
            <div v-show="(isPictureAccordionOpen && userPictures.length)" class="w3-container">
                <div class="w3-row-padding">
                    <br>
                    <div v-for="userPicture in userPictures" :key="userPicture.id" class="w3-half" >
                        <img v-bind:src="userPicture.picture" v-bind:title="userPicture.label" style="width:100%" class="w3-margin-bottom">
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
    import { mapGetters } from 'vuex'
    import { mapMutations } from 'vuex'


    export default {
        name: 'side-bar-accordion',
        computed: {
            ...mapGetters({
                isPreferredPartnersAccordionOpen: 'sideBar/isPreferredPartnersAccordionOpen',
                isDisponibilityAccordionOpen: 'sideBar/isDisponibilityAccordionOpen',
                isPictureAccordionOpen: 'sideBar/isPictureAccordionOpen',
                userPreferredPartners: 'user/userPreferredPartners',
                userDisponibilityPatterns : 'user/userDisponibilityPatterns',
                userPictures: 'user/userPictures',
                userSuccess: 'user/userSuccess',
            })
        },
        methods: {
            ...mapMutations({
                togglePreferredPartnersAccordion: 'sideBar/TOGGLE_PREFERRED_PARTNER_ACCORDION',
                toggleDisponibilityAccordion: 'sideBar/TOGGLE_DISPONIBILITY_ACCORDION',
                togglePictureAccordion: 'sideBar/TOGGLE_PICTURES_ACCORDION',

            })
        }
    }

</script>
<template>

    <!-- Accordion -->
    <div class="w3-card w3-round">
        <div class="w3-white">
            <button @click="togglePreferredPartnersAccordion" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i> Partenaires</button>
            <div v-show="isPreferredPartnersAccordionOpen" class="w3-container">
                <p>Some text..</p>
            </div>
            <button @click="toggleDisponibilityAccordion" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-calendar-check-o fa-fw w3-margin-right"></i> Disponibilités</button>
            <div v-show="isDisponibilityAccordionOpen" class="w3-container">
                <p>Some other text..</p>
            </div>
            <button @click="togglePictureAccordion" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-users fa-fw w3-margin-right"></i> Photos</button>
            <div v-show="isPictureAccordionOpen" class="w3-container">
                <div class="w3-row-padding">
                    <br>
                    <div class="w3-half">
                        <img src="/w3images/lights.jpg" style="width:100%" class="w3-margin-bottom">
                    </div>
                    <div class="w3-half">
                        <img src="/w3images/nature.jpg" style="width:100%" class="w3-margin-bottom">
                    </div>
                    <div class="w3-half">
                        <img src="/w3images/mountains.jpg" style="width:100%" class="w3-margin-bottom">
                    </div>
                    <div class="w3-half">
                        <img src="/w3images/forest.jpg" style="width:100%" class="w3-margin-bottom">
                    </div>
                    <div class="w3-half">
                        <img src="/w3images/nature.jpg" style="width:100%" class="w3-margin-bottom">
                    </div>
                    <div class="w3-half">
                        <img src="/w3images/snow.jpg" style="width:100%" class="w3-margin-bottom">
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
        state: {

        },
        computed: {
            ...mapGetters({
                isPreferredPartnersAccordionOpen: 'sideBar/isPreferredPartnersAccordionOpen',
                isDisponibilityAccordionOpen: 'sideBar/isDisponibilityAccordionOpen',
                isPictureAccordionOpen: 'sideBar/isPictureAccordionOpen',
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
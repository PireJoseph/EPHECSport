export default {
    namespaced: true,
    state: {
        isPreferredPartnersAccordionOpen: false,
        isDisponibilityAccordionOpen: false,
        isPictureAccordionOpen: false,
    },
    getters: {
        isPreferredPartnersAccordionOpen (state) {
            return state.isPreferredPartnersAccordionOpen;
        },
        isDisponibilityAccordionOpen (state) {
            return state.isDisponibilityAccordionOpen;
        },
        isPictureAccordionOpen (state) {
            return state.isPictureAccordionOpen;
        },
    },
    mutations: {
        ['TOGGLE_PREFERRED_PARTNER_ACCORDION'](state) {
            state.isPreferredPartnersAccordionOpen = !state.isPreferredPartnersAccordionOpen
        },
        ['TOGGLE_DISPONIBILITY_ACCORDION'](state) {
            state.isDisponibilityAccordionOpen = !state.isDisponibilityAccordionOpen
        },
        ['TOGGLE_PICTURES_ACCORDION'](state) {
            state.isPictureAccordionOpen = !state.isPictureAccordionOpen
        },
    },


}
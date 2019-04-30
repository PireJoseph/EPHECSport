export default {
    namespaced: true,
    state: {
        isMobileMenuOpen: false,
        isProfileDropDownActive: false,
        isActivityDropDownActive: false,
        isPromotionDropDownActive: false,
        isInformationDropDownActive: false,
        isProfileAccordionActive: false,
        isActivityAccordionActive: false,
        isPromotionAccordionActive: false,
        isInformationAccordionActive: false,
    },
    getters: {
        isMobileMenuShowed (state) {
            return state.isMobileMenuOpen;
        },
        isProfileDropDownActive (state) {
            return state.isProfileDropDownActive;
        },
        isActivityDropDownActive (state) {
            return state.isActivityDropDownActive;
        },
        isPromotionDropDownActive (state) {
            return state.isPromotionDropDownActive;
        },
        isInformationDropDownActive (state) {
            return state.isInformationDropDownActive;
        },
        isProfileAccordionActive (state) {
            return state.isProfileAccordionActive;
        },
        isActivityAccordionActive (state) {
            return state.isActivityAccordionActive;
        },
        isPromotionAccordionActive (state) {
            return state.isPromotionAccordionActive;
        },
        isInformationAccordionActive (state) {
            return state.isInformationAccordionActive;
        },
    },
    mutations: {
        ['TOGGLE_MOBILE_MENU'](state) {
            state.isMobileMenuOpen = !state.isMobileMenuOpen;
        },
        ['CLOSE_MOBILE_MENU'](state) {
            state.isMobileMenuOpen = false;
        },
        ['ACTIVE_MENU_DROPDOWN'](state, payload) {
            switch (payload)
            {
                case ('profile'):
                    state.isActivityDropDownActive = false;
                    state.isPromotionDropDownActive = false;
                    state.isInformationDropDownActive = false;
                    state.isProfileDropDownActive = true;
                    return;

                case ('activity'):
                    state.isProfileDropDownActive = false;
                    state.isPromotionDropDownActive = false;
                    state.isInformationDropDownActive = false;
                    state.isActivityDropDownActive = true;
                    return;

                case ('promotion'):
                    state.isProfileDropDownActive = false;
                    state.isActivityDropDownActive = false;
                    state.isInformationDropDownActive = false;
                    state.isPromotionDropDownActive = true;
                    return;

                case ('information'):
                    state.isProfileDropDownActive = false;
                    state.isActivityDropDownActive = false;
                    state.isPromotionDropDownActive = false;
                    state.isInformationDropDownActive = true;
                    return;

                default:
                    return;
            }
        },
        ['DEACTIVATE_ALL_MENU_DROPDOWN'](state) {
            state.isProfileDropDownActive = false;
            state.isActivityDropDownActive = false;
            state.isPromotionDropDownActive = false;
            state.isInformationDropDownActive = false;
        },
        ['ACTIVE_MENU_ACCORDION'](state, payload) {
            switch (payload)
            {
                case ('profile'):
                    state.isProfileAccordionActive = true;
                    state.isActivityAccordionActive = false;
                    state.isPromotionAccordionActive = false;
                    state.isInformationAccordionActive = false;
                    return;

                case ('activity'):
                    state.isProfileAccordionActive = false;
                    state.isActivityAccordionActive = true;
                    state.isPromotionAccordionActive = false;
                    state.isInformationAccordionActive = false;
                    return;

                case ('promotion'):
                    state.isProfileAccordionActive = false;
                    state.isActivityAccordionActive = false;
                    state.isPromotionAccordionActive = true;
                    state.isInformationAccordionActive = false;
                    return;

                case ('information'):
                    state.isProfileAccordionActive = false;
                    state.isActivityAccordionActive = false;
                    state.isPromotionAccordionActive = false;
                    state.isInformationAccordionActive = true;
                    return;

                default:
                    return;
            }
        },
        ['CLOSE_ALL_MENU_ACCORDION'](state) {
            state.isProfileAccordionActive = false;
            state.isActivityAccordionActive = false;
            state.isPromotionAccordionActive = false;
            state.isInformationAccordionActive = false;
        }
    },

}
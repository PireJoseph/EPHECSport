import UserAPI from '../api/user';

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        userId : Number,
        username: "Nom d'utilisateur",
        userMail: String,
        userPicture: "/images/profilePictures/fallBackUserIcon.png",
        userBirthDate: Date,
        userSchoolClass : String,
        userSchoolSection : String,
        userCreatedAt : Date,
        userPreferredPartners: Array,
        userDisponibilityPatterns : Array,
        userPictures: Array,
        userSuccess: Array,
        addressedUserRelatedFeedbacks : Array,
        addressedUserRelatedFeedbackLabelsCumuled : Array,
        nextActivityParticipation : Array
    },
    getters: {
        isLoading (state) {
            return state.isLoading;
        },
        hasError (state) {
            return state.error !== null;
        },
        error (state) {
            return state.error;
        },
        userId (state) {
            return state.userId;
        },
        username (state) {
            return state.username;
        },
        userMail (state) {
            return state.userMail
        },
        userPicture (state) {
            return state.userPicture
        },
        userSchoolClass (state) {
            return state.userSchoolClass
        },
        userSchoolSection (state) {
            return state.userSchoolSection
        },
        userBirthDate (state) {
            return state.userBirthDate
        },
        userCreatedAt (state) {
            return state.userCreatedAt
        },
        userPreferredPartners (state) {
            return state.userPreferredPartners
        },
        userDisponibilityPatterns (state) {
            return state.userDisponibilityPatterns
        },
        userPictures (state) {
            return state.userPictures
        },
        userSuccess (state) {
            return state.userSuccess
        },
        addressedUserRelatedFeedbacks (state) {
            return state.addressedUserRelatedFeedbacks
        },
        addressedUserRelatedFeedbackLabelsCumuled (state) {
            return state.addressedUserRelatedFeedbackLabelsCumuled;
        },
        nextActivityParticipation (state) {
            return state.nextActivityParticipation;
        }
    },
    mutations: {

        ['SET_USER_ID'](state, id) {
            state.userId = id;
        },
        ['FETCHING_CURRENT_USER'](state) {
            state.isLoading = true;
            state.error = null;
            state.currentUser = null;
        },
        ['FETCHING_CURRENT_USER_SUCCESS'](state, user) {
            state.isLoading = false;
            state.error = null;
            state.currentUser = user;
        },
        ['FETCHING_CURRENT_USER_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error.message;
            state.currentUser = null;
        },
        ['SET_USER_BASE_DATA'](state, data) {
            state.userId = data.id;
            state.username = data.username;
            state.userMail = data.email;
            state.userPicture = data.userPicture;
            state.userBirthDate = data.birthDate;
            state.userSchoolClass = data.userClass;
            state.userSchoolSection = data.userSection;
            state.userCreatedAt = data.createdAt;
            state.userPreferredPartners = data.preferredPartnerDTOs;
            state.userDisponibilityPatterns = data.disponibilityPatterns;
            state.userPictures = data.pictureDTOs;
            state.userSuccess = data.successDTOs;
            state.addressedUserRelatedFeedbacks = data.addressedUserRelatedFeedbackDTOs;
            state.addressedUserRelatedFeedbackLabelsCumuled = data.addressedUserRelatedFeedbackLabelsCumuled;
            state.nextActivityParticipation = data.nextActivityParticipationDTO;
            state.isLoading = false;
            state.error = null;
        },

    },
    actions : {
        fetchCurrentUser({commit}, id){
            commit('FETCHING_CURRENT_USER');
            return UserAPI.get(id)
                .then(res => commit('FETCHING_CURRENT_USER_SUCCESS', res.data))
                .catch(err => commit('FETCHING_CURRENT_USER_ERROR', err))
        }
    }

}
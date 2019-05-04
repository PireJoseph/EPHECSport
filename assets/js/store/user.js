import UserAPI from '../api/user';
import ProfileAPI from '../api/profile';

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        userId : Number,
        username: "Nom d'utilisateur",
        userMail: String,
        userGender: String,
        userPhoneNumber : String,
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
        nextActivityParticipation : Array,
        nextCrucialMeeting : Array,
        profileData : null,
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
        userGender (state) {
            return state.userGender
        },
        userPhoneNumber(state) {
            return state.userPhoneNumber
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
        },
        nextCrucialMeeting (state) {
            return state.nextCrucialMeeting;
        }
    },
    mutations: {

        ['SET_USER_ID'](state, id) {
            state.userId = id;
        },

        ['UPDATING_PROFILE_DATA'](state){
            state.isLoading = true;
            state.error = null;
        },
        ['UPDATE_PROFILE_DATA_SUCCESS'](state, data){
            state.isLoading = false;
            state.error = null;
            state.username = data.username;
        },
        ['UPDATE_PROFILE_DATA_ERROR'](state, error){
            state.isLoading = false;
            state.error = error.message;
        },

        // ['FETCHING_PROFILE_DATA'](state) {
        //     state.isLoading = true;
        //     state.error = null;
        //     state.profileData = null;
        // },
        // ['FETCHING_PROFILE_DATA_SUCCESS'](state, data) {
        //     state.isLoading = false;
        //     state.error = null;
        //     state.profileData = data;
        // },
        // ['FETCHING_PROFILE_DATA_ERROR'](state, error) {
        //     state.isLoading = false;
        //     state.error = error.message;
        //     state.profileData = null;
        // },


        ['SET_USER_BASE_DATA'](state, data) {
            state.userId = data.id;
            state.username = data.username;
            state.userMail = data.email;
            state.userGender = data.gender;
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
            state.nextCrucialMeeting = data.nextCrucialMeetingDTO;
            state.isLoading = false;
            state.error = null;
        },

    },
    actions : {

        updateProfileData({commit, state}, data){
            let id = state.userId;
            commit('UPDATING_PROFILE_DATA');
            return ProfileAPI.put(id, data)
                .then(res => commit('UPDATE_PROFILE_DATA_SUCCESS', res.data))
                .catch(err => commit('UPDATE_PROFILE_DATA_ERROR', err))
        }

        // fetchProfileData({commit}, id){
        //     commit('FETCHING_PROFILE_DATA');
        //     return ProfileAPI.get(id)
        //         .then(res => commit('FETCHING_PROFILE_DATA_SUCCESS', res.data))
        //         .catch(err => commit('FETCHING_PROFILE_DATA_ERROR', err))
        // },

    }

}
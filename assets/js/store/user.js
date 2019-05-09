import UserAPI from '../api/user';
import ProfileAPI from '../api/profile';
import {arrayDiff} from "vuetify/lib/util/helpers";

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
        userDescription : String,
        userPicture: "/images/profilePictures/fallBackUserIcon.png",
        areSuccessUnlockedVisible: Boolean,
        areActivityParticipationVisible: Boolean,
        isPersonalProfileVisible: Boolean,
        userBirthDate: Date,
        userSchoolClass : String,
        userSchoolSection : String,
        userCreatedAt : Date,
        canGoAway :  Boolean,
        activityCostLimit : Number,
        userPreferredPartners: Array,
        userDisponibilityPatterns : Array,
        userPictures: Array,
        userSuccess: Array,
        addressedUserRelatedFeedbacks : Array,
        addressedUserRelatedFeedbackLabelsCumuled : Array,
        nextActivityParticipation : Array,
        nextCrucialMeeting : Array,
        profileData : null,
        otherProfiles: [],
        sportProfileDTOs: []
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
        userDescription (state) {
            return state.userDescription
        },
        userPicture (state) {
            return state.userPicture
        },
        areSuccessUnlockedVisible (state) {
            return state.areSuccessUnlockedVisible
        },
        areActivityParticipationVisible (state) {
            return state.areActivityParticipationVisible
        },
        isPersonalProfileVisible (state) {
            return state.isPersonalProfileVisible
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
        canGoAway (state) {
            return state.canGoAway
        },
        activityCostLimit (state) {
            return state.activityCostLimit
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
        },
        otherProfiles (state) {
            return state.otherProfiles
        },
        sportProfileDTOs (state) {
            return state.sportProfileDTOs
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
        ['UPDATE_PROFILE_DATA_SUCCESS'](state){
            state.isLoading = false;
            state.error = null;
        },
        ['UPDATE_PROFILE_DATA_ERROR'](state, error){
            state.isLoading = false;
            state.error = error.message;
        },
        ['POSTING_SPORT_PROFILE_DATA'](state){
            state.isLoading = true;
            state.error = null;
        },
        ['POST_SPORT_PROFILE_DATA_SUCCESS'](state){
            state.isLoading = false;
            state.error = null;
        },
        ['POST_SPORT_PROFILE_DATA_ERROR'](state, error){
            state.isLoading = false;
            state.error = error.message;
        },
        ['REFRESHING_OTHER_PROFILE_DATA'](state){
            state.isLoading = true;
            state.error = null;
        },
        ['REFRESH_OTHER_PROFILE_DATA_SUCCESS'](state, data){
            state.isLoading = false;
            console.log(data);
            state.otherProfiles = data['hydra:member'];
            state.error = null;
        },
        ['REFRESH_OTHER_PROFILE_DATA_ERROR'](state, error){
            state.isLoading = false;
            state.error = error.message;
            state.otherProfiles = [];
        },


        ['SET_USER_BASE_DATA'](state, data) {
            state.userId = data.id;
            state.username = data.username;
            state.userMail = data.email;
            state.userPhoneNumber = data.phoneNumber;
            state.userDescription = data.description;
            state.userGender = data.gender;
            state.userPicture = data.userPicture;
            state.areSuccessUnlockedVisible = data.areSuccessUnlockedVisible;
            state.areActivityParticipationVisible = data.areActivityParticipationVisible;
            state.isPersonalProfileVisible = data.isPersonalProfileVisible;
            state.userBirthDate = data.birthDate;
            state.userSchoolClass = data.userClass;
            state.userSchoolSection = data.userSection;
            state.userCreatedAt = data.createdAt;
            state.canGoAway = data.canGoAway;
            state.activityCostLimit = data.activityCostLimit;
            state.userPreferredPartners = data.preferredPartnerDTOs;
            state.userDisponibilityPatterns = data.disponibilityPatterns;
            state.userPictures = data.pictureDTOs;
            state.userSuccess = data.successDTOs;
            state.addressedUserRelatedFeedbacks = data.addressedUserRelatedFeedbackDTOs;
            state.addressedUserRelatedFeedbackLabelsCumuled = data.addressedUserRelatedFeedbackLabelsCumuled;
            state.nextActivityParticipation = data.nextActivityParticipationDTO;
            state.nextCrucialMeeting = data.nextCrucialMeetingDTO;
            state.sportProfileDTOs = data.sportProfileDTOs
            state.isLoading = false;
            state.error = null;
        },

    },
    actions : {

        updateProfileData({commit, state}, data){
            let id = state.userId;
            commit('UPDATING_PROFILE_DATA');
            return ProfileAPI.put(id, data)
                .then(
                    function(res){
                        commit('UPDATE_PROFILE_DATA_SUCCESS')
                    }
                )
                .catch(err => commit('UPDATE_PROFILE_DATA_ERROR', err))
        },

        getOtherMembers({commit}){
            commit('REFRESHING_OTHER_PROFILE_DATA');
            return ProfileAPI.getAll()
                .then(
                    function(res){
                        commit('REFRESH_OTHER_PROFILE_DATA_SUCCESS', res.data)
                    }
                )
                .catch(err => commit('REFRESH_OTHER_PROFILE_DATA_ERROR', err))
        },

        postSportProfile({commit}, data){
            console.log(data);
            commit('POSTING_SPORT_PROFILE_DATA');
            return ProfileAPI.postSportProfile(data)
                .then(
                    function(){
                        commit('POST_SPORT_PROFILE_DATA_SUCCESS')
                    }
                )
                .catch(err => commit('POST_SPORT_PROFILE_DATA_ERROR', err))
        }

    }

}
import InformationAPI from "../api/information";

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,

        healthProfessionals : [],
        healthProfessionalsLoading : false,
        healthProfessionalsErrors : null,

        externalLinks : [],
        externalLinksLoading: false,
        externalLinksErrors : null,


    },
    mutations: {

        ['GETTING_HEALTH_PROFESSIONALS_DATA'](state){
            state.isLoading = true;
            state.error = null;
            state.healthProfessionals = [];
            state.healthProfessionalsLoading = true;
            state.healthProfessionalsErrors = null;
        },
        ['GET_HEALTH_PROFESSIONALS_DATA_SUCCESS'](state, healthProfessionals){
            state.isLoading = false;
            state.error = null;
            state.healthProfessionals = healthProfessionals;
            state.healthProfessionalsLoading = false;
            state.healthProfessionalsErrors = null;
        },
        ['GET_HEALTH_PROFESSIONALS_DATA_ERROR'](state, error){
            state.isLoading = false;
            state.error = error.message;
            state.healthProfessionals = null;
            state.healthProfessionalsLoading = false;
            state.healthProfessionalsErrors = error.message;
        },


        ['GETTING_EXTERNAL_LINKS_DATA'](state){
            state.isLoading = true;
            state.error = null;
            state.externalLinks = [];
            state.externalLinksLoading = true;
            state.externalLinksErrors = null;
        },
        ['GET_EXTERNAL_LINKS_DATA_SUCCESS'](state, externalLinks){
            state.isLoading = false;
            state.error = null;
            state.externalLinks = externalLinks;
            state.externalLinksLoading = false;
            state.externalLinksErrors = null;
        },
        ['GET_EXTERNAL_LINKS_DATA_ERROR'](state, error){
            state.isLoading = false;
            state.error = error.message;
            state.externalLinks = null;
            state.externalLinksLoading = false;
            state.externalLinksErrors = error.message;
        },


    },
    actions : {

        getExternalLinksData({commit}) {
            commit('GETTING_HEALTH_PROFESSIONALS_DATA');
            return InformationAPI.getCrucialMeetingsData()
                .then(
                    function(res){
                        commit('GET_HEALTH_PROFESSIONALS_DATA_SUCCESS', res.data['hydra:member'])
                    }
                )
                .catch(err => commit('GET_HEALTH_PROFESSIONALS_DATA_ERROR', err))
        },

        getHealthProfessionalsData({commit}) {
            commit('GETTING_EXTERNAL_LINKS_DATA');
            return InformationAPI.getCrucialMeetingsData()
                .then(
                    function(res){
                        commit('GET_EXTERNAL_LINKS_DATA_SUCCESS', res.data['hydra:member'])
                    }
                )
                .catch(err => commit('GET_EXTERNAL_LINKS_DATA_ERROR', err))
        },

    }

}
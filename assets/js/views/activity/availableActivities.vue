<style scoped>


</style>

<template>

    <div>

        <div class="w3-card w3-round w3-white w3-padding-32 w3-hide-small">
            <h3>Activités disponibles</h3>
        </div>

        <div class="w3-card w3-round w3-white w3-padding-32 w3-margin-top w3-container">

            <vue-good-table
                    :columns="header"
                    :rows="transformedAvailableActivities"
                    :search-options="{
                        enabled: true,
                        trigger: 'enter',
                        skipDiacritics: true,
                        placeholder: 'Rechercher',
                  }">
                >
                <template slot="table-row" slot-scope="props">

                    <div v-if="props.column.field == 'after'" class="w3-bar" style="width: 100%">
                        <button v-if="((!props.row.relatedRequest) && (!props.row.isJoinableByAnyone))" class="w3-button w3-black w3-bar-item" :disabled="areActionBtnDisabled" @click="makeJoiningRequest(props.row['@id'])"  style="width: 50%">
                            <span v-show="!isActivityJoiningRequestLoading(props.row['@id'])" >
                                <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                            <span class="w3-hide-small w3-hide-medium"> Demander</span>
                            </span>
                            <span v-show="isActivityJoiningRequestLoading(props.row['@id'])" class="w3-block w3-center">
                                <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                            </span>
                        </button>

                        <button v-if="((!props.row.relatedRequest) && (props.row.isJoinableByAnyone))" class="w3-button w3-green w3-bar-item" :disabled="areActionBtnDisabled" @click="makeJoiningRequest(props.row['@id'])"  style="width: 50%">
                            <span v-show="!isActivityJoiningRequestLoading(props.row['@id'])" >
                                <i class="fas fa-sign-in-alt"></i>
                                <span class="w3-hide-small w3-hide-medium"> Rejoindre</span>
                            </span>
                            <span v-show="isActivityJoiningRequestLoading(props.row['@id'])" class="w3-block w3-center">
                                <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                            </span>
                        </button>

                        <button v-if="(props.row.relatedRequest)" class="w3-button w3-grey w3-bar-item"  title="En attente d'admission" disabled  style="width: 100%">
                            <i class="far fa-clock"></i>
                            <span class="w3-hide-small w3-hide-medium"> Attente d'admission</span>
                        </button>

                    </div>

                    <span v-else-if="props.column.field == 'location'">
                        <span v-if="!!props.row.location">
                            {{props.row.location.label}} - {{props.row.location.city}}
                        </span>
                    </span>

                    <div v-else-if="props.column.field == 'material'">
                        <ul v-if="(props.row.material.length > 0)" class="w3-ul">
                            <li v-for="material in props.row.material" :key="material.id" >{{material.label}}</li>
                        </ul>
                    </div>

                    <span v-else-if="props.column.field == 'startAt'">
                        {{getFormatedDateString(props.row.startAt)}} {{getFormatedDateTimeString(props.row.startAt)}}
                    </span>

                    <span v-else>
                        {{props.formattedRow[props.column.field]}}
                    </span>

                </template>

                <div slot="emptystate">
                    Pas de résultats
                </div>

            </vue-good-table>

        </div>


    </div>

</template>

<script>
    import {mapGetters} from "vuex";
    import moment from 'moment';

    export default {
        name: 'available-activities',
        data() {
            return {

                selectedActivityId : null,

                header: [
                    {
                        label: 'Libellé',
                        field: 'label',
                        filterable: true,
                    },
                    {
                        label: 'Sport',
                        field: 'sport.label',
                        filterable: true,
                        thClass: 'w3-hide-small w3-hide-medium',
                        tdClass: 'w3-hide-small w3-hide-medium',
                    },
                    {
                        label: 'Matériel',
                        field: 'material',
                        filterable: true,
                        thClass: 'w3-hide-small  w3-hide-medium',
                        tdClass: 'w3-hide-small  w3-hide-medium',
                    },
                    {
                        label: 'Lieu',
                        field: 'location',
                        filterable: true,
                        thClass: 'w3-hide-small',
                        tdClass: 'w3-hide-small',
                    },
                    {
                        label: 'Début',
                        field: 'startAt',
                        filterable: true,
                    },
                    {
                        label: 'Accession',
                        field: 'after',
                        html: true,
                        filterable: false,
                        globalSearchDisabled: true,
                    },
                ],

            }
        },
        computed: {

            areActionBtnDisabled(){
                return (this.activityJoiningRequestLoading);
            },

            transformedAvailableActivities() {
                let arrayTransformed;
                arrayTransformed =  this.availableActivities.map(function(e){
                    e.activity['relatedRequest'] =  e['relatedRequest'];
                    return e.activity;
                })
                return arrayTransformed;
            },

            ...mapGetters({
                availableActivities : 'activity/availableActivities',
                activityJoiningRequestLoading : 'activity/activityJoiningRequestLoading'
            }),


        },
        methods: {

            isActivityJoiningRequestLoading(activityIdentifier){
                return (this.activityJoiningRequestLoading && (activityIdentifier === this.selectedActivityId))
            },

            getAvailableActivitiesData() {
                this.$store.dispatch('activity/getAvailableActivities')
            },

            makeJoiningRequest (activityId) {
                this.selectedActivityId = activityId;
                let payload = {};
                payload.activity = activityId;
                this.$store.dispatch('activity/makeActivityJoiningRequest', payload)
                    .then(
                        this.getAvailableActivitiesData
                    )
            },


            getFormatedDateString(dateString) {
                let dateStringToReturn = '';
                if( (dateString !== null) && (dateString !== '') )
                {
                    dateStringToReturn =  moment(dateString).format('Do MMMM YYYY')
                }
                return dateStringToReturn;
            },
            getFormatedDateTimeString(dateString) {
                let dateTimeStringToReturn = '';
                if( (dateString !== null) && (dateString !== '') )
                {
                    dateTimeStringToReturn =  moment(dateString).format('HH:mm')
                }
                return dateTimeStringToReturn;
            }

        },
        mounted() {
            this.getAvailableActivitiesData();
        },
    }

</script>
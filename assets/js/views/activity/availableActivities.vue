<style scoped>


</style>

<template>

    <div>

        <div class="w3-card w3-round w3-white w3-padding-32">
            <h1>Activité disponibles</h1>
        </div>

        <div class="w3-card w3-round w3-white w3-padding-32 w3-margin-top w3-container">
            <vue-good-table
                    :columns="header"
                    :rows="transformedAvailableActivities"
                    :rtl="true"
                    :search-options="{
                        enabled: true,
                        trigger: 'enter',
                        skipDiacritics: true,
                        placeholder: 'Rechercher',
                  }">
                >
                <template slot="table-row" slot-scope="props">

                    <span v-if="props.column.field == 'after'">

                        <button v-if="((!props.row.relatedRequest) && (!props.row.isJoinableByAnyone))" class="w3-button w3-black w3-small" :disabled="activityJoiningRequestLoading" @click="makeJoiningRequest(props.row['@id'])">Demander pour rejoindre</button>
                        <button v-if="((!props.row.relatedRequest) && (props.row.isJoinableByAnyone))" class="w3-button w3-green w3-small" :disabled="activityJoiningRequestLoading" @click="makeJoiningRequest(props.row['@id'])">Rejoindre</button>
                        <button v-if="(props.row.relatedRequest)" class="w3-button w3-grey w3-small"  disabled>En attente d'admission</button>

                    </span>

                    <span v-else-if="props.column.field == 'location'">

                        {{props.row.location.label}} - {{props.row.location.city}}

                    </span>

                    <div v-else-if="props.column.field == 'material'">
                        <ul v-if="(props.row.material.length > 0)" class="w3-ul w3-small">
                            <li v-for="material in props.row.material" :key="material.id" >{{material.label}}</li>
                        </ul>
                    </div>

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

    export default {
        name: 'available-activities',
        data() {
            return {
                header: [
                    {
                        label: 'Actions',
                        field: 'after',
                        html: true,
                        filterable: false,
                        globalSearchDisabled: true,
                    },
                    {
                        label: 'Commence à',
                        field: 'startAt',
                        filterable: true,
                        type: 'date',
                        dateInputFormat: 'YYYY-MM-DD', // expects 2018-03-16
                        dateOutputFormat:  'DD/MM/YYYY hh:mm',
                    },
                    {
                        label: 'Lieu',
                        field: 'location',
                        filterable: true,
                    },
                    {
                        label: 'Matériel',
                        field: 'material',
                        filterable: true,
                    },
                    {
                        label: 'Sport',
                        field: 'sport.label',
                        filterable: true,
                    },
                    {
                        label: 'Libellé',
                        field: 'label',
                        filterable: true,
                    },
                ],

            }
        },
        computed: {

            ...mapGetters({
                availableActivities : 'activity/availableActivities',
                activityJoiningRequestLoading : 'activity/activityJoiningRequestLoading'
            }),

            transformedAvailableActivities() {
                let arrayTransformed;
                arrayTransformed =  this.availableActivities.map(function(e){
                    e.activity['relatedRequest'] =  e['relatedRequest'];
                    return e.activity;
                })
                return arrayTransformed;
            }

        },
        methods: {
            getAvailableActivitiesData() {
                this.$store.dispatch('activity/getAvailableActivities')
            },

            makeJoiningRequest (activityId) {
                let payload = {};
                payload.activity = activityId;
                this.$store.dispatch('activity/makeActivityJoiningRequest', payload)
                    .then(
                        this.getAvailableActivitiesData
                    )
            }
        },
        mounted() {
            this.getAvailableActivitiesData();
        },
    }

</script>
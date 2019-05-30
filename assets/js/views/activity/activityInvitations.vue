<style scoped>

</style>

<template>

    <div>

        <div class="w3-card w3-round w3-white w3-padding-32 w3-hide-small">
            <h3>Invitations</h3>
        </div>

        <div class="w3-card w3-round w3-white w3-padding-32 w3-margin-top w3-container">

            <vue-good-table
                    :columns="header"
                    :rows="activityInvitations"
                    :search-options="{
                        enabled: true,
                        trigger: 'enter',
                        skipDiacritics: true,
                        placeholder: 'Rechercher',
                  }">
                >
                <template slot="table-row" slot-scope="props">

                    <div v-if="props.column.field == 'after'">
                        <div class="w3-bar">
                            <button  class="w3-button w3-green w3-small answer-btn" :disabled="activityInvitationAnswerLoading" @click="answerToInvitation(props.row.id, true)">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                <span class="w3-hide-small w3-hide-medium"> Accepter</span>
                            </button>
                            <button class="w3-button w3-red w3-small answer-btn" :disabled="activityInvitationAnswerLoading" @click="answerToInvitation(props.row.id, false)">
                                <i class="fa fa-times" aria-hidden="true"></i>
                                <span class="w3-hide-small w3-hide-medium"> Décliner</span>
                            </button>
                        </div>
                        <!--<button v-if="(props.row.relatedRequest)" class="w3-button w3-grey w3-small"  disabled>En attente d'admission</button>-->

                    </div>

                    <div v-else-if="props.column.field == 'activity.material'">
                        <ul v-if="(props.row.activity.material.length > 0)" class="w3-ul w3-small">
                            <li v-for="material in props.row.activity.material" :key="material.id" >{{material.label}}</li>
                        </ul>
                    </div>

                    <span v-else-if="props.column.field == 'activity.startAt'">
                        {{getFormatedDateString(props.row.activity.startAt)}} {{getFormatedDateTimeString(props.row.activity.startAt)}}
                    </span>

                    <span v-else-if="props.column.field == 'activity.location'">
                         <span v-if="!!props.row.activity.location">
                            {{props.row.activity.location.label}} - {{props.row.activity.location.city}}
                         </span>
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
        name: 'activity-invitation',
        data() {
            return {
                header: [
                    {
                        label: 'Auteur',
                        field: 'createdBy.username',
                        filterable: true,
                        thClass: 'w3-hide-small w3-hide-medium',
                        tdClass: 'w3-hide-small w3-hide-medium',
                    },
                    {
                        label: 'Libellé',
                        field: 'activity.label',
                        filterable: true,
                    },
                    {
                        label: 'Sport',
                        field: 'activity.sport.label',
                        filterable: true,
                        thClass: 'w3-hide-small w3-hide-medium',
                        tdClass: 'w3-hide-small w3-hide-medium',
                    },
                    {
                        label: 'Matériel',
                        field: 'activity.material',
                        filterable: true,
                        thClass: 'w3-hide-small w3-hide-medium',
                        tdClass: 'w3-hide-small w3-hide-medium',
                    },
                    {
                        label: 'Lieu',
                        field: 'activity.location',
                        filterable: true,
                        thClass: 'w3-hide-small',
                        tdClass: 'w3-hide-small',
                    },
                    {
                        label: 'Début',
                        field: 'activity.startAt',
                        filterable: true,
                    },
                    {
                        label: 'Réponse',
                        field: 'after',
                        html: true,
                        filterable: false,
                        globalSearchDisabled: true,
                    },
                ],
            }
        },
        computed: {

            ...mapGetters({
                activityInvitations : 'activity/activityInvitations',
                activityInvitationAnswerLoading : 'activity/activityInvitationAnswerLoading'
            }),

        },
        methods: {
            getActivityInvitationsData() {
                this.$store.dispatch('activity/getActivityInvitations')
            },
            answerToInvitation (invitationId, isAccepted) {
                let payload = {
                    'id' : invitationId,
                    'isAccepted' : isAccepted
                };
                this.$store.dispatch('activity/answerActivityInvitation', payload)
                    .then(
                        this.getActivityInvitationsData
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
            this.getActivityInvitationsData();
        },
    }

</script>
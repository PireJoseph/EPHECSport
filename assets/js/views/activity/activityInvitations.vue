<style scoped>
    .answer-btn {
        width: 80px;
    }
</style>

<template>

    <div>

        <div class="w3-card w3-round w3-white w3-padding-32">
            <h1>Invitations</h1>
        </div>

        <div class="w3-card w3-round w3-white w3-padding-32 w3-margin-top w3-container">
            <vue-good-table
                    :columns="header"
                    :rows="activityInvitations"
                    :rtl="true"
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
                            <button  class="w3-button w3-green w3-small answer-btn" :disabled="activityInvitationAnswerLoading" @click="answerToInvitation(props.row.id, true)">Accepter</button>
                            <button class="w3-button w3-red w3-small answer-btn" :disabled="activityInvitationAnswerLoading" @click="answerToInvitation(props.row.id, false)">Décliner</button>
                        </div>
                        <!--<button v-if="(props.row.relatedRequest)" class="w3-button w3-grey w3-small"  disabled>En attente d'admission</button>-->

                    </div>

                    <div v-else-if="props.column.field == 'activity.material'">
                        <ul v-if="(props.row.activity.material.length > 0)" class="w3-ul w3-small">
                            <li v-for="material in props.row.activity.material" :key="material.id" >{{material.label}}</li>
                        </ul>
                    </div>

                    <span v-else-if="props.column.field == 'activity.location'">

                        {{props.row.activity.location.label}} - {{props.row.activity.location.city}}

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

    export default {
        name: 'activity-invitation',
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
                        field: 'activity.startAt',
                        filterable: true,
                        type: 'date',
                        dateInputFormat: 'YYYY-MM-DD', // expects 2018-03-16
                        dateOutputFormat:  'DD/MM/YYYY hh:mm',
                    },
                    {
                        label: 'Lieu',
                        field: 'activity.location',
                        filterable: true,
                    },
                    {
                        label: 'Matériel',
                        field: 'activity.material',
                        filterable: true,
                    },
                    {
                        label: 'Sport',
                        field: 'activity.sport.label',
                        filterable: true,
                    },
                    {
                        label: 'Libellé',
                        field: 'activity.label',
                        filterable: true,
                    },
                    {
                        label: 'Lancée par',
                        field: 'createdBy.username',
                        filterable: true,
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
            }
        },
        mounted() {
            this.getActivityInvitationsData();
        },
    }

</script>
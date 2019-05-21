<style scoped>

    .answer-btn {
        width: 80px;
    }

    .formInputContainer {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    input:not([type=checkbox]), textarea{
        width: 100%!important;
        border: none;
        border-bottom: 2px solid lightgray;
    }

    input {
        text-align: right;
        align-self: flex-end;

    }
    textarea:focus {
        text-align: left;
    }
    textarea {
        text-align: right;
    }

    .formInputErrors {
        margin-top: 5px;
        width: 100%;
    }

    .formInputLabel {
        text-align: left;
        align-self: normal;
        color: grey;
        margin-bottom: 5px;
    }

    .formInputContainer{
        min-height: 50px;
    }

</style>

<template>

    <div>

        <div class="w3-card w3-round w3-white w3-padding-32 w3-hide-small">
            <h3>Participations</h3>
        </div>

        <div class="w3-card w3-round w3-white w3-padding-32 w3-margin-top w3-container">
            <vue-good-table
                    :columns="header"
                    :rows="activityParticipations"
                    :rtl="true"
                    :search-options="{
                        enabled: true,
                        trigger: 'enter',
                        skipDiacritics: true,
                        placeholder: 'Rechercher',
                  }">
                >
                <template slot="table-row" slot-scope="props">

                    <div v-if="props.column.field == 'after'" class="w3-bar">

                            <!--Confirmation Btn-->
                            <button
                                    v-if="( (!props.row.cancellation) && (!props.row.participation.isConfirmed) )"
                                    class="w3-button w3-green w3-small answer-btn"
                                    @click="confirmParticipation(props.row.participation)"
                                    :disabled="activityParticipationConfirmationLoading"
                            >
                                Confirmer
                            </button>
                            <button
                                    v-else-if="( (!props.row.cancellation) && (props.row.participation.isConfirmed) )"
                                    class="w3-button w3-green w3-small answer-btn"
                                    disabled
                            >
                                Confirmée
                            </button>


                            <!--Cancellation Btn-->
                            <button
                                    v-if="( (!props.row.cancellation) )"
                                    class="w3-button w3-red w3-small answer-btn"
                                    @click="openActivityCancellationModal(props.row.participation.activity)"
                                    :disabled="activityCancellationLoading"
                            >
                                Annuler
                            </button>
                            <button
                                    v-else
                                    class="w3-button w3-red w3-small answer-btn"
                                    disabled
                            >
                                Annulée
                            </button>


                    </div>

                    <div v-else-if="props.column.field == 'participation.activity.material'">
                        <ul v-if="(props.row.participation.activity.material.length > 0)" class="w3-ul w3-small">
                            <li v-for="material in props.row.participation.activity.material" :key="material.id" >{{material.label}}</li>
                        </ul>
                    </div>

                    <div v-else-if="props.column.field == 'participation.activity.location'">

                        {{props.row.participation.activity.location.label}} - {{props.row.participation.activity.location.city}}

                    </div>

                    <div v-else>

                        {{props.formattedRow[props.column.field]}}

                    </div>

                </template>
                <div slot="emptystate">
                    Pas de résultats
                </div>

            </vue-good-table>
        </div>


        <!--Cancellation Modal-->
        <div id="cancellationModal" class="w3-modal" style="display: block;" v-show="isActivityCancellationModalOpen">
            <div class="w3-modal-content w3-animate-opacity">

                <header class="w3-container w3-theme-d1">
                    <span @click="closeActivityCancellationModal" class="w3-button w3-display-topright">&times;</span>
                    <h4>Annulation de participation</h4>
                </header>

                <div class="w3-container">
                    <form action="#">

                        <div class="formInputContainer w3-center w3-margin ">
                            <label class="formInputLabel" for="cancellationMotivationInput">Motif d'annulation :</label>
                            <textarea
                                    id="cancellationMotivationInput"
                                    name="cancellationMotivationInput"
                                    v-model="cancellation.cancellationMotivation"
                                    v-validate="'max:2048|min:1|required'"
                                    maxlength="2048"
                                    data-vv-validate-on=""
                                    rows="5"
                            >
                        </textarea>
                        <span v-show="!!errors.first('cancellationMotivationInput')" class="w3-tag w3-tiny w3-padding w3-red formInputErrors" >{{ errors.first('cancellationMotivationInput') }}</span>

                        </div>

                    </form>
                </div>

                <footer class="w3-container w3-theme-d1 w3-padding">
                    <button type="button" class="w3-button w3-red" @click="closeActivityCancellationModal" :disabled="activityCancellationLoading">Fermer</button>
                    <button type="button" class="w3-button w3-green" @click="postActivityCancellation" >Poster Annulation</button>
                </footer>

            </div>
        </div>


    </div>



</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: 'activity-participations',
        data() {
            return {
                isActivityCancellationModalOpen: false,
                cancellation: {
                    'activity': '',
                    'cancellationMotivation': '',
                    'createdAt': ''
                },
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
                        field: 'participation.activity.startAt',
                        filterable: true,
                        type: 'date',
                        dateInputFormat: 'YYYY-MM-DD', // expects 2018-03-16
                        dateOutputFormat: 'DD/MM/YYYY hh:mm',
                    },
                    {
                        label: 'Lieu',
                        field: 'participation.activity.location',
                        filterable: true,
                    },
                    {
                        label: 'Matériel',
                        field: 'participation.activity.material',
                        filterable: true,
                    },
                    {
                        label: 'Sport',
                        field: 'participation.activity.sport.label',
                        filterable: true,
                    },
                    {
                        label: 'Libellé',
                        field: 'participation.activity.label',
                        filterable: true,
                    },
                ],
                dictionary: {
                    custom: {
                        cancellationMotivationInput: {
                            max: 'Motif trop long',
                            min: 'Veuillez fournir un motif',
                            required: 'Veuillez fournir un motif'
                        },
                    }
                }
            }
        },
        computed: {

            ...mapGetters({
                activityParticipations : 'activity/activityParticipations',
                activityParticipationConfirmationLoading : 'activity/activityParticipationConfirmationLoading',
                activityCancellationLoading : 'activity/activityCancellationLoading'
            }),

        },
        methods: {
            getActivityParticipationsData() {
                this.$store.dispatch('activity/getActivityParticipations')
            },
            confirmParticipation(activityParticipation) {
                    let now = new Date();
                    let payload = {
                        'id' : activityParticipation.id,
                        'isConfirmed' : true,
                        'answeredAt' : now,
                    };
                    this.$store.dispatch('activity/confirmActivityParticipation', payload)
                        .then(
                            this.getActivityParticipationsData
                        )
            },
            openActivityCancellationModal(activity) {
                let now = new Date();
                this.cancellation = {
                    'activity' : activity['@id'],
                    'cancellationMotivation' : '',
                    'createdAt' : now
                }
                this.isActivityCancellationModalOpen = true;
            },
            closeActivityCancellationModal() {
                this.isActivityCancellationModalOpen = false;
            },
            postActivityCancellation() {
                let validation;
                validation = this.$validator.validateAll();
                validation.then(
                    (isFormValid) => {
                        if(isFormValid) {
                            this.$store.dispatch('activity/postActivityCancellation', this.cancellation)
                                .then (
                                    (success) => {
                                        this.getActivityParticipationsData();
                                        this.closeActivityCancellationModal();
                                    },
                                    (errors) => {

                                    }
                                )
                        }
                    },
                )
            }

        },
        mounted() {
            this.$validator.localize('fr', this.dictionary);
            this.getActivityParticipationsData();
        },
    }


</script>
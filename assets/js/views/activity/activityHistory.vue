<style scoped>

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

        <div class="w3-card w3-round w3-white w3-padding-32">
            <h1>Historique des activités</h1>
        </div>

        <div class="w3-card w3-round w3-white w3-padding-32 w3-margin-top w3-container">
            <vue-good-table
                    :columns="header"
                    :rows="activityHistory"
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

                        <button v-show="!isActivityFeedbackLoading" class="w3-button w3-grey w3-small" @click="loadActivityFeedback(props.row)" style="width: 85px">Feedback</button>
                        <span v-show="isActivityFeedbackLoading" class="w3-block w3-center" ><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span>

                    </span>
                    <span v-if="props.column.field == 'location'">

                        {{props.row.location.label}} - {{props.row.location.city}}

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


        <div id="notationModal" class="w3-modal" style="display: block;" v-show="modalOpen">
            <div class="w3-modal-content w3-animate-opacity">

                <header class="w3-container w3-theme-d1">
                    <span @click="closeModal" class="w3-button w3-display-topright">&times;</span>
                    <h2>Feedback {{activitySelectedLabel}}</h2>
                </header>

                <div class="w3-container">
                    <form action="#">

                        <div class="formInputContainer w3-center w3-margin ">
                            <label class="formInputLabel" for="ratingInput">Notation :</label>
                            <input type="number"
                                   id="ratingInput"
                                   name="ratingInput"
                                   v-model="activityFeedbackForm.activityRatingOutOfFive"
                                   min="0"
                                   max="5"
                                   required
                            />
                        </div>

                        <div class="formInputContainer w3-center w3-margin ">
                            <label class="formInputLabel">Libellé :</label>
                            <v-select
                                    @input="changeLabelSelect"
                                    :options="labelSelectArray"
                                    :value="activityFeedbackFormLabel"
                                    :clearable="false"
                                    :multiple="false"
                                    label="label"
                            ></v-select>
                        </div>

                        <div class="formInputContainer w3-center w3-margin ">
                            <label class="formInputLabel" for="commentInput">Commentaire :</label>
                            <textarea
                                    id="commentInput"
                                    name="commentInput"
                                    v-model="activityFeedbackForm.comment"
                                    rows="5"
                            >
                            </textarea>
                        </div>


                    </form>
                </div>

                <footer class="w3-container w3-theme-d1 w3-padding">
                    <button type="button" class="w3-button w3-red" @click="closeModal" >Fermer</button>
                    <button type="button" class="w3-button w3-green" @click="submit" >Poster feedback</button>
                </footer>

            </div>
        </div>

    </div>

</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: 'activity-history',
        data() {
            return {
                modalOpen : false,
                selectedActivity : null,
                activityFeedbackForm : {
                    activityRatingOutOfFive : 0,
                    label : 'ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_NOTHING',
                    comment: ''
                },
                labelSelectArray : [
                    {
                        value: 'ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_NOTHING',
                        label : 'Rien à dire'
                    },
                    {
                        value: 'ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_BORING',
                        label : 'Ennuyeux'
                    },
                    {
                        value: 'ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_EASY',
                        label : 'Facile',
                    },
                    {
                        value: 'ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_FUN',
                        label : 'Fun',
                    },
                    {
                        value: 'ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_EPIC',
                        label : 'Epique',
                    },
                    {
                        value: 'ACTIVITY_RELATED_FEEDBACK_LABEL_TOKEN_CHALLENGING',
                        label : 'Challenging',
                    },
                ],
                header: [
                    {
                        label: 'Actions',
                        field: 'after',
                        html: true,
                        filterable: false,
                        globalSearchDisabled: true,
                    },
                    {
                        label: 'Terminée à',
                        field: 'endAt',
                        filterable: true,
                        type: 'date',
                        dateInputFormat: 'YYYY-MM-DD', // expects 2018-03-16
                        dateOutputFormat:  'Do/MMM/YYYY hh:mm',
                    },
                    {
                        label: 'Lieu',
                        field: 'location',
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
            activitySelectedLabel() {
              if (this.selectedActivity){
                  return this.selectedActivity.label
              }
              return '';
            },
            activityFeedbackFormLabel(){
                let labelToReturn = 'Rien à dire'
                let selectedValue = this.activityFeedbackForm.label;
                let selectedObject = this.labelSelectArray.filter( labelObject => (labelObject.value === selectedValue));
                if(selectedObject.length > 0){
                    labelToReturn =  selectedObject[0].label;
                }
                return labelToReturn
            },
            ...mapGetters({
                activityHistory: 'activity/activityHistory',
                isActivityFeedbackLoading: 'activity/isActivityHistoryFeedbackLoading',
                activityFeedbackLoadingError: 'activity/activityHistoryFeedbackLoadingError',
                activityFeedback: 'activity/activityHistoryFeedback',
                userId: 'user/userId'
            })

        },
        methods: {

            getActivityHistoryData() {
                this.$store.dispatch('activity/getActivityHistory')
            },

            loadActivityFeedback (activity) {
                this.selectedActivity = activity;
                this.$store.dispatch('activity/getActivityHistoryFeedback', activity['id'])
                    .then(()=> {
                        this.initForm(this.activityFeedback);
                        this.modalOpen = true;
                    })
            },
            initForm(activityFeedback){
                let label = 'ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_NOTHING', activityRatingOutOfFive = 0, comment = '';
                if(!!activityFeedback)
                {
                    label = activityFeedback.label;
                    activityRatingOutOfFive = activityFeedback.activityRatingOutOfFive;
                    comment = activityFeedback.comment;
                }
              this.activityFeedbackForm.label = label;
              this.activityFeedbackForm.activityRatingOutOfFive = activityRatingOutOfFive;
              this.activityFeedbackForm.comment = comment;
            },
            closeModal()
            {
                this.initForm();
                this.modalOpen = false;
            },
            changeLabelSelect(val) {
                this.activityFeedbackForm.label = val.value;
            },

            submit() {
              if (!!this.activityFeedback){
                  this.putActivityRelatedFeedback(this.activityFeedback['@id'].split('/').pop())
              } else {
                  this.postActivityRelatedFeedback();
              }
            },

            postActivityRelatedFeedback () {
                this.activityFeedbackForm.activityRatingOutOfFive = parseInt( this.activityFeedbackForm.activityRatingOutOfFive)
                let payload = this.activityFeedbackForm;
                payload.activity = this.selectedActivity['@id']
                payload.author = this.userId
                console.log('post activity related feedback')
                console.log(payload)
                this.$store.dispatch('activity/postActivityHistoryFeedback', payload)
                .then(() => {
                   this.closeModal();
                })
            },
            putActivityRelatedFeedback (id) {
                this.activityFeedbackForm.activityRatingOutOfFive = parseInt( this.activityFeedbackForm.activityRatingOutOfFive)
                let payload = this.activityFeedbackForm;
                payload.activityRelatedFeedbackId = id;
                console.log(payload)
                this.$store.dispatch('activity/putActivityHistoryFeedback', payload)
                .then(() => {
                    this.closeModal();
                })
            }
        },
        mounted() {
            this.getActivityHistoryData()
        },
    }
</script>
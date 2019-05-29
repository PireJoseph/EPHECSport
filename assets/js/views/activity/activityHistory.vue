<style scoped>


</style>

<template>

    <div>

        <div class="w3-card w3-round w3-white w3-padding-32 w3-hide-small">
            <h3>Historique des activités</h3>
        </div>

        <div class="w3-card w3-round w3-white w3-padding-32 w3-margin-top w3-container">

            <vue-good-table
                    :columns="header"
                    :rows="activityHistory"
                    :search-options="{
                        enabled: true,
                        trigger: 'enter',
                        skipDiacritics: true,
                        placeholder: 'Rechercher',
                  }">
                >
                <template slot="table-row" slot-scope="props">

                    <span v-if="props.column.field == 'after'">

                        <button v-show="!isActivityFeedbackLoading" class="w3-button w3-grey w3-small w3-block" @click="loadActivityFeedback(props.row)" >
                            <i class="fa fa-bolt" aria-hidden="true"></i>
                            <span class="w3-hide-small w3-hide-medium"> Activité</span>
                        </button>
                        <span v-show="isActivityFeedbackLoading" class="w3-block w3-center w3-small" ><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span>

                        <button v-show="!userRelatedFeedbackModalLoading" class="w3-button w3-black w3-small w3-margin-top w3-block" @click="loadActivityUsers(props.row)">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            <span class="w3-hide-small w3-hide-medium"> Participations</span>
                        </button>
                        <span v-show="userRelatedFeedbackModalLoading" class="w3-block w3-center w3-small w3-margin-top" ><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span>

                    </span>

                    <span v-else-if="props.column.field == 'location'">
                        <span v-if="!!props.row.location">
                            {{props.row.location.label}} - {{props.row.location.city}}
                        </span>
                    </span>

                    <span v-else-if="props.column.field == 'endAt'">
                        {{getFormatedDateString(props.row.endAt)}}
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

                <header class="w3-container w3-theme-d1" style="padding: 0 40px;">
                    <span @click="closeModal" class="w3-button w3-display-topright">&times;</span>
                    <h4 >Feedback {{activitySelectedLabel}}</h4>
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



        <div id="userFeedbackModal" class="w3-modal" style="display: block;" v-show="userFeedbackModalOpen">
            <div class="w3-modal-content w3-animate-opacity">

                <header class="w3-container w3-theme-d1" style="padding: 0 40px;">
                    <span @click="closeUserFeedbackModal" class="w3-button w3-display-topright">&times;</span>
                    <h4>Feedback participations à : {{selectedActivityForUserFeedbackLabel}}</h4>
                </header>

                <div class="w3-container">
                    <form action="#" v-show="(userFeedbackUserSelectArray.length > 1)">

                        <div class="formInputContainer w3-center w3-margin ">
                            <label class="formInputLabel">Participant :</label>
                            <v-select
                                    @input="changeUserFeedbackUserSelect"
                                    :options="userFeedbackUserSelectArray"
                                    :value="userFeedbackUserSelectValue"
                                    :clearable="false"
                                    :multiple="false"
                            ></v-select>
                        </div>

                        <div v-show="(!!this.selectedUserForUserFeedback && !this.existingUserFeedback)" class="w3-padding">

                            <div class="formInputContainer w3-center w3-margin ">
                                <label class="formInputLabel">Libellé :</label>
                                <v-select
                                        @input="changeUserFeedbackLabelSelect"
                                        :options="userFeedbackLabelSelectArray"
                                        :value="userFeedbackLabelSelectValue"
                                        :clearable="false"
                                        :multiple="false"
                                ></v-select>
                            </div>

                        </div>

                        <div v-show="!!this.existingUserFeedback" class="w3-block-center w3-padding">
                            <p class="w3-margin">Un feedback a déja été envoyé à ce participant pour cette activité</p>
                        </div>



                    </form>

                    <div v-show="(userFeedbackUserSelectArray.length < 2)" class="w3-block-center w3-padding-32">
                        <p class="w3-margin">Aucun participant à cette activité</p>
                    </div>

                </div>

                <footer class="w3-container w3-theme-d1 w3-padding">
                    <button type="button" class="w3-button w3-red" @click="closeUserFeedbackModal" >Fermer</button>
                    <button v-show="((!this.postUserRelatedFeedbackLoading) && (this.userFeedbackUserSelectArray.length > 1) && ((!this.existingUserFeedback && !!this.selectedUserForUserFeedback && !!this.selectedActivityForUserFeedback && !!this.userFeedbackForm.label.length)))" type="button" class="w3-button w3-green" @click="submitUserFeedback" >Poster feedback</button>
                    <span v-show="this.postUserRelatedFeedbackLoading" class="w3-center w3-small w3-margin-left" ><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></span>
                </footer>

            </div>
        </div>



    </div>

</template>

<script>
    import {mapGetters} from "vuex";
    import moment from 'moment';

    export default {
        name: 'activity-history',
        data() {
            return {
                modalOpen : false,
                userFeedbackModalOpen : false,
                selectedActivity : null,
                selectedActivityForUserFeedback : null,
                selectedActivityForUserFeedbackLabel : '',
                selectedUserForUserFeedback : null,
                selectedLabelForUserFeedback : '',
                existingUserFeedback : null,
                activityFeedbackForm : {
                    activityRatingOutOfFive : 0,
                    label : 'ACTIVITY_RELATED_FEEDBACK_LABEL_VALUE_NOTHING',
                    comment: ''
                },
                userFeedbackForm : {
                    user : '',
                    activity : '',
                    label : ''
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
                userFeedbackUserSelectArray : [
                    {
                        label : 'Choisissez...',
                        user :   null
                    }
                ],
                userFeedbackLabelSelectArray : [
                    {
                        value: 'USER_RELATED_FEEDBACK_LABEL_VALUE_NOTHING',
                        label : 'Rien à dire'
                    },
                    {
                        value: 'USER_RELATED_FEEDBACK_LABEL_VALUE_MVP',
                        label : 'Très méritant'
                    },
                    {
                        value: 'USER_RELATED_FEEDBACK_LABEL_VALUE_FAIRPLAY',
                        label : 'Fairplay'
                    },
                    {
                        value: 'USER_RELATED_FEEDBACK_LABEL_VALUE_FRIENDLY',
                        label : 'Amical'
                    },
                    {
                        value: 'USER_RELATED_FEEDBACK_LABEL_VALUE_LATE',
                        label : 'En retard'
                    },
                    {
                        value: 'USER_RELATED_FEEDBACK_LABEL_VALUE_NEGATIVE_ATTITUDE',
                        label : 'Attitude négative'
                    },
                    {
                        value: 'USER_RELATED_FEEDBACK_LABEL_VALUE_USER_MISSING',
                        label : 'Absent'
                    }
                ],
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
                        label: 'Lieu',
                        field: 'location',
                        filterable: true,
                        thClass: 'w3-hide-small',
                        tdClass: 'w3-hide-small',
                    },
                    {
                        label: 'Fin',
                        field: 'endAt',
                        filterable: true,
                    },
                    {
                        label: 'Feedback',
                        field: 'after',
                        html: true,
                        filterable: false,
                        globalSearchDisabled: true,
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
            userFeedbackUserSelectValue(){
                let labelToReturn = 'Choisissez...'
                if(!!this.selectedUserForUserFeedback)
                {
                    labelToReturn = this.selectedUserForUserFeedback.username;
                }
                return labelToReturn;
            },
            userRelatedFeedbackModalLoading(){
                return (this.activityParticipationsForAnActivityLoading || this.userRelatedFeedbacksForAnActivityLoading)
            },
            userFeedbackLabelSelectValue () {
                let labelToReturn = this.userFeedbackLabelSelectArray[0].label;
                if(this.selectedLabelForUserFeedback.length > 0)
                {
                    labelToReturn =  this.selectedLabelForUserFeedback;
                }
                return labelToReturn;
            },

            ...mapGetters({
                activityHistory: 'activity/activityHistory',
                isActivityFeedbackLoading: 'activity/isActivityHistoryFeedbackLoading',
                activityFeedbackLoadingError: 'activity/activityHistoryFeedbackLoadingError',
                activityFeedback: 'activity/activityHistoryFeedback',
                userId: 'user/userId',
                activityParticipationsForAnActivity: 'activity/activityParticipationsForAnActivity',
                activityParticipationsForAnActivityLoading : 'activity/activityParticipationsForAnActivityLoading',
                userRelatedFeedbacksForAnActivity :  'activity/userRelatedFeedbacksForAnActivity',
                userRelatedFeedbacksForAnActivityLoading: 'activity/userRelatedFeedbacksForAnActivityLoading',
                postUserRelatedFeedbackLoading : 'activity/postUserRelatedFeedbackLoading'

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
            loadActivityUsers(activity) {
                this.selectedActivityForUserFeedback = activity;
                this.selectedActivityForUserFeedbackLabel = activity.label;
                this.userFeedbackForm.activity = activity['@id'];
                this.$store.dispatch('activity/getActivityParticipationsForAnActivity', activity['id'] )
                    .then(()=>{
                       this.initUserSelect();
                       this.$store.dispatch('activity/getUserRelatedFeedbackForAnActivity', this.selectedActivityForUserFeedback.id)
                           .then(()=>{
                               this.userFeedbackModalOpen = true;
                           })
                    });
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
            initUserSelect()
            {
                let userSelectArray = [
                    {
                        label : 'Choisissez...',
                        user : null

                    }
                ];
                this.activityParticipationsForAnActivity.map((activityParticipation)=>{
                    userSelectArray.push({
                        label : activityParticipation.user.username,
                        user : activityParticipation.user
                    })
                });
                this.userFeedbackUserSelectArray = userSelectArray;
            },
            initUserFeedbackForm(){
                this.selectedLabelForUserFeedback = '';
                this.selectedUserForUserFeedback = null;
                this.userFeedbackForm = {
                    user : '',
                    activity : '',
                    label : this.userFeedbackLabelSelectArray[0].label
                }
            },

            closeModal()
            {
                this.initForm();
                this.modalOpen = false;
            },
            closeUserFeedbackModal()
            {
                this.initUserFeedbackForm();
                this.userFeedbackModalOpen = false;

            },

            changeLabelSelect(val) {
                this.activityFeedbackForm.label = val.value;
            },
            changeUserFeedbackUserSelect(val)
            {
                this.selectedUserForUserFeedback = val.user;
                this.selectedLabelForUserFeedback = '';
                this.userFeedbackForm.label = this.userFeedbackLabelSelectArray[0].value;

                let correspondingUserFeedback = null;
                if (!!this.selectedUserForUserFeedback)
                {
                    this.userFeedbackForm.user = val.user['@id'];
                    let filteredUserFeedback;
                    filteredUserFeedback = this.userRelatedFeedbacksForAnActivity.filter((userRelatedFeedback)=>{
                        return (userRelatedFeedback.user.id ===  this.selectedUserForUserFeedback.id)
                    });
                    if(filteredUserFeedback.length > 0){
                        correspondingUserFeedback = filteredUserFeedback[0];
                    }

                }
                this.existingUserFeedback = correspondingUserFeedback;

            },
            changeUserFeedbackLabelSelect(val)
            {
                this.selectedLabelForUserFeedback = val.label;
                this.userFeedbackForm.label = val.value;
            },

            submit() {
              if (!!this.activityFeedback){
                  this.putActivityRelatedFeedback(this.activityFeedback['@id'].split('/').pop())
              } else {
                  this.postActivityRelatedFeedback();
              }
            },

            submitUserFeedback() {
                this.$store.dispatch('activity/postUserRelatedFeedback', this.userFeedbackForm)
                    .then((res)=>{
                        this.closeUserFeedbackModal();
                    })
            },

            postActivityRelatedFeedback () {
                this.activityFeedbackForm.activityRatingOutOfFive = parseInt( this.activityFeedbackForm.activityRatingOutOfFive)
                let payload = this.activityFeedbackForm;
                payload.activity = this.selectedActivity['@id']
                payload.author = this.userId
                this.$store.dispatch('activity/postActivityHistoryFeedback', payload)
                .then(() => {
                   this.closeModal();
                })
            },
            putActivityRelatedFeedback (id) {
                this.activityFeedbackForm.activityRatingOutOfFive = parseInt( this.activityFeedbackForm.activityRatingOutOfFive)
                let payload = this.activityFeedbackForm;
                payload.activityRelatedFeedbackId = id;
                this.$store.dispatch('activity/putActivityHistoryFeedback', payload)
                .then(() => {
                    this.closeModal();
                })
            },

            getFormatedDateString(dateString) {
                let dateStringToReturn = '';
                if( (dateString !== null) && (dateString !== '') )
                {
                    dateStringToReturn =  moment(dateString).format('Do MMMM YYYY')
                }
                return dateStringToReturn;
            }

        },
        mounted() {
            this.getActivityHistoryData()
        },
    }
</script>
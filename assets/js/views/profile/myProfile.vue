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

    <!--<v-container  >-->
    <div>

        <div class="w3-card w3-round w3-white w3-padding-32">
            <h1 style="margin-top: 0"> Mon profil </h1>
        </div>

        <form
            action="#"
        >

            <fieldset class="w3-container w3-card w3-round w3-white w3-padding-32 w3-margin-top">

                <h4>Compte</h4>

                <div class="formInputContainer w3-center w3-margin ">
                    <label class="formInputLabel" for="newPasswordInput">Nouveau mot de passe :</label>
                    <input type="password"
                           id="newPasswordInput"
                           name="newPasswordInput"
                           v-model="formNewPassword"
                           v-validate="'min:8|max:32'"

                    />
                    <span v-show="!!errors.first('newPasswordInput')" class="w3-tag w3-tiny w3-padding w3-red formInputErrors" >{{ errors.first('newPasswordInput') }}</span>
                </div>

                <div class="formInputContainer w3-center w3-margin ">
                    <label class="formInputLabel" for="areSuccessUnlockedVisibleInput">Succès visibles :</label>
                    <input type="checkbox"
                           id="areSuccessUnlockedVisibleInput"
                           name="areSuccessUnlockedVisibleInput"
                           v-model="formAreSuccessUnlockedVisible"
                    />
                </div>

                <div class="formInputContainer w3-center w3-margin ">
                    <label class="formInputLabel" for="areActivityParticipationVisibleInput">Participations visibles :</label>
                    <input type="checkbox"
                           id="areActivityParticipationVisibleInput"
                           name="areActivityParticipationVisibleInput"
                           v-model="formAreActivityParticipationVisible"
                    />
                </div>

                <div class="formInputContainer w3-center w3-margin ">
                    <label class="formInputLabel" for="isPersonalProfileVisibleInput">Profil  visible :</label>
                    <input type="checkbox"
                           id="isPersonalProfileVisibleInput"
                           name="isPersonalProfileVisibleInput"
                           v-model="formIsPersonalProfileVisible"
                    />
                </div>

                <div class="formInputContainer w3-center w3-margin ">
                    <label class="formInputLabel">Photo de profil :</label>
                    <vue-dropzone ref="myDropzoneProfilePicture" id="dropzoneProfilePicture" :options="dropzoneProfilePictureOptions" :useCustomSlot=true>
                        <div class="dropzone-custom-content">
                            <div class="subtitle">Cliquez ou déposez </div>
                        </div>
                    </vue-dropzone>
                </div>


                <div class="formInputContainer w3-center w3-margin ">
                    <label class="formInputLabel" >Autres photos :</label>
                    <vue-dropzone ref="myDropzonePictures" id="dropzonePictures" :options="dropzonePicturesOptions" :useCustomSlot=true>
                        <div class="dropzone-custom-content">
                            <div class="subtitle">Cliquez ou déposez</div>
                        </div>
                    </vue-dropzone>
                </div>


            </fieldset>


            <br />


            <fieldset class="w3-container w3-card w3-round w3-white w3-padding-32 w3-margin-top">

                <h4>Contact</h4>

                <div class="formInputContainer w3-center w3-margin ">
                    <label class="formInputLabel" for="descriptionInput">Description :</label>
                    <textarea
                           id="descriptionInput"
                           name="descriptionInput"
                           v-model="formDescription"
                           v-validate="'max:1024'"
                           rows="5"
                           data-vv-validate-on=""
                    >
                    </textarea>
                    <span v-show="!!errors.first('descriptionInput')" class="w3-tag w3-tiny w3-padding w3-red formInputErrors" >{{ errors.first('emailInput') }}</span>
                </div>

                <div class="formInputContainer w3-center w3-margin ">
                    <label class="formInputLabel" for="emailInput">Addresse mail :</label>
                    <input type="email"
                           id="emailInput"
                           name="emailInput"
                           v-model="formEmail"
                           v-validate="'required'"
                            required
                    />
                    <span v-show="!!errors.first('emailInput')" class="w3-tag w3-tiny w3-padding w3-red formInputErrors" >{{ errors.first('emailInput') }}</span>
                </div>

                <div class="formInputContainer w3-center w3-margin ">
                    <label class="formInputLabel" for="phoneNumberInput">Numéro de téléphone :</label>
                    <input type="text"
                           id="phoneNumberInput"
                           name="phoneNumberInput"
                           v-model="formPhoneNumber"
                    />
                </div>


            </fieldset>


            <br />


            <fieldset class="w3-container w3-card w3-round w3-white w3-padding-32 w3-margin-top">
                <h4>Données personnelles</h4>

                <div class="formInputContainer w3-center w3-margin ">
                    <label class="formInputLabel">Genre :</label>
                    <v-select
                            :options="gendersFormSelectArray"
                            v-model="formGender"
                            :reduce="option => option.value"
                            :clearable="false"
                            :multiple="false"
                            label="label"
                    ></v-select>
                </div>

                <div class="formInputContainer w3-center w3-margin ">
                    <label class="formInputLabel">Date de naissance :</label>
                    <vuejs-datepicker
                            :language="translationDatePickerFr"
                            :input-class="'date-picker-input'"
                            v-model="formBirthDate"
                    ></vuejs-datepicker>

                </div>

            </fieldset>

            <br />

            <fieldset class="w3-container w3-card w3-round w3-white w3-padding-32 w3-margin-top">
                <h4>Activités</h4>

                <div class="formInputContainer w3-center w3-margin ">
                    <label class="formInputLabel" for="canGoAwayInput">Peut se déplacer :</label>
                    <input type="checkbox"
                           id="canGoAwayInput"
                           name="canGoAwayInput"
                           v-model="formCanGoAway"
                    />
                </div>

                <div class="formInputContainer w3-center w3-margin ">
                    <label class="formInputLabel">Disponibilités :</label>
                    <v-select
                            :options="disponibilityPatternsArray"
                            v-model="formDisponibilityPatterns"
                            multiple
                            label="label"
                    ></v-select>
                </div>


                <div class="formInputContainer w3-center w3-margin ">
                    <label class="formInputLabel" for="activityCostLimitInput">Limite de coût par activité :</label>
                    <input type="number"
                           id="activityCostLimitInput"
                           name="activityCostLimitInput"
                           v-model="formActivityCostLimit"
                           v-validate="'min:0'"
                           min="0"
                           required
                    />
                    <span v-show="!!errors.first('activityCostLimitInput')" class="w3-tag w3-tiny w3-padding w3-red formInputErrors" >{{ errors.first('usernameInput') }}</span>
                </div>


            </fieldset>

            <br />


            <fieldset class="w3-container w3-card w3-round w3-white w3-padding-32 w3-margin-top">
                <button type="button" class="w3-button w3-red" @click="clear" >Réinitialiser</button>
                <button type="button" class="w3-button w3-green"  @click="submit" >Soumettre</button>
            </fieldset>

        </form>

    </div>


</template>

<script>
    import {mapGetters, mapMutations, mapState} from "vuex";
    import vue2Dropzone from 'vue2-dropzone'
    import {fr} from 'vuejs-datepicker/dist/locale'

    export default {
        name: 'my-profile',
        components: {
            vueDropzone: vue2Dropzone
        },
        data() {
            return {
                // errors : [],
                formValid : false,
                formNewPassword : String,
                formAreSuccessUnlockedVisible: Boolean,
                formAreActivityParticipationVisible : Boolean,
                formIsPersonalProfileVisible : Boolean,
                formProfilePicture : File,

                formDescription: String,
                formEmail : String,
                formPhoneNumber : String,

                formGender : 'M',
                formBirthDate : null,
                formPictures : Array,
                formPictureFiles : '',
                formSchoolClass : String,

                formCanGoAway : Boolean,
                formActivityCostLimit : null,
                formPreferredPartners : Array,
                formDisponibilityPatterns : [],


                userRelatedFeedback : Array,
                userSuccess : Array,

                formProfilePictureFile : String,

                disponibilityPatternsArray : [
                    {
                        value: 'AFTERNOON',
                        label : 'Soirée'
                    },
                    {
                        value: 'WEEKEND',
                        label : 'Weekend'
                    },
                    {
                        value: 'SUMMER_HOLYDAY',
                        label : 'Vacances d\'été',
                    },
                ],
                gendersFormSelectArray : [
                    {
                        value: 'M',
                        label : 'Homme'
                    },
                    {
                        value: 'F',
                        label : 'Femme'
                    }
                ],
                translationDatePickerFr: fr,
                // dictionary : Object
                dictionary: {
                    attributes: {
                    },
                    custom: {
                        usernameInput: {
                            required: 'Nom d\'utilisateur requis',
                            max: 'Nom d\'utilisateur trop long',
                            min: 'Nom d\'utilisateur trop petit',
                        },
                        newPasswordInput : {
                            max: 'Nouveau mot de passe trop long',
                            min: 'Nouveau mot de passe trop petit',
                        },
                        descriptionInput : {
                            max: 'Descirption trop longue'
                        },
                        emailInput : {
                            email: 'Email non valide',
                            required : 'Email requis'
                        },
                        activityCostLimitInput : {
                            min: 'Nombre négatifs non autorisés',
                        }

                    }
                },

                dropzoneProfilePictureOptions: {
                    url: 'https://httpbin.org/post',
                    thumbnailWidth: 150,
                    maxFilesize: 0.5,
                    addRemoveLinks: true,
                    headers: { "My-Awesome-Header": "header value" }
                },
                dropzonePicturesOptions: {
                    url: 'https://httpbin.org/post',
                    thumbnailWidth: 150,
                    maxFilesize: 0.5,
                    addRemoveLinks: true,
                    headers: { "My-Awesome-Header": "header value" }
                },

            }
        },
        computed: {

        },
        methods: {

            initProfileData () {
                this.formNewPassword = ''

                this.formAreSuccessUnlockedVisible = this.$store.state.user.areSuccessUnlockedVisible
                this.formAreActivityParticipationVisible = this.$store.state.user.areActivityParticipationVisible
                this.formIsPersonalProfileVisible = this.$store.state.user.isPersonalProfileVisible

                this.formProfilePicture = this.$store.state.user.userPicture

                this.formDescription = this.$store.state.user.userDescription
                this.formEmail = this.$store.state.user.userMail
                this.formPhoneNumber = this.$store.state.user.userPhoneNumber

                this.formGender = this.$store.state.user.userGender

                this.formBirthDate = this.$store.state.user.userBirthDate

                this.formPictures = this.$store.state.user.userPictures
                this.formSchoolClass = this.$store.state.user.userSchoolClass

                this.formCanGoAway = this.$store.state.user.canGoAway
                this.formActivityCostLimit = this.$store.state.user.activityCostLimit
                this.formPreferredPartners = this.$store.state.user.userPreferredPartners
                this.formDisponibilityPatterns = this.$store.state.user.userDisponibilityPatterns

                this.userRelatedFeedback = this.$store.state.user.userRelatedFeedback
                this.userSuccess = this.$store.state.user.userSuccess


            },
            submit() {

                let validation;

                validation = this.$validator.validateAll();

                console.log(validation);
                    validation.then(function(e){
                        console.log("pas d'erreur")

                    });
                this.updateProfile()

            },
            clear(){
                this.initProfileData();
            },
            updateProfile() {

                let payload = {}

                if ('' !== this.formNewPassword) {
                    payload.newPassword = this.formNewPassword;
                }

                payload.gender = this.formGender.value;
                payload.areSuccessUnlockedVisible = this.formAreSuccessUnlockedVisible;
                payload.areActivityParticipationVisible = this.formAreActivityParticipationVisible;
                payload.isPersonalProfileVisible = this.formIsPersonalProfileVisible
                payload.description = this.formDescription
                payload.email = this.formEmail
                payload.phoneNumber = this.formPhoneNumber
                payload.birthDate = this.formBirthDate
                payload.canGoAway = this.formCanGoAway
                payload.activityCostLimit = this.formActivityCostLimit

                let disponibilityPatternArray = []
                this.formDisponibilityPatterns.map(function(e){
                    disponibilityPatternArray.push(e.value)
                })
                payload.disponibilityPatterns = disponibilityPatternArray

                this.$store.dispatch('user/updateProfileData', payload)
                    .then(() => {
                        let payload = {
                            userId: this.$store.getters['user/userId'],
                        };
                        this.$store.dispatch('common/loadBaseData', payload)
                            .then(() =>{
                                this.initProfileData();
                            })
                    })
            },

        },
        mounted() {
            this.$validator.localize('fr', this.dictionary);
            this.initProfileData()
        },
    }
</script>
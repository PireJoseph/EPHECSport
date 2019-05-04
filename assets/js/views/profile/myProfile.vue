<style scoped>

</style>

<template>

    <div class="row col w3-padding-32 w3-container">
        <h1>mon profile</h1>
        <form
            @submit="checkForm"
            action="#"
            method="post"
        >

            <fieldset v-if="errors.length > 0">

                <ul>
                    <li v-for="error in errors">{{ error }}</li>
                </ul>

            </fieldset>



            <fieldset id="formProfileAccData">

                <div>
                    <label for="username">Nom d'utilisateur :</label>
                    <input id='username' name="username" v-model="formUsername" />
                </div>

                <div>
                    <label for="newPassword">Nouveau mot de passe :</label>
                    <input type="password" id='newPassword' name="newPassword" v-model="formNewPassword" />
                </div>

                <div>
                    <label for="areSuccessUnlockedVisible">Succès visibles :</label>
                    <input type="checkbox" id='areSuccessUnlockedVisible' name="areSuccessUnlockedVisible" v-model="formAreSuccessUnlockedVisible" />
                </div>

                <div>
                    <label for="areActivityParticipationVisible">Participations visibles :</label>
                    <input type="checkbox" id='areActivityParticipationVisible' name="areActivityParticipationVisible" v-model="formAreActivityParticipationVisible" />
                </div>

                <div>
                    <label for="isPersonalProfileVisible">Profil visible :</label>
                    <input type="checkbox" id='isPersonalProfileVisible' name="isPersonalProfileVisible" v-model="formIsPersonalProfileVisible" />
                </div>

                <div>
                    <label for="profilePicture">Avatar :</label>
                    <input type="file" id='profilePicture' name="profilePicture" v-model="formProfilePicture" />
                </div>


            </fieldset>



            <fieldset id="formProfileContactData">

                <div>
                    <label for="description">Description :</label>
                    <input type="text" id='description' name="description" v-model="formDescription" />
                </div>

                <div>
                    <label for="email">Email :</label>
                    <input type="email" id='email' name="email" v-model="formEmail" />
                </div>

                <div>
                    <label for="phoneNumber">Numéro de téléphone :</label>
                    <input type="email" id='phoneNumber' name="phoneNumber" v-model="formPhoneNumber" />
                </div>

            </fieldset >



            <fieldset id="formProfilePersonalData">

                <div>
                    <label for="gender">Genre</label>
                    <select id="gender" name="gender" v-model="formGender" >
                        <option value="" disabled selected >Sélectionnez</option>
                        <option value="M" >Homme</option>
                        <option value="F" >Femme</option>
                    </select>
                </div>

                <div>
                    <label for="birthDate">Date d'anniversaire :</label>
                    <input type="date" id='birthDate' name="birthDate" v-model="formBirthDate" />
                </div>



            </fieldset>



            <fieldset id="formProfileActivityData">


                <div>
                    <label for="canGoAway">Peut se déplacer :</label>
                    <input type="checkbox" id='canGoAway' name="canGoAway" v-model="formCanGoAway" />
                </div>

                <div>
                    <label for="activityCostLimit">Limite de cout par activités :</label>
                    <input type="checkbox" id='activityCostLimit' name="activityCostLimit" v-model="formActivityCostLimit" />
                </div>


            </fieldset>


            <fieldset>



            </fieldset>


            <fieldset>



            </fieldset>

            <input type="submit">

        </form>
    </div>

</template>

<script>
    import {mapGetters, mapMutations, mapState} from "vuex";

    export default {
        name: 'my-profile',
        data() {
            return {
                errors : [],

                formUsername : String,
                formNewPassword : String,
                formAreSuccessUnlockedVisible: Boolean,
                formAreActivityParticipationVisible : Boolean,
                formIsPersonalProfileVisible : Boolean,
                formProfilePicture : File,

                formDescription: String,
                formEmail : String,
                formPhoneNumber : String,

                formGender : String,
                formBirthDate : Date,
                formPictures : Array,
                formSchoolClass : String,
                formSportCLub : String,

                formCanGoAway : Boolean,
                formActivityCostLimit : Number,
                formPreferredPartners : Array,
                formDisponibilityPatterns : Array,
                formMaterial : Array,

                formUserRelatedFeedback : Array,
                formSuccess : Array

            }
        },
        computed: {
            // username: {
            //     get () {
            //         return this.$store.state.user.username
            //     },
            //     set (value) {
            //         // this.$store.commit('user/UPDATE_USERNAME', value)
            //         this.formUsername = value
            //     }
            // },
            // formUsername () {
            //     return this.formUsername
            // },
            // ...mapState({
            //     formUsername: state => state.formUsername
            // })
            // ...mapGetters({
            //     username: 'user/username',
            // })
        },
        methods: {

            initProfileData () {
                this.formUsername = this.$store.state.user.username
                this.formEmail = this.$store.state.user.userMail
                this.formGender = this.$store.state.user.userGender
                this.formPhoneNumber = this.$store.state.user.userPhoneNumber
            },

            checkForm (e) {

                e.preventDefault();

                this.errors = [];

                if (!this.formUsername) {
                    this.errors.push('nom d\'utilisateur requis.');
                }

                if (this.errors.length === 0) {
                    this.updateProfile()
                }

            },

            updateProfile () {
                let payload = {
                    'username' : this.formUsername
                };

                if ('' !== this.formNewPassword) {
                    payload.newPassword = this.formNewPassword;
                }
                if ('' !== this.formGender) {
                    payload.gender = this.formGender;
                }


                this.$store.dispatch('user/updateProfileData', payload)
                    .then(() => {
                        if (!this.$store.getters['user/hasError']) {
                            this.initProfileData()
                        }

                    })
            },

            ...mapMutations({

            })

        },
        mounted() {
            this.initProfileData()
        },
    }
</script>
<style scoped >


    strong {
        font-weight: bolder;
    }
</style>

<template>
    <div>
        <div class="w3-card w3-round w3-white w3-padding-32 w3-hide-small">
            <h3>mes profils sportifs</h3>
        </div>

        <div>
            <form action="#">

                <div class="w3-container w3-card w3-round w3-white w3-padding-32 w3-margin-top">

                    <h4>Formulaire profil sportif</h4>

                    <div class="formInputContainer w3-center w3-margin ">
                        <label class="formInputLabel">Sport :</label>
                        <v-select
                                :options="sportSelectArray"
                                v-model="formSport"
                                :reduce="e => e.value"
                                @input="setFormDataFromSport"
                                :clearable="false"
                                label="label"
                        ></v-select>
                    </div>

                    <div class="formInputContainer w3-center w3-margin ">
                        <label class="formInputLabel" for="roleInput">Role :</label>
                        <input type="text"
                               id="roleInput"
                               name="roleInput"
                               v-model="formRole"
                               v-validate="'min:3|max:32'"
                        />
                        <span v-show="!!errors.first('roleInput')" class="w3-tag w3-tiny w3-padding w3-red formInputErrors" >{{ errors.first('roleInput') }}</span>
                    </div>

                    <div class="formInputContainer w3-center w3-margin ">
                        <label class="formInputLabel">Nivau :</label>
                        <v-select
                                :options="levelSelectArray"
                                v-model="formLevel"
                                :reduce="e => e.value"
                                :clearable="false"
                                label="label"
                        ></v-select>
                    </div>

                    <div class="formInputContainer w3-center w3-margin ">
                        <label class="formInputLabel" for="isAimingFunInput">Vise le fun :</label>
                        <input type="checkbox"
                               id="isAimingFunInput"
                               name="isAimingFunInput"
                               v-model="formIsAimingFun"
                        />
                    </div>

                    <div class="formInputContainer w3-center w3-margin ">
                        <label class="formInputLabel" for="isAimingPerfInput">Vise les performances :</label>
                        <input type="checkbox"
                               id="isAimingPerfInput"
                               name="isAimingPerfInput"
                               v-model="formIsAimingPerf"
                        />
                    </div>

                    <div class="formInputContainer w3-center w3-margin ">
                        <label class="formInputLabel" for="wantedTimesPerWeekInput">Limite de coût par activité :</label>
                        <input type="number"
                               id="wantedTimesPerWeekInput"
                               name="wantedTimesPerWeekInput"
                               v-model="formWantedTimesPerWeek"
                               v-validate="'min:0'"
                               min="0"
                        />
                        <span v-show="!!errors.first('wantedTimesPerWeekInput')" class="w3-tag w3-tiny w3-padding w3-red formInputErrors" >{{ errors.first('wantedTimesPerWeekInput') }}</span>
                    </div>

                    <div class="formInputContainer w3-center w3-margin ">
                        <label class="formInputLabel" for="wantToBeNotifiedAboutThisSportInput">Etre notifié a propos de ce sport :</label>
                        <input type="checkbox"
                               id="wantToBeNotifiedAboutThisSportInput"
                               name="wantToBeNotifiedAboutThisSportInput"
                               v-model="formWantToBeNotifiedAboutThisSport"
                        />
                    </div>

                    <div class="formInputContainer w3-center w3-margin ">
                        <label class="formInputLabel" for="isVisibleInput">Profil sportif visible :</label>
                        <input type="checkbox"
                               id="isVisibleInput"
                               name="isVisibleInput"
                               v-model="formIsVisible"
                        />
                    </div>

                </div>

                <div class="w3-container w3-card w3-round w3-white w3-padding-32 w3-margin-top">
                    <button type="button" class="w3-button w3-red" @click="setFormDataFromSport(formSport)" >Réinitialiser</button>
                    <button v-show="correspondingSportProfileExisting" type="button" class="w3-button w3-green"  @click="dispatchRequest" :disabled="sportProfileLoading">Modifier profil pour ce sport</button>
                    <button v-show="!correspondingSportProfileExisting" type="button" class="w3-button w3-green"  @click="dispatchRequest" :disabled="sportProfileLoading">Créer profil pour ce sport</button>
                </div>


            </form>

        </div>

        <div>
            <div v-for="sportProfile in sportProfiles"  :key="sportProfile.id" class="w3-card-4 w3-margin-top w3-round">

                <header class="w3-container w3-theme-d3">
                    <h1>{{sportProfile.sportDTO.label}}</h1>
                </header>

                <div class="w3-container w3-white w3-row">

                    <div class="w3-left w3-col w3-row s12 m6 ">
                        <p class="w3-col s12"><span class="w3-left"><strong>Niveau : </strong>{{getLevelLabelFromToken(sportProfile.level  || 'Non Spécifié')}}</span></p>
                        <p class="w3-col s12"><span class="w3-left"><strong>Role : </strong>{{sportProfile.role || 'Non Spécifié' }}</span></p>
                        <p class="w3-col s12"><span class="w3-left"><strong>Fréquence semaine désirée : </strong>{{sportProfile.wantedTimesPerWeek || 'Non Spécifié'}}</span></p>
                    </div>
                    <div class="w3-right w3-col w3-row s12 m6">
                        <p class="w3-col s12"><span class="w3-tag w3-right" :class="{ 'w3-green': sportProfile.isAimingFun, 'w3-red': !sportProfile.isAimingFun}">Vise le fun</span></p>
                        <p class="w3-col s12"><span class="w3-tag w3-right" :class="{ 'w3-green': sportProfile.isAimingPerf, 'w3-red': !sportProfile.isAimingPerf}">Vise les perfs</span></p>
                        <p class="w3-col s12"><span class="w3-tag w3-right"  :class="{ 'w3-green': sportProfile.wantToBeNotifiedAboutThisSport, 'w3-red': !sportProfile.wantToBeNotifiedAboutThisSport}">Veut être notifié</span></p>
                    </div>

                </div>

                <footer class="w3-container w3-theme-d3">
                    <h5>{{sportProfile.role || 'Rôle inconnu'}}</h5>
                    <p v-show="!!sportProfile.isVisible" class="w3-small  w3-theme-d2"><span class="w3-center">Profil public</span></p>
                </footer>

            </div>
        </div>

    </div>


</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: 'my-sport-profiles',
        data() {
            return {
                formValid : false,

                correspondingSportProfileExisting : false,

                formRole : '',
                formSport : 0,
                formLevel : 'AMATEUR',
                formIsAimingFun : false,
                formIsAimingPerf : false,

                formWantedTimesPerWeek : 0,
                formWantToBeNotifiedAboutThisSport : false,
                formIsVisible : false,

                levelSelectArray : [
                    {
                        value : 'AMATEUR',
                        label : 'Amateur',
                    },
                    {
                        value : 'SEMI_PRO',
                        label : 'Semi pro',
                    },
                    {
                        value : 'PRO',
                        label : 'Professionnel',
                    },
                ],

                dictionary: {
                    attributes: {},
                    custom: {
                        roleInput: {
                            max: 'Role trop long',
                            min: 'Role trop petit',
                        },
                        wantedTimesPerWeekInput: {
                            min: 'Pas de valeur négative autorisée'
                        }
                    }
                },
            }
        },
        computed: {
            sportSelectArray () {
                let sportDTO = this.$store.state.activity.sportDTOs
                let sportSelectArray = [];
                sportDTO.map(function(e){
                    sportSelectArray.push(
                        {
                            value : e.id,
                            label : e.label,
                        }
                    )
                })
                if(0 ===this.formSport) {
                    let sportId = sportSelectArray[0].value
                    this.formSport = sportId;
                    this.setFormDataFromSport(sportId);
                }
                return sportSelectArray;
            },
            ...mapGetters({
                // otherProfiles: 'user/otherProfiles',
                sportProfileLoading : 'user/sportProfileLoading',
                sportProfiles: 'user/sportProfileDTOs'
            })


        },
        methods: {

            clear () {
                this.formRole = '';
                this.formLevel = 'AMATEUR';
                this.formIsAimingFun = false;
                this.formIsAimingPerf = false;
                this.formWantedTimesPerWeek = 0;
                this.formWantToBeNotifiedAboutThisSport = false;
                this.formIsVisible = false;
            },

            setFormDataFromSport (selectedSportId) {
                let sportProfileCorrespondingFound = false;
                this.formSport = selectedSportId;

                this.sportProfiles.forEach((sportProfile) => {
                    if(selectedSportId === sportProfile.sportId) {
                        this.formRole = sportProfile.role;
                        this.formLevel = sportProfile.level;
                        this.formIsAimingFun = sportProfile.isAimingFun;
                        this.formIsAimingPerf = sportProfile.isAimingPerf;
                        this.formWantedTimesPerWeek = sportProfile.wantedTimesPerWeek;
                        this.formWantToBeNotifiedAboutThisSport = sportProfile.wantToBeNotifiedAboutThisSport;
                        this.formIsVisible = sportProfile.isVisible;
                        sportProfileCorrespondingFound = true;
                    }
                });
                this.correspondingSportProfileExisting = sportProfileCorrespondingFound;
                if (!this.correspondingSportProfileExisting){
                    this.clear();
                }

            },

            dispatchRequest() {
                let sportProfilesDTO = this.$store.state.user.sportProfileDTOs
                let formSport = this.formSport;
                let alreadyExistingSportProfileId;

                sportProfilesDTO.map(function (e) {
                    if (e.sportId === formSport){
                        alreadyExistingSportProfileId = e.id
                    }
                })

                if (!!alreadyExistingSportProfileId) {
                    this.putSportProfile(alreadyExistingSportProfileId)
                } else {
                    this.postSportProfile()
                }
            },
            postSportProfile(){
                let payload = {};
                payload.role = this.formRole;
                payload.sportId = this.formSport;
                payload.level = this.formLevel;
                payload.isAimingFun = this.formIsAimingFun;
                payload.isAimingPerf = this.formIsAimingPerf;
                payload.wantedTimesPerWeek = this.formWantedTimesPerWeek;
                payload.wantToBeNotifiedAboutThisSport = this.formWantToBeNotifiedAboutThisSport;
                payload.isVisible = this.formIsVisible;

                this.$validator.validateAll().then(()=> {
                    this.$store.dispatch('user/postSportProfile', payload)
                        .then(() => {
                            let payload = {
                                userId: this.$store.getters['user/userId'],
                            };
                            this.$store.dispatch('common/loadBaseData', payload)
                        })
                })
            },
            putSportProfile(alreadyExistingSportProfileId){
                let payload = {};
                payload.id = alreadyExistingSportProfileId;
                payload.role = this.formRole;
                payload.sportId = this.formSport;
                payload.level = this.formLevel;
                payload.isAimingFun = this.formIsAimingFun;
                payload.isAimingPerf = this.formIsAimingPerf;
                payload.wantedTimesPerWeek = this.formWantedTimesPerWeek;
                payload.wantToBeNotifiedAboutThisSport = this.formWantToBeNotifiedAboutThisSport;
                payload.isVisible = this.formIsVisible;

                this.$validator.validateAll().then(()=> {
                    this.$store.dispatch('user/putSportProfile', payload)
                        .then(() => {
                            let payload = {
                                userId: this.$store.getters['user/userId'],
                            };
                            this.$store.dispatch('common/loadBaseData', payload)
                        })
                })
            },
            getLevelLabelFromToken (token) {
                switch (token){
                    case 'AMATEUR':
                        return 'Amateur';
                    case 'SEMI_PRO':
                        return 'Semi pro';
                    case 'PRO':
                        return 'Professionnel';
                    default :
                        return '';
                }
            }

        },
        mounted() {
            this.$validator.localize('fr', this.dictionary);

        },
    }
</script>


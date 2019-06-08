<style scoped>

    #vue-container{
        background-color: #dcdcdc;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-form-btn{
        width: 120px;
    }

    h1.form-title {
        display: flex;
        justify-content: center;
        margin-bottom: 35px;
        color: white;
    }

    .form-container {
        width: 80%; /* Could be more or less, depending on screen size */
        max-width: 800px;

    }
    .form-content  {
        color: #000;
    }

    .form-content  input{
        width: 100%;
        padding: 12px 20px;
        margin-bottom: 16px;
        display: inline-block;
        border: 0;
        box-sizing: border-box;
        border-bottom: 1px solid #ccc!important
    }

    .form-content label {
        margin-top: 16px;
        display: flex;
        justify-content: center;
    }

    .form-btn , .form-alert{
        padding: 14px 20px;
        width: 100%;
    }

    #vue-container {
        flex-grow: 1;
    }
</style>

<template>

    <div id="vue-container" >


        <div class="row col form-container ">
            <div class="row col">
                <h1 class="form-title">Connexion</h1>
            </div>
            <form  @submit.prevent
                   name="loginForm"
                   method="post"
                   action="#"
            >
                <div class="form-content w3-container w3-card w3-padding-32 w3-white">
                    <div >
                        <div v-if="hasError" class="w3-red form-alert">
                            {{ getErrorMessageTranslated }}
                        </div>
                        <div>
                            <label for="inputUsername" >Nom d'utilisateur</label>
                            <input
                                    v-model="username"
                                    type="text"
                                    id="inputUsername"
                                    name="inputUsername"
                                    v-validate="'max:128|min:8|required'"
                                    autofocus
                                    required
                            >
                            <span v-show="!!errors.first('inputUsername')" class="w3-tag w3-tiny w3-padding w3-red formInputErrors" >{{ errors.first('inputUsername') }}</span>

                        </div>
                        <div >
                            <label for="inputPassword">Mot de passe</label>
                            <input
                                    v-model="password"
                                    type="password"
                                    id="inputPassword"
                                    name="inputPassword"
                                    v-validate="'max:128|min:8|required'"
                                    required
                            >
                            <span v-show="!!errors.first('inputPassword')" class="w3-tag w3-tiny w3-padding w3-red formInputErrors" >{{ errors.first('inputPassword') }}</span>
                        </div>
                        <div >
                            <button @click="performLogin()" :disabled="isSubmitBtnDisabled" type="submit" class="w3-button w3-green form-btn w3-margin-top login-form-btn">
                                <span v-show="!isLoading">Se connecter</span>
                                <span v-show="isLoading"><i class="fas fa-spinner fa-spin"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>


        </div>




    </div>

</template>

<script>
    import TokenService from '../services/token'
    import {mapState, mapGetters} from "vuex";


    export default {
        name: 'login',
        data () {
            return {
                username: '',
                password: '',
            };
        },
        created () {
            let redirect = this.$route.query.redirect;
            if (TokenService.refreshTokenIsStillValid()) {
                if (typeof redirect !== 'undefined') {
                    this.$router.push({path: redirect});
                } else {
                    this.$router.push({path: '/user/home'});
                }
            }
        },
        computed: {

            ...mapGetters({
                hasError: 'security/hasError'
            }),

            ...mapState({

                isLoading : (state) => state.security.isLoading,
                error : (state) => state.security.error,

            }),
            isFormValid(){
              return (!this.errors.first('inputPassword') && !this.errors.first('inputUsername'))
            },
            areFieldsFilled(){
              return (!!this.username.length && !!this.password.length);
            },
            isSubmitBtnDisabled(){
              return (!this.areFieldsFilled || !this.isFormValid || this.isLoading);
            },
            getErrorMessageTranslated() {
                switch(this.error){
                    case 'Request failed with status code 401':
                        return 'identifiants invalides';
                    default :
                        return 'problème de connection avec le serveur';
                }

            }
        },
        methods: {
            performLogin () {
                let payload = {
                    login: this.$data.username,
                    password: this.$data.password
                };
                let validation;
                validation = this.$validator.validateAll();
                validation.then(
                    (isFormValid) => {
                        if(isFormValid) {
                            let redirect = this.$route.query.redirect;

                            this.$store.dispatch('security/login', payload)
                                .then(() => {
                                    if (!this.$store.getters['security/hasError']) {
                                        if (typeof redirect !== 'undefined') {
                                            this.$router.push({path: redirect});
                                        } else {
                                            console.log('pas de redirect');
                                            this.$router.push({path: '/user/home'});
                                        }
                                    }
                                })
                        }
                    },
                );

            },
        },
    }
</script>
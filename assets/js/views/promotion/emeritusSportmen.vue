<style scoped>

    .sport-man-card-header {
        padding: 8px;
    }

    .sport-man-card-title-container {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }
    .sport-man-card-expand-btn {
        margin-left: auto;
    }
    .sport-man-card-title {
        margin: 0;
        position: absolute;
    }
    .sport-man-card-nickname{
        margin: 0;
        font-style: italic;
    }

    .sport-man-card-role{
        margin: 0;
    }

    .sport-man-card-sport{
        margin: 16px 0 0 0;
        text-transform: uppercase;
    }

    .sport-man-card-label{
        margin: 0;
    }

    .sport-man-card-photo{
        padding: 16px 16px 0 16px;
    }

    .sport-man-card-achievement-header, .sport-man-card-achievement-header span {
        display: block;
        text-align: left;
        font-size: medium;
    }

    .sport-man-card-shout-out-header {
        font-size: medium;
    }
    .sport-man-card-shout-out-comment {
        font-size: medium;
        margin-top: 0;
    }
    .sport-man-card-shout-out-comment i{
        font-size: x-small!important;
    }


    @media only screen and (max-width: 600px) {

        .sport-man-card-achievement-header, .sport-man-card-achievement-header span {
            display: block;
            text-align: left;
            font-size: small;
        }

        .sport-man-card-achievement-header span i {
            font-size: small!important;
        }
        .sport-man-card-achievement-comment {
            font-size: small;
        }


        .sport-man-card-shout-out-header {
            font-size: small;
        }
        .sport-man-card-shout-out-comment {
            margin-top: 0;
            font-size: small;

        }
        .sport-man-card-shout-out-comment i{
            font-size: xx-small!important;
        }
    }

    button.active{
        color: black!important;
    }

</style>


<template>

    <div>

        <div class="w3-card w3-round w3-white w3-padding-32 w3-hide-small">
            <h3>Sportifs émérites</h3>
        </div>

        <div v-show="!!sportMen">

            <div v-for="sportMan in sportMen" :key="sportMan.id" class="w3-card w3-margin-top w3-white w3-center">
                <header class="w3-theme-d3 sport-man-card-header">
                    <div class="sport-man-card-title-container">
                        <h5 class="w3-padding sport-man-card-title">
                           <span>{{sportMan.firstName}} </span><span> {{sportMan.lastName}}</span>
                        </h5>
                        <span @click="toggleExpandSportMan(sportMan.id)" class="sport-man-card-expand-btn w3-button">
                            <i class="fas fa-caret-right " :class="{'fa-rotate-90' : isSportManExpanded(sportMan.id)}"></i>
                        </span>
                    </div>
                    <div v-show="isSportManExpanded(sportMan.id) && areSportManDetailsShown(sportMan)">
                        <p v-show="!!sportMan.nickName" class="sport-man-card-nickname w3-opacity">" {{sportMan.nickName}} "</p>
                        <p class="sport-man-card-sport" >{{sportMan.sport.label}}</p>
                        <p class="sport-man-card-role" v-show="!!sportMan.role"><span class="w3-opacity">{{sportMan.role}}</span></p>
                    </div>
                </header>
                <p class="w3-padding-16 sport-man-card-label" v-show="isSportManExpanded(sportMan.id) && areSportManDetailsShown(sportMan)" >{{sportMan.label}}</p>

                <!--pictures carousel-->
                <div class="sport-man-card-photo"  v-if="isSportManExpanded(sportMan.id) && isCarouselPicturesOpenForSportMan(sportMan)">
                    <agile
                            :options="getAgileOptionsForSportMan(sportMan)"
                    >
                        <div  v-for="sportManPictures in sportMan.pictures" :key="sportManPictures.image">

                            <img
                                    @click="openPicturesModal((getPicturePath()  + sportManPictures.image))"
                                    v-bind:src="(getPicturePath()  + sportManPictures.image)"
                                    v-bind:alt="sportManPictures.label"
                                    title="agrandir"
                                    class="w3-hover-opacity"
                                    style="height: 100px; cursor:pointer"

                            />
                            <p class="w3-centered" style="margin-bottom: 0">{{sportManPictures.label}}</p>

                        </div>

                        <template slot="prevButton"><i class="fas fa-chevron-left"></i></template>
                        <template slot="nextButton"><i class="fas fa-chevron-right"></i></template>

                    </agile>
                </div>

                <!--achievements list-->
                <div class="sport-man-card-achievements w3-padding"  v-if="isSportManExpanded(sportMan.id) && isAchievementsListOpenForSportMan(sportMan)">
                    <ul class="w3-ul ">
                        <li  class="w3-border w3-theme-d1" v-for="sportManAchievement in sportMan.achievements" :key="sportManAchievement.id">

                            <h4 class="sport-man-card-achievement-header w3-margin-bottom">
                                <span><i class="far fa-star"></i> {{sportManAchievement.label}}</span>
                                <span class="w3-opacity"><i class="far fa-calendar-check" aria-hidden="true"></i> {{getFormatedDateString(sportManAchievement.acquiredAt)}}</span>
                            </h4>

                            <p class="w3-right-align sport-man-card-achievement-comment" >
                                {{sportManAchievement.comment}}
                            </p>

                        </li>
                    </ul>
                </div>

                <!--shoutOuts list-->
                <div class="sport-man-card-ShoutOuts w3-padding"  v-if="isSportManExpanded(sportMan.id) && isShoutOutsListOpenForSportMan(sportMan)">
                    <div v-show="shoutOutsForSelectedSportManLoading" class="w3-opacity w3-center w3-padding">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                    <div v-show="!selectedSportManHasShoutOuts" class="w3-opacity w3-center w3-padding">
                        Aucun encouragement n'a été posté
                    </div>
                    <ul v-show="(!shoutOutsForSelectedSportManLoading & selectedSportManHasShoutOuts)" class="w3-ul " >

                        <li v-for="shoutOut in shoutOutsForSelectedSportMan" :key="shoutOut.id" class="sport-man-card-shout-out w3-border w3-theme-l1 w3-margin-bottom">
                            <h4 class="sport-man-card-shout-out-header w3-left-align">
                                <span class="w3-opacity"><i class="far fa-calendar-check" aria-hidden="true"></i> posté le {{getFormatedDateString(shoutOut.createdAt)}}, à {{getFormatedDateTimeString(shoutOut.createdAt)}}</span>
                            </h4>
                            <p class="sport-man-card-shout-out-comment w3-right-align ">
                                <i class="fa fa-quote-left w3-small" aria-hidden="true"></i><span> {{shoutOut.content}}</span> <i class="fa fa-quote-right w3-small" aria-hidden="true"></i>
                            </p>
                        </li>

                    </ul>
                    <div>
                        <button
                                class="w3-button w3-small w3-white w3-border"
                                @click="openShoutOutFormModal(sportMan)"
                                :disabled="isShoutOutBtnDisabled"
                        >
                            <span v-show="!areShoutOutsLoading">
                                Encourager !
                            </span>
                            <span v-show="areShoutOutsLoading">
                                <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                            </span>
                        </button>
                    </div>
                </div>


                <!--btns bar-->
                <footer class="w3-padding sport-man-card-footer" v-show="isSportManExpanded(sportMan.id)">

                    <button
                            class="w3-button  w3-theme-d1 "
                            @click="togglePicturesCarousel(sportMan)"
                            :disabled="!sportManHasPictures(sportMan)"
                            v-bind:class="{ 'w3-theme-d3': isCarouselPicturesOpenForSportMan(sportMan), 'w3-theme-d1': !isCarouselPicturesOpenForSportMan(sportMan) }"
                    >
                        <i class="fa fa-camera" aria-hidden="true"></i><span class="w3-hide-small"> Photos</span>
                    </button>

                    <button
                            class="w3-button  w3-theme-d1 w3-margin-left w3-margin-right"
                            @click="toggleAchievementsList(sportMan)"
                            :disabled="!sportManHasAchievements(sportMan)"
                            v-bind:class="{ 'w3-theme-d3': isAchievementsListOpenForSportMan(sportMan), 'w3-theme-d1': !isAchievementsListOpenForSportMan(sportMan) }"
                    >
                        <i class="fa fa-trophy" aria-hidden="true"></i><span class="w3-hide-small"> Palmarès</span>
                    </button>

                    <button
                            class="w3-button  w3-theme-d1 "
                            @click="toggleShoutOutsList(sportMan)"
                            v-bind:class="{ 'w3-theme-d3': isShoutOutsListOpenForSportMan(sportMan), 'w3-theme-d1': !isShoutOutsListOpenForSportMan(sportMan) }"
                    >
                        <i class="fa fa-bullhorn" aria-hidden="true"></i><span class="w3-hide-small"> Encouragements</span>
                    </button>

                </footer>
            </div>

        </div>


        <!--pictures Modal-->
        <div class="w3-modal"
             style="display: block;"
             @click="closePicturesModal"
             v-show="picturesModalOpen">
            <div class="w3-modal-content w3-animate-opacity">
                <img  v-bind:src="picturesModalImgSrc" class="w3-image">
            </div>
        </div>


        <!--ShoutOut Modal-->
        <div id="shoutOutModal" class="w3-modal" style="display: block;" v-show="isShoutOutFormModalOpen">

            <div class="w3-modal-content w3-animate-opacity">

                <header class="w3-container w3-theme-d1">
                    <span @click="closeShoutOutFormModal" class="w3-button w3-display-topright">&times;</span>
                    <h4 v-if="selectedSportManForShoutOutForm !== null">Encouragement {{selectedSportManForShoutOutForm.name}}</h4>
                </header>

                <div class="w3-container">
                    <form action="#">

                        <div class="formInputContainer w3-center w3-margin ">
                            <label class="formInputLabel" for="shoutOutContentInput">Contenu :</label>
                            <textarea
                                    id="shoutOutContentInput"
                                    name="shoutOutContentInput"
                                    v-model="shoutOutForm.content"
                                    v-validate="'max:1024|min:3|required'"
                                    maxlength="1024"
                                    minlength="3"
                                    required
                                    data-vv-validate-on=""
                                    rows="5"
                            >
                        </textarea>
                            <span v-show="!!errors.first('shoutOutContentInput')" class="w3-tag w3-tiny w3-padding w3-red formInputErrors" >{{ errors.first('shoutOutContentInput') }}</span>

                        </div>

                    </form>
                </div>

                <footer class="w3-container w3-theme-d1 w3-padding">
                    <button type="button" class="w3-button w3-red" @click="closeShoutOutFormModal" >Fermer</button>
                    <button type="button" class="w3-button w3-green" @click="postShoutOutForm(selectedSportManForShoutOutForm)" :disabled="postShoutOutLoading">Poster encouragements</button>
                </footer>

            </div>
        </div>



    </div>
</template>


<script>

    import {mapState} from "vuex";
    import moment from "moment"
    import { VueAgile } from 'vue-agile'

    export default {
        name: 'emeritus-sportmen',
        components: {
            agile: VueAgile
        },
        data() {
            return {

                idOfSportMenExpanded : [],

                idOfSportManWithPicturesCarouselOpen : null,
                idOfSportManWithAchievementsListOpen: null,

                idOfSportManWithShoutOutsListOpen: null,
                selectedSportManForShoutOutForm: null,

                picturesModalOpen : false,
                picturesModalImgSrc : '',


                isShoutOutFormModalOpen : false,
                shoutOutForm : {
                    emeritusSportManTarget : '',
                    content: ''
                },


            }
        },
        computed: {

            selectedSportManHasShoutOuts(){
                return (this.shoutOutsForSelectedSportMan.length > 0)
            },
            areShoutOutsLoading(){
                return (this.shoutOutsForSelectedSportManLoading || this.postShoutOutLoading);
            },
            isShoutOutBtnDisabled(){
                return (this.areShoutOutsLoading || this.isShoutOutFormModalOpen);
            },


            ...mapState({
                sportMen : (state) => state.promotion.sportMen,

                shoutOutsForSelectedSportMan :  (state) => state.promotion.shoutOutsForSelectedSportMan,
                shoutOutsForSelectedSportManLoading : (state) => state.promotion.shoutOutsForSelectedSportManLoading,

                postShoutOutLoading : (state) => state.promotion.postSportManShoutOutLoading
            }),


        },
        methods: {

            getSportMenData() {
                this.$store.dispatch('promotion/getSportMenData')
            },

            isSportManExpanded(sportManId) {
                return (this.idOfSportMenExpanded.indexOf(sportManId) > -1);

            },
            toggleExpandSportMan(sportManId) {
                let index = this.idOfSportMenExpanded.indexOf(sportManId);
                if (index > -1){
                    this.idOfSportMenExpanded.splice(index,1)
                } else {
                    this.idOfSportMenExpanded.push(sportManId)
                }
            },

            areSportManDetailsShown(sportMan) {
                return (!(this.idOfSportManWithPicturesCarouselOpen === sportMan.id) && !(this.idOfSportManWithAchievementsListOpen === sportMan.id) && !(this.idOfSportManWithShoutOutsListOpen === sportMan.id));
            },

            sportManHasPictures(sportMan){
                return (this.getSportManPictures(sportMan).length > 0)
            },
            getSportManPictures(sportMan){
                let pictures = [];
                sportMan.pictures.map((picture)=>{
                    pictures.push(picture);
                });
                return pictures;
            },
            getPicturePath(){
                return   '/images/pictures/';
            },
            togglePicturesCarousel(sportMan){
                this.idOfSportManWithAchievementsListOpen = null;
                this.idOfSportManWithShoutOutsListOpen = null;
                this.idOfSportManWithPicturesCarouselOpen = (this.idOfSportManWithPicturesCarouselOpen !== sportMan.id) ? sportMan.id : null;
            },
            isCarouselPicturesOpenForSportMan(sportMan) {
                return this.idOfSportManWithPicturesCarouselOpen === sportMan.id;
            },
            openPicturesModal(imgSrc) {
                this.picturesModalImgSrc = imgSrc;
                this.picturesModalOpen = true;
            },
            closePicturesModal() {
                this.selectedSportMan = null;
                this.picturesModalOpen = false;
            },

            sportManHasAchievements(sportMan){
                return (this.getSportManAchievements(sportMan).length > 0)
            },
            getSportManAchievements(sportMan){
                let achievements = [];
                sportMan.achievements.map((achievement)=>{
                    achievements.push(achievement);
                });
                return achievements;
            },
            toggleAchievementsList(sportMan){
                this.idOfSportManWithPicturesCarouselOpen = null;
                this.idOfSportManWithShoutOutsListOpen = null;
                this.idOfSportManWithAchievementsListOpen = (this.idOfSportManWithAchievementsListOpen !== sportMan.id) ? sportMan.id : null;
            },
            isAchievementsListOpenForSportMan(sportMan){
                return this.idOfSportManWithAchievementsListOpen === sportMan.id;
            },

            toggleShoutOutsList(sportMan){
                this.idOfSportManWithPicturesCarouselOpen = null;
                this.idOfSportManWithAchievementsListOpen = null;
                if(this.idOfSportManWithShoutOutsListOpen !== sportMan.id) {
                    this.idOfSportManWithShoutOutsListOpen = sportMan.id;
                    this.getShoutOutsForSelectedSportMan(sportMan);
                } else {
                    this.idOfSportManWithShoutOutsListOpen = null;
                }
            },
            isShoutOutsListOpenForSportMan(sportMan){
                return this.idOfSportManWithShoutOutsListOpen === sportMan.id;
            },
            openShoutOutFormModal(sportMan) {
                this.isShoutOutFormModalOpen = true;
                this.selectedSportManForShoutOutForm = sportMan;
                this.shoutOutForm.emeritusSportManTarget = sportMan['@id']
            },
            closeShoutOutFormModal() {
                this.isShoutOutFormModalOpen = false;
                this.selectedSportManForShoutOutForm = null;
                this.shoutOutForm = {
                    emeritusSportManTarget : '',
                    content: ''
                }
            },

            getShoutOutsForSelectedSportMan(sportMan) {
                this.$store.dispatch('promotion/getShoutOutsForSelectedSportMan', sportMan.id);
            },
            postShoutOutForm(sportMan){
                let validation;
                validation = this.$validator.validateAll();
                validation.then(
                    (isFormValid) => {
                        if(isFormValid) {
                            this.$store.dispatch('promotion/postSportManShoutOut', this.shoutOutForm)
                                .then (
                                    (success) => {
                                        this.getShoutOutsForSelectedSportMan(sportMan);
                                        this.closeShoutOutFormModal();
                                    },
                                    (errors) => {

                                    }
                                )
                        }
                    },
                )
            },

            getFormatedDateString(dateString) {
                return moment(dateString).format('Do MMMM YYYY')
            },
            getFormatedDateTimeString(dateString) {
                return moment(dateString).format('HH:mm:ss')
            },

            getAgileOptionsForSportMan(sportMan){
                let numberOfPitcuresToShowOnLargeScreen;
                let numberOfPicturesForTheSportMan = sportMan.pictures.length;

                if(numberOfPicturesForTheSportMan < 3){
                    numberOfPitcuresToShowOnLargeScreen = 1
                } else {
                    numberOfPitcuresToShowOnLargeScreen = 3;
                }

                return {
                    fade: false,
                    centerMode: true,
                    dots: true,
                    navButtons: true,
                    slidesToShow: 1,
                    responsive: [
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: numberOfPitcuresToShowOnLargeScreen
                            }
                        },
                        {
                            breakpoint: 1000,
                            settings: {
                                navButtons: true
                            }
                        }
                    ]
                };

            },

        },
        mounted() {
            this.getSportMenData();
        },
    }
</script>
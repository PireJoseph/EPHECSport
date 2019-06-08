<style scoped>

    .team-card-header {
        padding: 8px;
    }

    .team-card-title-container {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }
    .team-card-expand-btn {
        margin-left: auto;
    }
    .team-card-title {
        margin: 0;
        position: absolute;
    }

    .team-card-nickname{
        margin: 0;
        font-style: italic;
    }

    .team-card-sport{
        text-transform: uppercase;
    }

    .team-card-label{
        margin: 0;
    }

    .team-card-photo{
        padding: 16px 16px 0 16px;
    }

    .team-card-achievement-header, .team-card-achievement-header span {
        display: block;
        text-align: left;
        font-size: medium;
    }

    .team-card-shout-out-header {
        font-size: medium;
    }
    .team-card-shout-out-comment {
        font-size: medium;
        margin-top: 0;
    }
    .team-card-shout-out-comment i{
        font-size: x-small!important;
    }


    @media only screen and (max-width: 600px) {

        .team-card-achievement-header, .team-card-achievement-header span {
            display: block;
            text-align: left;
            font-size: small;
        }

        .team-card-achievement-header span i {
            font-size: small!important;
        }
        .team-card-achievement-comment {
            font-size: small;
        }


        .team-card-shout-out-header {
            font-size: small;
        }
        .team-card-shout-out-comment {
            margin-top: 0;
            font-size: small;

        }
        .team-card-shout-out-comment i{
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
            <h3>Equipes officielles</h3>
        </div>

        <div v-show="!!officialTeams">

            <div v-for="team in officialTeams" :key="team.id" class="w3-card w3-margin-top w3-white w3-center">
                <header class="w3-theme-d3 team-card-header">
                    <div class="team-card-title-container">
                        <h5 class="w3-padding team-card-title" >
                            <span v-show="!!team.shortName">{{team.shortName}} - </span><span>{{team.name}}</span>
                        </h5>
                        <span @click="toggleExpandTeam(team.id)" class="team-card-expand-btn w3-button">
                            <i class="fas fa-caret-right " :class="{'fa-rotate-90' : isTeamExpanded(team.id)}"></i>
                        </span>
                    </div>
                    <div v-show="isTeamExpanded(team.id) && areTeamDetailsShown(team)">
                        <p class="team-card-nickname" v-show="!!team.nickName"><span class="w3-opacity">{{team.nickName}}</span></p>
                        <p class="team-card-sport w3-margin" >{{team.sport.label}}</p>
                    </div>
                </header>
                <p class="w3-padding-16 team-card-label" v-show="isTeamExpanded(team.id) && areTeamDetailsShown(team)" >{{team.label}}</p>
                
                <!--pictures carousel-->
                <div class="team-card-photo"  v-if="isTeamExpanded(team.id) &&  isCarouselPicturesOpenForTeam(team)">
                    <agile
                            :options="getAgileOptionsForTeam(team)"
                    >
                        <div  v-for="teamPictures in team.pictures" :key="teamPictures.image">

                            <img
                                    @click="openPicturesModal((getPicturePath()  + teamPictures.image))"
                                    v-bind:src="(getPicturePath()  + teamPictures.image)"
                                    v-bind:alt="teamPictures.label"
                                    title="agrandir"
                                    class="w3-hover-opacity"
                                    style="height: 100px; cursor:pointer"

                            />
                            <p class="w3-centered" style="margin-bottom: 0">{{teamPictures.label}}</p>

                        </div>

                        <template slot="prevButton"><i class="fas fa-chevron-left"></i></template>
                        <template slot="nextButton"><i class="fas fa-chevron-right"></i></template>

                    </agile>
                </div>
                
                <!--achievements list-->
                <div class="team-card-achievements w3-padding"  v-if="isTeamExpanded(team.id) && isAchievementsListOpenForTeam(team)">
                    <ul class="w3-ul ">
                        <li  class="w3-border w3-theme-d1" v-for="teamAchievement in team.achievements" :key="teamAchievement.id">

                            <h4 class="team-card-achievement-header w3-margin-bottom">
                                <span><i class="far fa-star"></i> {{teamAchievement.label}}</span>
                                <span class="w3-opacity"><i class="far fa-calendar-check" aria-hidden="true"></i> {{getFormatedDateString(teamAchievement.acquiredAt)}}</span>
                            </h4>

                            <p class="w3-right-align team-card-achievement-comment" >
                                {{teamAchievement.comment}}
                            </p>

                        </li>
                    </ul>
                </div>

                <!--shoutOuts list-->
                <div class="team-card-ShoutOuts w3-padding"  v-if="isTeamExpanded(team.id) && isShoutOutsListOpenForTeam(team)">
                    <div v-show="shoutOutsForSelectedTeamLoading" class="w3-opacity w3-center w3-padding">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                    <div v-show="!selectedTeamHasShoutOuts" class="w3-opacity w3-center w3-padding">
                        Aucun encouragement n'a été posté
                    </div>
                    <ul v-show="(!shoutOutsForSelectedTeamLoading & selectedTeamHasShoutOuts)" class="w3-ul " >

                        <li v-for="shoutOut in shoutOutsForSelectedTeam" :key="shoutOut.id" class="team-card-shout-out w3-border w3-theme-l1 w3-margin-bottom">
                            <h4 class="team-card-shout-out-header w3-left-align">
                                <span class="w3-opacity"><i class="far fa-calendar-check" aria-hidden="true"></i> posté le {{getFormatedDateString(shoutOut.createdAt)}}, à {{getFormatedDateTimeString(shoutOut.createdAt)}}</span>
                            </h4>
                            <p class="team-card-shout-out-comment w3-right-align ">
                                <i class="fa fa-quote-left w3-small" aria-hidden="true"></i><span> {{shoutOut.content}}</span> <i class="fa fa-quote-right w3-small" aria-hidden="true"></i>
                            </p>
                        </li>

                    </ul>
                    <div>
                        <button
                                class="w3-button w3-small w3-white w3-border"
                                @click="openShoutOutFormModal(team)"
                                :disabled="isShoutOutBtnDisabled"
                        >
                            <span v-show="!areShoutOutsLoading">
                                Encourager !
                            </span>
                            <span v-show="areShoutOutsLoading">
                                <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                            </span>                        </button>
                    </div>
                </div>
                

                <!--btns bar-->
                <footer class="w3-padding team-card-footer" v-show="isTeamExpanded(team.id)">

                    <button
                            class="w3-button  w3-theme-d1 "
                            @click="togglePicturesCarousel(team)"
                            :disabled="!teamHasPictures(team)"
                            v-bind:class="{ 'w3-theme-d3': isCarouselPicturesOpenForTeam(team), 'w3-theme-d1': !isCarouselPicturesOpenForTeam(team) }"
                    >
                        <i class="fa fa-camera" aria-hidden="true"></i><span class="w3-hide-small"> Photos</span>
                    </button>

                    <button
                            class="w3-button  w3-theme-d1 w3-margin-left w3-margin-right"
                            @click="toggleAchievementsList(team)"
                            :disabled="!teamHasAchievements(team)"
                            v-bind:class="{ 'w3-theme-d3': isAchievementsListOpenForTeam(team), 'w3-theme-d1': !isAchievementsListOpenForTeam(team) }"

                    >
                        <i class="fa fa-trophy" aria-hidden="true"></i><span class="w3-hide-small"> Palmarès</span>
                    </button>

                    <button
                            class="w3-button  w3-theme-d1 "
                            @click="toggleShoutOutsList(team)"
                            v-bind:class="{ 'w3-theme-d3': isShoutOutsListOpenForTeam(team), 'w3-theme-d1': !isShoutOutsListOpenForTeam(team) }"
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
                    <h4 v-if="selectedTeamForShoutOutForm !== null">Encouragement {{selectedTeamForShoutOutForm.name}}</h4>
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
                    <button type="button" class="w3-button w3-green" @click="postShoutOutForm(selectedTeamForShoutOutForm)" :disabled="postShoutOutLoading">Poster encouragements</button>
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
        name: 'official-teams',
        components: {
            agile: VueAgile
        },
        data() {
            return {

                idOfTeamsExpanded : [],
                
                idOfTeamWithPicturesCarouselOpen : null,
                idOfTeamWithAchievementsListOpen: null,

                idOfTeamWithShoutOutsListOpen: null,
                selectedTeamForShoutOutForm: null,

                picturesModalOpen : false,
                picturesModalImgSrc : '',

                
                isShoutOutFormModalOpen : false,
                shoutOutForm : {
                    officialTeamTarget : '',
                    content: ''
                },



            }
        },
        computed: {

            selectedTeamHasShoutOuts(){
                return (this.shoutOutsForSelectedTeam.length > 0)
            },
            areShoutOutsLoading(){
                return (this.shoutOutsForSelectedTeamLoading || this.postShoutOutLoading);
            },
            isShoutOutBtnDisabled(){
                return (this.areShoutOutsLoading || this.isShoutOutFormModalOpen);
            },


            ...mapState({
                officialTeams : (state) => state.promotion.officialTeams,

                shoutOutsForSelectedTeam :  (state) => state.promotion.shoutOutsForSelectedTeam,
                shoutOutsForSelectedTeamLoading : (state) => state.promotion.shoutOutsForSelectedTeamLoading,

                postShoutOutLoading : (state) => state.promotion.postTeamShoutOutLoading
            }),


        },
        methods: {

            getOfficialTeamsData() {
                this.$store.dispatch('promotion/getOfficialTeamsData')
            },

            isTeamExpanded(teamId) {
                return (this.idOfTeamsExpanded.indexOf(teamId) > -1);

            },
            toggleExpandTeam(teamId) {
                let index = this.idOfTeamsExpanded.indexOf(teamId);
                if (index > -1){
                    this.idOfTeamsExpanded.splice(index,1)
                } else {
                    this.idOfTeamsExpanded.push(teamId)
                }
            },

            areTeamDetailsShown(team) { 
                return (!(this.idOfTeamWithPicturesCarouselOpen === team.id) && !(this.idOfTeamWithAchievementsListOpen === team.id) && !(this.idOfTeamWithShoutOutsListOpen === team.id));
            },

            teamHasPictures(team){
                return (this.getTeamPictures(team).length > 0)
            },
            getTeamPictures(team){
                let pictures = [];
                team.pictures.map((picture)=>{
                    pictures.push(picture);
                });
                return pictures;
            },
            getPicturePath(){
                return   '/images/pictures/';
            },
            togglePicturesCarousel(team){
                this.idOfTeamWithAchievementsListOpen = null;
                this.idOfTeamWithShoutOutsListOpen = null;
                this.idOfTeamWithPicturesCarouselOpen = (this.idOfTeamWithPicturesCarouselOpen !== team.id) ? team.id : null;
            },
            isCarouselPicturesOpenForTeam(team) {
                return this.idOfTeamWithPicturesCarouselOpen === team.id;
            },
            openPicturesModal(imgSrc) {
                this.picturesModalImgSrc = imgSrc;
                this.picturesModalOpen = true;
            },
            closePicturesModal() {
                this.selectedTeam = null;
                this.picturesModalOpen = false;
            },

            teamHasAchievements(team){
                return (this.getTeamAchievements(team).length > 0)
            },
            getTeamAchievements(team){
                let achievements = [];
                team.achievements.map((achievement)=>{
                    achievements.push(achievement);
                });
                return achievements;
            },
            toggleAchievementsList(team){
                this.idOfTeamWithPicturesCarouselOpen = null;
                this.idOfTeamWithShoutOutsListOpen = null;
                this.idOfTeamWithAchievementsListOpen = (this.idOfTeamWithAchievementsListOpen !== team.id) ? team.id : null;
            },
            isAchievementsListOpenForTeam(team){
                return this.idOfTeamWithAchievementsListOpen === team.id;
            },

            toggleShoutOutsList(team){
                this.idOfTeamWithPicturesCarouselOpen = null;
                this.idOfTeamWithAchievementsListOpen = null;
                if(this.idOfTeamWithShoutOutsListOpen !== team.id) {
                    this.idOfTeamWithShoutOutsListOpen = team.id;
                    this.getShoutOutsForSelectedTeam(team);
                } else {
                    this.idOfTeamWithShoutOutsListOpen = null;
                }
            },
            isShoutOutsListOpenForTeam(team){
                return this.idOfTeamWithShoutOutsListOpen === team.id;
            },
            openShoutOutFormModal(team) {
                this.isShoutOutFormModalOpen = true;
                this.selectedTeamForShoutOutForm = team;
                this.shoutOutForm.officialTeamTarget = team['@id']
            },
            closeShoutOutFormModal() {
                this.isShoutOutFormModalOpen = false;
                this.selectedTeamForShoutOutForm = null;
                this.shoutOutForm = {
                    officialTeamTarget : '',
                    content: ''
                }
            },

            getShoutOutsForSelectedTeam(team) {
                this.$store.dispatch('promotion/getShoutOutsForSelectedTeam', team.id);
            },
            postShoutOutForm(selectedTeamForShoutOutForm){
                let validation;
                validation = this.$validator.validateAll();
                validation.then(
                    (isFormValid) => {
                        if(isFormValid) {
                            this.$store.dispatch('promotion/postOfficialTeamShoutOut', this.shoutOutForm)
                                .then (
                                    (success) => {
                                        this.getShoutOutsForSelectedTeam(selectedTeamForShoutOutForm);
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

            getAgileOptionsForTeam(team){
                let numberOfPitcuresToShowOnLargeScreen;
                let numberOfPicturesForTheTeam = team.pictures.length;

                if(numberOfPicturesForTheTeam < 3){
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
            this.getOfficialTeamsData();
        },
    }
</script>
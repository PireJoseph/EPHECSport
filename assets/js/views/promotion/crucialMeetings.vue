<style scoped>
    * {
        box-sizing: border-box;
    }

    body {
        background-color: #474e5d;
        font-family: Helvetica, sans-serif;
    }

    /* The actual timeline (the vertical ruler) */
    .timeline {
        position: relative;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* The actual timeline (the vertical ruler) */
    .timeline::after {
        content: '';
        position: absolute;
        width: 6px;
        background-color: white;
        top: 0;
        bottom: 0;
        left: 50%;
        margin-left: -3px;
    }

    /* Container around content */
    .container {
        padding: 10px 40px;
        position: relative;
        background-color: inherit;
        width: 50%;
    }

    /* The circles on the timeline */
    .container::after {
        content: '';
        position: absolute;
        width: 25px;
        height: 25px;
        right: -12px;
        background-color: white;
        border: 4px solid #FF9F55;
        top: 15px;
        border-radius: 50%;
        z-index: 1;
    }

    /* Place the container to the left */
    .left {
        left: 0;
    }

    /* Place the container to the right */
    .right {
        left: 50%;
    }

    /* Add arrows to the left container (pointing right) */
    .left::before {
        content: " ";
        height: 0;
        position: absolute;
        top: 22px;
        width: 0;
        z-index: 1;
        right: 30px;
        border: medium solid white;
        border-width: 10px 0 10px 10px;
        border-color: transparent transparent transparent white;
    }

    /* Add arrows to the right container (pointing left) */
    .right::before {
        content: " ";
        height: 0;
        position: absolute;
        top: 22px;
        width: 0;
        z-index: 1;
        left: 30px;
        border: medium solid white;
        border-width: 10px 10px 10px 0;
        border-color: transparent white transparent transparent;
    }

    /* Fix the circle for containers on the right side */
    .right::after {
        left: -13px;
    }

    /* The actual content */
    .content {
        padding: 20px 30px;
        background-color: white;
        position: relative;
        border-radius: 6px;
    }

    hr {
        border-color: gray;
    }
    .detail-section {
        border-bottom: 1px solid lightgray;
        display: flex;
        justify-content: space-between;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .detail-section-list {
        border-bottom: 1px solid lightgray;
        display: flex;
        justify-content: space-between;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .detail-label {
        color: gray;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 10px;
    }

    .detail-value {
        display: flex;
        align-items: flex-end;
        justify-content: flex-end;
        align-self: flex-end;
        padding: 10px;
    }

    .detail-label-list {
        color: gray;
        flex: 1;
        display: flex;
        padding: 10px;

    }

    .detail-value-list {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: flex-end;
        padding: 10px;
    }

    /* Media queries - Responsive timeline on screens less than 600px wide */
    @media screen and (max-width: 600px) {
        /* Place the timelime to the left */
        .timeline::after {
            left: 31px;
        }

        /* Full-width containers */
        .container {
            width: 100%;
            padding-left: 70px;
            padding-right: 25px;
        }

        /* Make sure that all arrows are pointing leftwards */
        .container::before {
            left: 60px;
            border: medium solid white;
            border-width: 10px 10px 10px 0;
            border-color: transparent white transparent transparent;
        }

        /* Make sure all circles are at the same spot */
        .left::after, .right::after {
            left: 18px;
        }

        /* Make all right containers behave like the left ones */
        .right {
            left: 0%;
        }

        .detail-section-list, .detail-section{
            flex-direction: column;
        }

        .detail-value, .detail-value-list {
            padding-top: 0;
        }
    }

    #timelineContainer{
        flex-grow: 1;
    }

</style>

<template>

    <div id="timelineContainer">

        <div class="w3-card w3-round w3-white w3-padding-32 w3-hide-small">
            <h3>Rencontres importantes</h3>
        </div>

        <div v-show="!!crucialMeetings" class="timeline w3-padding-32">

            <div v-for="(meeting, index) in crucialMeetings" :key="meeting.id" class="container left" :class="getClassFollowingIndex(index)">
                <div class="content">
                    <h5>{{meeting.label}}</h5>
                    <p>{{ getFormatedDateString(meeting.startAt) }}</p>
                    <!--Detail Btn-->
                    <button
                            class="w3-button w3-small w3-white w3-border"
                            @click="showParticipationDetails(meeting.id)"
                    >
                        Détails
                    </button>

                </div>
            </div>

        </div>


        <!--Details Modal-->
        <div class="w3-modal" style="display: block;" v-show="modalOpen">
            <div class="w3-modal-content w3-animate-opacity">

                <header class="w3-container w3-theme-d1">
                    <span @click="closeModal" class="w3-button w3-display-topright">&times;</span>
                    <h2 class="w3-padding w3-container">{{ selectedCrucialMeeting.label }}</h2>
                </header>

                <div id="activityDetails" class="w3-container w3-padding-32">

                    <div class="w3-container detail-section w3-padding">
                        <span class="detail-label">
                            <i class="fa fa-map-marker w3-margin-right" aria-hidden="true"></i> Lieu :
                        </span>
                        <span class="detail-value">
                             {{selectedCrucialMeeting.location.label}} {{selectedCrucialMeeting.location.city}}
                        </span>
                    </div>

                    <div class="w3-container detail-section w3-padding">
                        <span class="w3-left detail-label">
                            <i class="far fa-clock w3-margin-right"></i> Heure :
                        </span>
                        <span class="detail-value">
                            {{ getFormatedDateString(selectedCrucialMeeting.startAt) }}
                        </span>
                    </div>

                    <div v-if="selectedCrucialMeeting.comment" class="w3-container detail-section w3-padding">
                        <span class="w3-left detail-label">
                            <i class="fa fa-pencil w3-margin-right" aria-hidden="true"></i> Commentaire :
                        </span>
                        <span class="detail-value">
                            {{selectedCrucialMeeting.comment}}
                        </span>
                    </div>

                    <!--Sports-->
                    <div v-show="!!selectedCrucialMeeting.sports && !!selectedCrucialMeeting.sports.length " class="w3-container detail-section-list w3-padding">
                        <span class="detail-label-list">
                             <i class="fa fa-futbol-o w3-margin-right" aria-hidden="true"></i> Sports :
                        </span>
                        <ul class="w3-ul detail-value-list">
                            <li v-for="sport in selectedCrucialMeeting.sports" :key="sport.id">
                                {{sport.label}}
                            </li>
                        </ul>
                    </div>
                    <!--EmeritusSportmen-->
                    <div v-show="!!selectedCrucialMeeting.emeritusSportMen && !!selectedCrucialMeeting.emeritusSportMen.length " class="w3-container detail-section-list w3-padding">
                        <span class="detail-label-list">
                             <i class="fa fa-user w3-margin-right" aria-hidden="true"></i>  Participants :
                        </span>
                        <ul class="w3-ul detail-value-list">
                            <li v-for="sportMan in selectedCrucialMeeting.emeritusSportMen" :key="sportMan.id" >
                                {{sportMan.firstName}} <span v-if="!!sportMan.nickName">'{{sportMan.nickName}}'</span> {{sportMan.lastName}} - {{sportMan.role}}
                            </li>
                        </ul>
                    </div>
                    <!--OfficialTeams-->
                    <div v-show="!!selectedCrucialMeeting.officialTeams && !!selectedCrucialMeeting.officialTeams.length " class="w3-container detail-section-list w3-padding">
                         <span class="detail-label-list">
                             <i class="fa fa-users w3-margin-right" aria-hidden="true"></i> Equipe :
                        </span>
                        <ul class="w3-ul detail-value-list">
                            <li v-for="team in selectedCrucialMeeting.officialTeams" :key="team.id">
                                <span v-if="team.sortName">({{team.sortName}})</span> {{team.name}} <span v-if="!!team.nickName"> - {{team.nickName}}</span>
                            </li>
                        </ul>
                    </div>


                </div>

                <footer class="w3-container w3-theme-d1 w3-padding-24">
                    <button type="button" class="w3-button w3-white w3-border" @click="closeModal">Fermer</button>
                </footer>

            </div>
        </div>



    </div>


</template>


<script>

    import {mapGetters, mapState} from "vuex";
    import moment from "moment"

    export default {
        name: 'crucial-meetings',
        data() {
            return {
                modalOpen : false,
                selectedCrucialMeeting : {
                    label : '',
                    comment : '',
                    startAt : '',
                    endAt : '',
                    location : {
                        label : '',
                        city : '',
                    },
                    sports : [
                        {
                            label : ''
                        }
                    ],
                    emeritusSportMen : [
                        {
                            firstName : '',
                            lastName : '',
                            nickName : '',
                            role : ''
                        }
                    ],
                    officialTeams : [
                        {
                            name: '',
                            sortName : '',
                            nickName: '',
                            label: ''
                        }
                    ]

                }
            }
        },
        computed: {

            ...mapGetters({
                crucialMeetings : 'promotion/crucialMeetings'

                // userId: 'user/userId'
            }),
            // ...mapState({
            //     crucialMeetings : 'promotion/crucialMeetings'
            // })

        },
        methods: {
            getCrucialMeetingsData() {
                this.$store.dispatch('promotion/getCrucialMeetingsData')
            },
            getClassFollowingIndex(index) {
                if ((index%2) === 0) {
                    return 'left'
                }
                return 'right'
            },
            getFormatedDateString(dateString) {
                return moment(dateString).format('Do MMMM YYYY, hh:mm')
            },
            showParticipationDetails(crucialMeetingId){
                this.crucialMeetings.map((meeting)=>{
                    if(meeting.id === crucialMeetingId ) {
                        this.selectedCrucialMeeting = meeting;
                    }
                });
                this.modalOpen = true;
            },
            closeModal() {
                this.modalOpen = false;
            }

        },
        mounted() {
            this.getCrucialMeetingsData();
        },
    }
</script>
<template>

    <div>
        <div class="w3-card w3-round w3-white w3-padding-32">
            <h1>Autre membres</h1>
        </div>


        <div class="w3-card w3-round w3-white w3-padding-32 w3-margin-top w3-container">
            <vue-good-table
                    :columns="header"
                    :rows="itemsArray"
                    :fixed-header="true"
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

                  <button v-if="!props.row.isMyPartner" class="w3-button w3-grey w3-small" @click="addToPreferredPartners(props.row['@id'].split('/').pop())">Ajouter aux partenaires</button>
                  <button v-if="props.row.isMyPartner" class="w3-button w3-red w3-small" @click="removeFromPreferredPartners(props.row['@id'].split('/').pop())">Retirer des partenaires</button>

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

    </div>

</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: 'other-members',

        data() {
            return {

                header: [
                    {
                        label: 'Actions',
                        field: 'after',
                        html: true,
                        filterable: false,
                        globalSearchDisabled: true,
                    },
                    {
                        label: 'Classe',
                        field: 'schoolClass',
                        filterable: true,
                    },
                    {
                        label: 'Nom d\'utilisateur',
                        field: 'username',
                        filterable: true,
                    },


                ],

            }
        },
        computed: {
            itemsArray() {
                let editedArray = [];

                this.$store.state.user.otherProfiles.map(function(e) {
                        e['action'] = '';
                        editedArray.push(e);
                    }
                )

                console.log(editedArray)
                return editedArray
            },
            ...mapGetters({
                otherProfiles: 'user/otherProfiles',
            })

        },
        methods: {

            addToPreferredPartners(id) {
                console.log(id)
            },
            removeFromPreferredPartners(id) {
                console.log(id)
            },
            getOtherMemberData() {
                this.$store.dispatch('user/getOtherMembers')
            },

        },
        mounted() {
            this.getOtherMemberData()
        },
    }
</script>
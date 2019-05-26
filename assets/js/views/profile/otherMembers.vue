<style scoped>

</style>

<template>

    <div>
        <div class="w3-card w3-round w3-white w3-padding-32 w3-hide-small">
            <h3>Autre membres</h3>
        </div>


        <div class="w3-card w3-round w3-white w3-padding-32 w3-margin-top w3-container">

            <vue-good-table
                    :columns="header"
                    :rows="otherProfiles"
                    :fixed-header="true"

                    :search-options="{
                        enabled: true,
                        trigger: 'enter',
                        skipDiacritics: true,
                        placeholder: 'Rechercher'
                    }"
            >
           <template slot="table-row" slot-scope="props">

                <span v-if="props.column.field == 'after'">

                  <button v-if="!props.row.isMyPartner" class="w3-button w3-green w3-small" @click="addToPreferredPartners(props.row['@id'].split('/').pop())">
                      <i class="fa fa-plus" aria-hidden="true"></i>
                      <span class="w3-hide-small w3-hide-medium"> Ajouter aux partenaires</span>
                  </button>

                  <button v-if="props.row.isMyPartner" class="w3-button w3-red w3-small" @click="removeFromPreferredPartners(props.row['@id'].split('/').pop())">
                      <i class="fa fa-minus" aria-hidden="true"></i>
                      <span class="w3-hide-small w3-hide-medium"> Ajouter aux partenaires</span>
                  </button>

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
                        label: 'Nom d\'utilisateur',
                        field: 'username',
                        filterable: true,
                    },
                    {
                        label: 'Classe',
                        field: 'schoolClass',
                        filterable: true,
                    },
                    {
                        label: 'Partenaire',
                        field: 'after',
                        html: true,
                        filterable: false,
                        globalSearchDisabled: true,
                    },
                ],

            }
        },
        computed: {
            ...mapGetters({
                otherProfiles: 'user/otherProfiles',
            })

        },
        methods: {

            addToPreferredPartners(id) {
                let payload = {};
                let userId = {
                    userId: this.$store.getters['user/userId'],
                };
                payload.preferredPartnerId = id;
                this.$store.dispatch('user/addPreferredPartner', payload)
                .then(() => {
                    this.$store.dispatch('common/loadBaseData', userId)
                })
                .then(()=> {
                    this.$store.dispatch('user/getOtherMembers')
                })

            },
            removeFromPreferredPartners(id) {
                let payload = {};
                let userId = {
                    userId: this.$store.getters['user/userId'],
                };
                payload.preferredPartnerId = id;
                this.$store.dispatch('user/removePreferredPartner', payload)
                .then(() => {
                    this.$store.dispatch('common/loadBaseData', userId)
                })
                .then(()=> {
                    this.$store.dispatch('user/getOtherMembers')
                })
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
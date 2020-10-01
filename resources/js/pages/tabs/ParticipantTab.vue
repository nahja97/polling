<template>
    <div id="page-participant">
        <md-dialog :md-active.sync="showCreateParticipant" class="dialog-participant">
            <md-dialog-title>Add Participant</md-dialog-title>
            <div class="form-dialog">
                <md-field :class="messageClass">
                    <label>Name</label>
                    <md-input type="text" v-model="name" required></md-input>
                    <span class="md-error" v-if="errorsName">must be filled</span>
                </md-field>


                <md-field :class="messageClass">
                    <label>Email</label>
                    <md-input type="email" v-model="email" required></md-input>
                    <span class="md-error" v-if="errorsEmail">must be filled email format</span>
                </md-field>


                <md-button class="md-raised md-accent" @click="showCreateParticipant = false">Close</md-button>
                <md-button class="md-raised md-accent" @click="createParticipant">Submit</md-button>
            </div>
        </md-dialog>

        <md-table v-model="searched" md-sort="id" md-sort-order="asc" md-card class="list-participants" md-fixed-header>
            <md-table-toolbar>
                <h1 class="md-title">List Participants</h1>

                <md-button class="md-raised md-accent" @click="showCreateParticipant = true">Add Participant</md-button>

                <md-field md-clearable class="md-toolbar-section-end">
                    <md-input placeholder="Search by name..." v-model="search" @input="searchOnTable" />
                </md-field>
            </md-table-toolbar>


            <md-table-empty-state
                md-label="Not Found"
                md-description="Your participant data not found or you haven't participant data.">
                <md-button class="md-primary md-raised" @click="showCreateParticipant = true">Add participants</md-button>
            </md-table-empty-state>

            <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
                <md-table-cell md-label="Name" md-sort-by="name">{{ item.name }}</md-table-cell>
                <md-table-cell md-label="Email" md-sort-by="email">{{ item.email }}</md-table-cell>
                <md-table-cell md-label="Status" md-sort-by="status">{{ item.status }}</md-table-cell>
            </md-table-row>
        </md-table>
        <md-snackbar class="alert alert-danger" :md-position="position" :md-duration="isInfinity ? Infinity : duration" :md-active.sync="showSnackbar" md-persistent>
            <span>{{ feedback }}</span>
            <md-button class="md-primary" @click="showSnackbar = false">Close</md-button>
        </md-snackbar>
    </div>
</template>
<script>
    import $axios from '../../api.js'
    const toLower = text => {
        return text.toString().toLowerCase()
    }
    const searchByName = (items, term) => {
        if (term) {
            return items.filter(item => toLower(item.name).includes(toLower(term)))
        }

        return items
    }
    export default {
        data: () => ({
            participants: [],
            loading: false,
            search: null,
            searched: [],
            showCreateParticipant: false,
            name: '',
            email: '',
            errorsEmail: false,
            errorsName: false,
            showSnackbar: false,
            position: 'left',
            duration: 4000,
            isInfinity: false,
            feedback: ''
        }),
        created() {
            $axios.get('/guests').then(participants => {
                this.participants = participants.data.data;
                this.searched = this.participants;
                this.loading = false;
            });
        },
        methods: {
            searchOnTable: function() {
                this.searched = searchByName(this.participants, this.search)
                console.log(this.searched)
            },
            createParticipant: function() {
                let data = {
                    name: this.name,
                    email: this.email
                }

                if(!this.errorsName && !this.errorsEmail){
                    this.loading = true;

                    $axios.post('guests/create', data)
                        .then((response) => {
                            if (response.data.status == 'success') {
                                this.feedback = response.data.message
                                this.showSnackbar = true
                                $axios.get('/guests').then(participants => {
                                    this.participants = participants.data.data;
                                    this.searched = this.participants;
                                });
                            } else {
                                this.feedback = "Unsuccessfully Update Message"
                                this.showSnackbar = true
                            }
                        })
                }
            }
        },
        computed: {
            messageClass () {
                if (!/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(this.email))
                {
                    this.errorsEmail = true
                }else{
                    this.errorsEmail = false
                }

                if(this.name == ''){
                    this.errorsName = true
                }else{
                    this.errorsName = false
                }

                if(this.errorsEmail || this.errorsName){
                    return {
                        'md-invalid': true
                    }
                }
                return {
                    'md-invalid': false
                }
            }
        }

    }
</script>
<style lang="scss" scoped>
    .md-table {
        margin: 24px;
    }
    .md-field {
        max-width: 300px;
    }
    .form-dialog {
        padding: 10px;
        text-align: center;
    }
</style>

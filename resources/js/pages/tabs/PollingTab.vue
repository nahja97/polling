<template>
    <div id="page-pollings">
        <md-dialog :md-active.sync="showCreatePolling" class="dialog-participant">
            <md-dialog-title>Add Pollings</md-dialog-title>
            <div class="form-dialog">
                <md-field :class="messageClass">
                    <label>Name</label>
                    <md-input type="text" v-model="name" required></md-input>
                    <span class="md-error" v-if="errorsName">must be filled</span>
                </md-field>


                <md-field :class="messageClass">
                    <label>Description</label>
                    <md-input type="text" v-model="description"></md-input>
                </md-field>


                <md-button class="md-raised md-accent" @click="showCreatePolling = false">Close</md-button>
                <md-button class="md-raised md-accent" @click="createPolling">Submit</md-button>
            </div>
        </md-dialog>

        <md-table v-model="pollings" md-sort="id" md-sort-order="asc" md-card id="list-pollings" md-fixed-header>
            <md-table-toolbar>
                <h1 class="md-title">List Pollings</h1>
                <md-button class="md-raised md-accent" @click="showCreatePolling = true">Add Pollings</md-button>
            </md-table-toolbar>
            <md-table-empty-state
                md-icon="devices_other"
                md-label="Create your first polling item"
                md-description="Add polling item, you'll be able to add polling items for sending to participants.">
                <md-button class="md-primary md-raised" >Create polling item</md-button>
            </md-table-empty-state>
            <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
                <md-table-cell md-label="Name" md-sort-by="name">{{ item.name }}</md-table-cell>
                <md-table-cell md-label="Description" md-sort-by="description">{{ item.description }}</md-table-cell>
                <md-table-cell md-label="Voted" md-sort-by="voted">{{ (item.voted) ? item.voted : '0' }}</md-table-cell>
            </md-table-row>
        </md-table>

        <md-card>
            <md-card-header>
                <div class="md-title">Message</div>
            </md-card-header>

            <md-field>
                <label>Textarea</label>
                <md-textarea v-model="message_content" placeholder="Message"></md-textarea>
                <span class="md-helper-text">nb: the bottom line is the default for links</span>
            </md-field>

            <md-card-actions>
                <md-button class="md-raised md-accent" @click="saveMessage">Save</md-button>
            </md-card-actions>
            <md-snackbar class="alert alert-danger" :md-position="position" :md-duration="isInfinity ? Infinity : duration" :md-active.sync="showSnackbar" md-persistent>
                <span>{{ feedback }}</span>
                <md-button class="md-primary" @click="showSnackbar = false">Close</md-button>
            </md-snackbar>
        </md-card>
    </div>
</template>
<script>
    import $axios from '../../api.js'
    export default {
        data: () => ({
            pollings: [],
            loading: false,
            message_content: '',
            feedback: '',
            showSnackbar: false,
            position: 'left',
            duration: 4000,
            isInfinity: false,
            showCreatePolling: false,
            name: '',
            description: '',
            errorsName: false,
        }),
        created() {
            this.loading = true;

            $axios.get('/pollings').then(pollings => {
                this.pollings = pollings.data.data;
            });

            $axios.get('/messages').then(message => {
                this.message_content = message.data.data[0].message_content;
            });
        },
        methods: {
            saveMessage: function() {
                $axios.put('/messages/update', {message_content: this.message_content})
                    .then((response) => {
                        if (response.data.status == 'success') {
                            this.feedback = response.data.message
                            this.showSnackbar = true
                        } else {
                            this.feedback = "Unsuccessfully Update Message"
                            this.showSnackbar = true
                        }
                        resolve(response.data)
                    })
                    .catch((error) => {
                        if (error.response.status == 422) {
                            this.feedback = "error.response.message"
                            this.showSnackbar = true
                        }
                    })
            },
            createPolling: function() {
                let data = {
                    name: this.name,
                    description: this.description
                }

                if(!this.errorsName){
                    this.loading = true;

                    $axios.post('pollings/create', data)
                        .then((response) => {
                            if (response.data.status == 'success') {
                                this.feedback = response.data.message
                                this.showSnackbar = true
                                $axios.get('/pollings').then(pollings => {
                                    this.pollings = pollings.data.data;
                                    this.searched = this.pollings;
                                });
                            } else {
                                this.feedback = "Unsuccessfully Update Polling"
                                this.showSnackbar = true
                            }
                        })
                }

            }
        }
    }
</script>
<style lang="scss" scoped>
  .md-table {
    margin: 24px;
  }
  .form-dialog {
    padding: 10px;
    text-align: center;
  }
</style>

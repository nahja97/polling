<template>
    <div id="page-home">
        <md-table v-model="pollings" md-sort="id" md-sort-order="asc" md-card id="list-pollings" md-fixed-header>
            <md-table-toolbar>
                <h1 class="md-title">List Pollings</h1>
            </md-table-toolbar>

            <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
                <md-table-cell md-label="Name" md-sort-by="name">{{ item.name }}</md-table-cell>
                <md-table-cell md-label="Description" md-sort-by="description">{{ item.description }}</md-table-cell>
                <md-table-cell md-label="Voted" md-sort-by="voted">{{ (item.voted) ? item.voted : '0' }}</md-table-cell>
            </md-table-row>
        </md-table>
        <md-table v-model="searched" md-sort="id" md-sort-order="asc" md-card class="list-participants" md-fixed-header>
            <md-table-toolbar>
                <h1 class="md-title">List Participants</h1>
                <md-button class="md-raised md-accent">send email</md-button>
                <md-field md-clearable class="md-toolbar-section-end">
                    <md-input placeholder="Search by name..." v-model="search" @input="searchOnTable" />
                </md-field>
            </md-table-toolbar>

            <md-table-empty-state
                md-icon="devices_other"
                md-label="Create your first polling item"
                md-description="Add polling item, you'll be able to add polling items for sending to participants.">
                <md-button class="md-primary md-raised" >Create participants</md-button>
            </md-table-empty-state>

            <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
                <md-table-cell md-label="Name" md-sort-by="name">{{ item.name }}</md-table-cell>
                <md-table-cell md-label="Email" md-sort-by="email">{{ item.email }}</md-table-cell>
                <md-table-cell md-label="Status" md-sort-by="status">{{ item.status }}</md-table-cell>
            </md-table-row>
        </md-table>
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
            pollings: [],
            loading: false,
            search: null,
            searched: [],
        }),
        created() {
            this.loading = true;

            $axios.get('/pollings').then(pollings => {
                this.pollings = pollings.data.data;
            });

            $axios.get('/guests').then(participants => {
                this.participants = participants.data.data;
                this.searched = this.participants
            });
        },
        methods: {
            searchOnTable: function() {
                this.searched = searchByName(this.participants, this.search)
                console.log(this.searched)
            }
        }
    }
</script>
<style lang="scss" scoped>
  .md-table {
    margin: 24px;
  }
</style>

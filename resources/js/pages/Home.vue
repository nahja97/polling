<template>
    <md-tabs class="md-primary" md-alignment="left">
        <md-tab id="tab-home" md-label="Home">
            <home-tab></home-tab>
        </md-tab>
        <md-tab id="tab-pollings" md-label="Pollings">
            <polling-tab></polling-tab>
        </md-tab>
        <md-tab id="tab-participants" md-label="Participants">
            <participant-tab></participant-tab>
        </md-tab>
    </md-tabs>
</template>
<script>
    import $axios from '../api.js'
    import HomeTab from './tabs/HomeTab.vue'
    import PollingTab from './tabs/PollingTab.vue'
    import ParticipantTab from './tabs/ParticipantTab.vue'
    export default {
        data: () => ({
            participants: [],
            pollings: [],
            loading: false,
        }),
        created() {
            this.loading = true;

            $axios.get('/pollings').then(pollings => {
                this.pollings = pollings.data.data;
            });

            $axios.get('/guests').then(participants => {
                this.participants = participants.data.data;
            });
        },
        components: {
            'home-tab': HomeTab,
            'polling-tab': PollingTab,
            'participant-tab': ParticipantTab,
        }
    }
</script>
<style lang="scss" scoped>
  .md-table {
    margin: 24px;
  }
</style>

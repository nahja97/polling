<template>
    <div class="wrapper">
        <app-header v-if="isAuth" />

        <div class="content-wrapper">
            <router-view></router-view>
        </div>
        <app-footer v-if="isAuth" />
    </div>
</template>
<script>
    import Vue from 'vue'
    import { mapState, mapGetters } from 'vuex'
    import Header from './components/Header.vue'
    import Footer from './components/Footer.vue'
    import { MdButton, MdContent, MdTabs, MdProgress, MdSnackbar, MdAvatar, MdRipple, MdMenu, MdList, MdCard, MdTable, MdEmptyState, MdIcon, MdField, MdDialog } from 'vue-material/dist/components';
    import 'vue-material/dist/vue-material.min.css';
    import 'vue-material/dist/theme/default.css';

    Vue.use(MdButton)
    Vue.use(MdContent)
    Vue.use(MdProgress)
    Vue.use(MdTabs)
    Vue.use(MdSnackbar)
    Vue.use(MdAvatar)
    Vue.use(MdRipple)
    Vue.use(MdMenu)
    Vue.use(MdList)
    Vue.use(MdCard)
    Vue.use(MdTable)
    Vue.use(MdEmptyState)
    Vue.use(MdIcon)
    Vue.use(MdField)
    Vue.use(MdDialog)

    export default {
        computed: {
            ...mapState(['token']),
            ...mapGetters(['isAuth'])
        },
        components: {
            'app-header': Header,
            'app-footer': Footer
        }
    }
</script>

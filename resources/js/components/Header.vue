<script>
import { mapState, mapActions } from 'vuex'
export default {
    data() {
        return {
            login: true,
            name(){
                var data = localStorage.getItem('name');
                var initialName = "";
                data = data.split(" ");
                if(data.length == 1){
                    initialName = data[0][0]
                }else{
                    initialName = data[0][0]+data[1][0];
                }

                return initialName
            }
        }
    },
    methods: {
        // ...mapActions('auth', ['logout']),
        logout(){
            return new Promise((resolve, reject) => {
                localStorage.removeItem('token')
                localStorage.removeItem('name')
                resolve()
                login = false
            }).then(() => {
                this.$store.state.token = localStorage.getItem('token')
                this.$router.push('/login').catch(()=>{});
            })
        }
    }
}
</script>
<template>
    <header>
        <md-menu md-size="medium" md-align-trigger id="profile">
            <md-avatar class="md-avatar-icon md-accent" md-menu-trigger><md-ripple>{{this.name()}}</md-ripple></md-avatar>
            <md-menu-content>
                <md-menu-item @click="logout">Logout</md-menu-item>
            </md-menu-content>
        </md-menu>

    </header>
</template>
<style lang="scss" scoped>
  .md-ripple {
    font-size: medium
  }
</style>


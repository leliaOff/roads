<template>
    <div id="manager">

        <profile-component v-if="isLogin"></profile-component>

        <div class="cell" v-if="isLogin"><active-citizen></active-citizen></div><!--
        --><div class="cell" v-if="isLogin"><gbdd-online></gbdd-online></div>
        
        <logout-component v-if="isLogin" v-on:logout="logout"></logout-component>
        <login-component v-else v-on:login="login"></login-component>

    </div>
</template>

<script>

    import Login    from './Login.vue';
    import Logout   from './Logout.vue';
    import Profile  from './Profile.vue';
    import ActiveCitizen  from './ActiveCitizen/Index.vue';
    import GbddOnline     from './GbddOnline/Index.vue';

    export default {

        data() {
            return {
                isLogin: true,
            }
        },

        methods: {

            login() {
                this.isLogin = true;
            },

            logout() {
                this.isLogin = false;
            }

        },

        components: {
            LoginComponent      : Login,
            LogoutComponent     : Logout,
            ProfileComponent    : Profile,
            ActiveCitizen       : ActiveCitizen,
            GbddOnline          : GbddOnline
        },

    }
</script>

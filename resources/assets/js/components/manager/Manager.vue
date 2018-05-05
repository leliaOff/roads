<template>
    <div id="manager">
        <profile-component v-if="isLogin"></profile-component>
        
        <logout-component v-if="isLogin" v-on:logout="logout"></logout-component>
        <login-component v-else v-on:login="login"></login-component>

    </div>
</template>

<script>

    import Login    from './Login.vue';
    import Logout   from './Logout.vue';
    import Profile  from './Profile.vue';

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
        },

    }
</script>

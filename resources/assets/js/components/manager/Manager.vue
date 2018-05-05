<template>
    <div>
        <vue-scrollbar class="scrollbar" ref="mainScrollbar">
            <transition name="right">
                <div id="manager" v-show="showMenu">

                    <button id="menu-hide" @click="showMenu = false">свернуть меню</button>

                    <profile-component v-if="isLogin"></profile-component>

                    <div class="cell" v-if="isLogin"><active-citizen></active-citizen></div><!--
                    --><div class="cell" v-if="isLogin"><gbdd-online></gbdd-online></div>

                    <layers-list v-if="isLogin"></layers-list>

                    <div class="actions">
                        <logout-component v-if="isLogin" v-on:logout="logout"></logout-component>
                        <login-component v-else v-on:login="login"></login-component>
                    </div>

                </div>
            </transition>
        </vue-scrollbar>

        <button id="menu-show" @click="showMenu = true"><i class="fa fa-bars"></i></button>
    </div>
</template>

<script>

    import Login    from './Login.vue';
    import Logout   from './Logout.vue';
    import Profile  from './Profile.vue';
    import LayersList     from './LayersList.vue';
    import ActiveCitizen  from './ActiveCitizen/Index.vue';
    import GbddOnline     from './GbddOnline/Index.vue';    

    export default {

        data() {
            return {
                isLogin: true,
                showMenu: ($(document).width() > 640)
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
            LayersList          : LayersList,
            ActiveCitizen       : ActiveCitizen,
            GbddOnline          : GbddOnline,
        },

        mounted() {
            $(window).resize(() => {
                this.showMenu = ($(document).width() > 640);
            });
        }

    }
</script>

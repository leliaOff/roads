<template>
    <div>

        <transition name="right">

            <vue-scrollbar class="scrollbar" ref="mainScrollbar" id="manager" v-show="showMenu">
                <div>
                    <button id="menu-hide" @click="showMenu = false">свернуть меню</button>

                    <profile-component :isLogin="isLogin" v-on:logout="logout" v-on:login="login"></profile-component>

                    <div class="cell" v-if="isLogin"><active-citizen></active-citizen></div><!--
                    --><div class="cell" v-if="isLogin"><gbdd-online></gbdd-online></div>

                    <layers-list></layers-list>
                    
                </div>
            </vue-scrollbar>
        </transition>

        <button id="menu-show" @click="showMenu = true"><i class="fa fa-bars"></i></button>

    </div>
</template>

<script>

    import Profile  from './Profile.vue';
    import LayersList     from './LayersList.vue';
    import ActiveCitizen  from './ActiveCitizen/Index.vue';
    import GbddOnline     from './GbddOnline/Index.vue';    

    export default {

        components: {
            ProfileComponent    : Profile,
            LayersList          : LayersList,
            ActiveCitizen       : ActiveCitizen,
            GbddOnline          : GbddOnline,
        },

    }
</script>

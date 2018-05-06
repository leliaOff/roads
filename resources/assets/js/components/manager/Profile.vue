<template>
    <div class="profile">
        
        <div v-bind:class="{ isLogin: isLogin }">
            
            <div class="profile-content" v-if="isLogin">
                <div class="profile-image">
                    <img :src="user.image" :alt="fullName" :title="fullName" />
                </div><!--
                --><div class="profile-data">
                    <div class="profile-data-item">{{ user.lastname }}</div>
                    <div class="profile-data-item">{{ user.firstname }}</div>
                    <div class="profile-data-item">{{ user.middlename }}</div>
                </div>
            </div>

            <logout-component v-if="isLogin" v-on:logout="$emit('logout');"></logout-component>
            <login-component v-else v-on:login="$emit('login');"></login-component>

        </div>

    </div>
</template>

<script>

    import Login    from './Login.vue';
    import Logout   from './Logout.vue';

    export default {

        props: ['isLogin'],

        data() {
            return {
                user: {
                    firstname   : 'Алёна',
                    middlename  : 'Игоревна',
                    lastname    : 'Артамоненко',
                    image       : './images/woman.jpg'
                }
            }
        },

        computed: {
            
            fullName() {
                return `${this.user.lastname} ${this.user.firstname} ${this.user.middlename}`;
            }

        },

        components: {
            LoginComponent      : Login,
            LogoutComponent     : Logout,
        },

    }
</script>

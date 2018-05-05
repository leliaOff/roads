<template>
    <div>
        <div v-if="isLogin">
            <button class="login" @click="logout">выход</button>
        </div>
        <div v-else>
            <button class="login" @click="login">вход</button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isLogin: false
            }
        },

        methods: {
            login() {
                this.isLogin = true;
            },
            logout() {
                this.isLogin = false;
            },
            goToPage: function(event, namePage) {
                event.preventDefault()
                this.$router.push(namePage)
            }
        }
    }
</script>
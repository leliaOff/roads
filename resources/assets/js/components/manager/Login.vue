<template>
    <div>
        <button class="login" @click="login">вход</button>
    </div>
</template>

<script>
    export default {
        methods: {
            login() {
                this.$emit('login');
            },
            goToPage: function(event, namePage) {
                event.preventDefault()
                this.$router.push(namePage)
            }
        }
    }
</script>
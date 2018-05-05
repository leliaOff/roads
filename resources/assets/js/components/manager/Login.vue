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
        }
    }
</script>
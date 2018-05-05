<template>
    <div>
        <button class="login btn-light" @click="logout">выход</button>
    </div>
</template>

<script>
    export default {
        methods: {
            logout() {
                this.$emit('logout');
            }
        }
    }
</script>
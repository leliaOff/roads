<template>
    <div class="align-right">
        <button class="logout btn-light" @click="logout">выход</button>
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
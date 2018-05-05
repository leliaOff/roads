<template>
    <div id="manager">
        <login-component></login-component>
    </div>
</template>

<script>
    import Login from './Login.vue';
    export default {

        components: {
            LoginComponent      : Login,
        },

    }
</script>

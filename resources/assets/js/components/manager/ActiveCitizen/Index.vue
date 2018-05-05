<template>
    <div>
        <button class="action btn-light" title="Указать проблему на дороге"><i class="fa fa-exclamation"></i></button>
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
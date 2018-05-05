<template>
    <div>
        <button class="action btn-light" title="Передать данные о наршених ПДД в ГИБДД"><i class="fa fa-cab"></i></button>
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
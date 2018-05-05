<template>
    <div>
        <button class="login" v-on:click="goToPage($event, 'menu')">Вход</button>
    </div>
</template>

<script>
    export default {
        
        methods: {
            goToPage: function(event, namePage) {
                event.preventDefault()
                this.$router.push(namePage)
            }
        }
		
    }
</script>
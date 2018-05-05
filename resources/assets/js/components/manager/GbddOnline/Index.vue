<template>
    <div>
        <button class="action btn-light" title="Передать данные о наршених ПДД в ГИБДД" @click="toggleMapMode"><i class="fa fa-cab"></i></button>
        <create-form :coordinates="coordinates"></create-form>
    </div>
</template>

<script>

    import Create    from './Create.vue';

    export default {

        data() {
            return {
                coordinates: false
            }
        },

        watch: {

            '$store.state.map.feature': function(feature) {

                if(feature.type != 'gbddonline') return;
                
                this.coordinates = feature.coordinates;
                if(feature.coordinates == false) return;

                $('#createGbddOnline').modal('show');

            }

        },

        methods: {
            
            toggleMapMode() {

                this.$store.dispatch('gbddonline', {data: {
                    type: 'activecitizen', 
                    coordinates: false
                }});

                this.$store.dispatch('togleMapMode', {mode: 'draw'});
            },

        },

        components: {
            CreateForm: Create,
        },

    }
</script>
<template>
    <div>
        <button type="button" class="action btn-light" title="Создать заметку о проблеме" @click="toggleMapMode"><i class="fa fa-exclamation"></i></button>
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

                if(feature.type != 'activecitizen') return;
                
                this.coordinates = feature.coordinates;
                if(feature.coordinates == false) return;
                
                $('#createActiveCitizen').modal('show');

            }

        },
        
        methods: {
            
            toggleMapMode() {

                this.$store.dispatch('createFeature', {data: {
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
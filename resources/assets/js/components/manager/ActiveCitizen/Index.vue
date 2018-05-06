<template>
    <div>
        <button type="button" class="action btn-light" title="Создать заметку о проблеме" @click="toggleMapMode"><i class="fa fa-exclamation"></i></button>
        <create-form :coordinates="coordinates"></create-form>
    </div>
</template>

<script>
    // GET: /api/activecitizen/list
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

                this.$notify({
                    title:  'Создание заметки о проблеме',
                    text:   'Как можно более подробно опишите возникшую проблему'
                });
                
                $('#createActiveCitizen').modal('show');

            }

        },
        
        methods: {
            
            toggleMapMode() {

                if(this.$store.state.map.mode == 'default') {

                    this.$notify({
                        title:  'Создание заметки о проблеме',
                        text:   'Укажите метоположение проблемы на карте'
                    });

                    this.$store.dispatch('createFeature', {data: {
                        type: 'activecitizen', 
                        coordinates: false
                    }});

                    this.$store.dispatch('togleMapMode', {mode: 'draw'});

                } else {
                    
                    this.$notify({
                        title:  'Отмена действия',
                        text:   'Вы отменили создание заметки о проблеме'
                    });

                    this.$store.dispatch('createFeature', {data: {
                        type: '', 
                        coordinates: false
                    }});

                    this.$store.dispatch('togleMapMode', {mode: 'default'});

                }
            },

        },

        components: {
            CreateForm: Create,
        },

    }

</script>
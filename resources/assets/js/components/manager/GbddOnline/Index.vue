<template>
    <div>
        <button class="action btn-light" title="Передать данные о наршених ПДД в ГИБДД" @click="toggleMapMode"><i class="fa fa-cab"></i></button>
        <create-form :coordinates="coordinates"></create-form>
    </div>
</template>

<script>
    // POST: /api/gibddonline/list предать user_id: 1
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

                this.$notify({
                    title:  'Создание заявления',
                    text:   'Заполните заявление. Загрузите фото или видео, фиксирующие факт нарушения. Укажите регистрационный номер нарушителя и дату нарушения'
                });

                $('#createGbddOnline').modal('show');

            }

        },

        methods: {
            
            toggleMapMode() {

                this.$notify({
                    title:  'Создание заявления',
                    text:   'Укажите место нарушения ПДД на карте'
                });

                this.$store.dispatch('createFeature', {data: {
                    type: 'gbddonline', 
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
<template>
    <div>
        <button class="action btn-light gbdd-online" title="Передать данные о наршених ПДД в ГИБДД" @click="toggleMapMode"><i class="fa fa-cab"></i></button><!--
        --><button type="button" class="action btn-light gbdd-online-list" title="Список заявлений в ГИБДД"><i class="fa fa-list"></i></button>
        <create-form :coordinates="coordinates"></create-form>
        <list-dialog></list-dialog>
    </div>
</template>

<script>

    import Create    from './Create.vue';
    import ListDialog    from './List.vue';

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

                if(this.$store.state.map.mode == 'default') {

                    this.$notify({
                        title:  'Создание заявления',
                        text:   'Укажите место нарушения ПДД на карте'
                    });

                    this.$store.dispatch('createFeature', {data: {
                        type: 'gbddonline', 
                        coordinates: false
                    }});

                    this.$store.dispatch('togleMapMode', {mode: 'draw'});

                } else {
                    
                    this.$notify({
                        title:  'Отмена действия',
                        text:   'Вы отменили создание заявления в ГИБДД'
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
            ListDialog: ListDialog
        },

    }
</script>
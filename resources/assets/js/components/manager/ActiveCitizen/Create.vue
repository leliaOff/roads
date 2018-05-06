<template>
    <div>
        <!-- Modal -->
        <div class="modal fade bs-example-modal-lg" id="createActiveCitizen" tabindex="-1" role="dialog" aria-labelledby="createActiveCitizenLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="createActiveCitizenLabel">Новая заметка о проблеме</h4>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-sm-4 clearfix"><label class="input-title">Категория проблемы:</label></div>
                            <div class="col-sm-8 clearfix">
                                <select v-model="item.type">
                                    <option v-for="(type, i) in problemsTypes" :key="i" value="i">{{ type }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4 clearfix"><label class="input-title">Описание проблемы:</label></div>
                            <div class="col-sm-8 clearfix">
                                <textarea v-model="item.text"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="create()">Создать</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal" @click="close()">Закрыть окно</button>
                    </div>
                </div>
            </div>
        </div>
        <!--end of modal -->
    </div>
</template>

<script>

    export default {

        props: [ 'coordinates' ],

        data() {

            return {

                problemsTypes: {
                    1: 'яма на дороге',
                    2: 'нет тротуара',
                    3: 'нет разметки на дороге',
                    4: 'отсутствует освещение',
                    5: 'проход по тротуару невозможен',
                },
                item: {
                    type:   1,
                    text:   '',
                    files: []
                },
                
            }
        },
        
        methods: {

            create() {
                
                //Сохраняем заметку о новой проблеме на дороге
                axios.post('/api/activecitizen/create', {
                    coordinates         : this.coordinates,
                    type        : this.item.type,
                    description        : this.item.text,
                    files_uploaded : this.item.files
                }).then(response => {

                    //Очищаем данные
                    this.clean();

                    //Закрываем окно
                    $('#createActiveCitizen').modal('hide');

                    //Уведомление
                    this.$notify({
                        title:  'Заметка о проблеме создана',
                        text:   'Новая заметка о проблеме создана и добавлена на карту'
                    });

                }).catch((error) => {});

                //Удаляем рисовательный слой с карты
                this.$store.dispatch('togleMapMode', {mode: 'select'});

            },

            close() {
                this.clean();                
            },

            clean() {
                //Очищаем данные
                this.$store.dispatch('createFeature', {data: { type: '',  coordinates: false }});
                this.item.type = 1;
                this.item.text = '';

                this.$store.dispatch('togleMapMode', {mode: 'select'});
            }

        },

    }
</script>
<template>
    <div>
        <!-- Modal -->
        <div class="modal fade bs-example-modal-lg" id="createGbddOnline" tabindex="-1" role="dialog" aria-labelledby="createGbddOnlineLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="createGbddOnlineLabel">Новое заявление в ГИБДД</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-sm-4 clearfix"><label class="input-title">Текст заявления:</label></div>
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
                item: {
                    text:   '',
                }
            }
        },
        
        methods: {

            create() {
                
                //Сохраняем заметку о новой проблеме на дороге
                // axios.post('createGbddOnline', {
                //     coordinates : this.coordinates,
                //     text        : this.item.text
                // }).then(response => {

                    //Очищаем данные
                    this.clean();

                    //Закрываем окно
                    $('#createGbddOnline').modal('hide');

                //}).catch((error) => {});

                //Удаляем рисовательный слой с карты
                this.$store.dispatch('togleMapMode', {mode: 'select'});

            },

            close() {
                this.clean();
            },

            clean() {
                //Очищаем данные
                this.$store.dispatch('createFeature', {data: { type: '',  coordinates: false }});
                this.item.text = '';
                this.$store.dispatch('togleMapMode', {mode: 'select'});
            }

        },

    }
</script>
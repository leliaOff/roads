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
                            <div class="col-sm-5 clearfix"><label class="input-title">Регистрационный номер нарушителя:</label></div>
                            <div class="col-sm-7 clearfix">
                                <input v-model="item.number" placeholder="О717УУ30"/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-5 clearfix"><label class="input-title">Дата и время нарушения:</label></div>
                            <div class="col-sm-7 clearfix">
                                <input v-model="item.date" placeholder="25.09.2017 13:45"/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-5 clearfix"><label class="input-title">Текст заявления:</label></div>
                            <div class="col-sm-7 clearfix">
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
                    text    : '',
                    number  : '',
                    date    : '',
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

                    //Уведомление
                    this.$notify({
                        title:  'Заявление создано',
                        text:   'Ваше заявление успешно создано и отправлено в ГИБДД'
                    });

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
                this.item.number = '';
                this.item.date = '';
                this.$store.dispatch('togleMapMode', {mode: 'select'});
            }

        },

    }
</script>
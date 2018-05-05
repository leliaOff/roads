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

                        <div class="row">
                            <div class="col-sm-12 clearfix"><label class="input-title">Фото и/или видео нарушения:</label></div>
                            <div class="col-sm-12 clearfix">
                                <div class="row" v-for="(file, i) in item.files" :key="i">
                                    <div class="col-sm-10 clearfix">{{ file }}</div>
                                    <div class="col-sm-2 clearfix"><button class="btn btn-danger" @click="deleteFile(i)">Удалить</button></div>
                                </div>
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
                    files   : []
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
                this.item.files = [];
                this.$store.dispatch('togleMapMode', {mode: 'select'});
            },

            uploadFile() {
                
				var url = window.baseurl + '/parent/user/upload';
				const config = { headers: { 'content-type': 'multipart/form-data' } };
				
				let data = new FormData();
				data.append('file', document.getElementById('avatar').files[0]);

				this.validation= { status:	"", error: "" };

				axios.post(url, data, config).then((response) => {
					if(response.data.status == 'success') {
						this.avatar = response.data.result;
					} else {
						this.validation = response.data;
					}
                });
                
            },

            deleteFile(i) {
                this.item.files.splice(i, 1);
            },

        },

    }
</script>
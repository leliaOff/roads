<template>
    <div class="file-form">
        <div class="row" v-for="(file, i) in files" :key="i">
            <div class="col-sm-10 clearfix">{{ getFileName(file) }}</div>
            <div class="col-sm-2 clearfix"><button class="btn btn-danger" @click="deleteFile(i)">Удалить</button></div>
        </div><!--
        --><button class="add-file btn btn-success" @click="selectFiles" title="Выбрать фото или видео">Добавить фото и/или видео</button>
        <input type="file" multiple="true" class="files" @change="uploadFiles" accept="image/jpeg,image/png,image/gif,video/mp4,video/x-m4v,video/msvideo,video/avi,video/x-msvideo,video/*"/>
    </div>
</template>

<script>

    export default {

        props: ['value'],

        data() {
            return {
                files: this.value,
            }
        },

        watch: {
            files: function() {
                this.value = Object.assign({}, this.files);
            }
        },

        methods: {

            selectFiles() {
                this.$el.querySelector('input.files').click();
            },

            uploadFiles() {

                let files = this.$el.querySelector('input.files').files;
                
                var url = window.baseurl + 'uploads';
				const config = { headers: { 'content-type': 'multipart/form-data' } };
				
				let data = new FormData();
                for(let i = 0; i < files.length; i++) {
                    data.append('files[]', files[i]);
                }

				axios.post(url, data, config).then(response => {
					
                    $.each(response.data, (i, value) => {
                        this.files.push(value);
                    });

                    this.$emit('changeFiles', this.files);

				}).catch(error => {
                    // ...
                });

            },

            getFileName(filename) {
                let filenameArray = filename.split('/');
                return filenameArray[filenameArray.length - 1];
            },

            deleteFile(i) {
                this.files.splice(i, 1);
                this.$emit('changeFiles', this.files);
            }
            
        },
    }
</script>
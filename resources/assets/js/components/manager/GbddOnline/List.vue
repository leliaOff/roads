<template>
    <div>
        <!-- Modal -->
        <div class="modal fade bs-example-modal-lg" id="listGbddOnline" tabindex="-1" role="dialog" aria-labelledby="listGbddOnlineLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="listGbddOnlineLabel">Отправленные заявления в ГИБДД</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-sm-5 clearfix"><label class="input-title"></label></div>
                            <div class="col-sm-7 clearfix">
                                
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Закрыть окно</button>
                    </div>
                </div>
            </div>
        </div>
        <!--end of modal -->
    </div>
</template>

<script>

    export default {

        data() {

            return {
                items: []
            }
        },
        
        methods: {

            getList() {
                
				var url = window.baseurl + 'gibddonline/list';

				axios.post(url, {user_id: 1}).then((response) => {
				    this.items = response.data;
                });
                
            },

        },

        mounted() {
            this.getList();
        }

    }
</script>
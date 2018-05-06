<template>
    <div>
        <!-- Modal -->
        <div class="modal fade bs-example-modal-lg" id="featureInformation" tabindex="-1" role="dialog" aria-labelledby="featureInformationLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        
                        <div class="row" v-for="(item, i) in items" :key="i" v-if="item != '' && isShow(i)">
                            <div class="col-sm-6 clearfix"><label class="input-title">{{ getTitle(i) }}</label></div>
                            <div class="col-sm-6 clearfix" v-if="i == 'description'"><textarea v-model="items[i]" readonly></textarea></div>
                            <div class="col-sm-6 clearfix" v-else><input v-model="items[i]" type="text" readonly /></div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal" @click="close">Закрыть окно</button>
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
                items: {},
                aliases: {
                    'reason': 'Причина',
                    'region_code': 'Код региона',
                    'reg_code': 'Код региона',
                    'region_name': 'Регион',
                    'reg_name': 'Регион',
                    'repair_kind': 'Тип ремонта',
                    'road_code': 'Код дороги',
                    'road_name': 'Наименование дороги',
                    'road_type': 'Тип дороги',
                    'trouble_type': 'Тип проблемы',
                    'crash_type': 'Тип ДТП',
                    'crash_reason': 'Причина ДТП',
                    'crash_date': 'Дата ДТП',
                    'date': 'Дата происшествия',
                    'kind': 'Тип происшествия',
                    'performer': 'Подрядчик',
                    'description': 'Описание',
                    'work_started_at': 'Планируемая дата начала работ',
                    'work_finished_at': 'Планируемая дата окончания работ',
                    'work_actually_started_at': 'Фактическая дата начала работ',
                    'work_actually_finished_at': 'Фактическая дата окончания работ',
                },
                hidden: [
                    'id', 'lat', 'lon', 'created_at', 'updated_at', 'start_lat', 'start_lon', 'end_lat', 'end_lon'
                ]
            }
        },

        watch: {

            '$store.state.map.featureInformation': function(data) {
                this.items = data;
                if(this.items == false) return;
                $('#featureInformation').modal('show');
            },

        },

        methods: {

            close() {
                this.clean();                
            },

            getTitle(alias) {
                return this.aliases[alias] == undefined ? alias : this.aliases[alias];
            },

            isShow(alias) {
                return this.hidden.indexOf(alias) == -1 ? true : false;
            },

            clean() {
                
            }

        },

    }
</script>
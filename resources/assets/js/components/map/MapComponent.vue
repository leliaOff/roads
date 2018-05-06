<template>
    <div>
        <ol-map :layersList="layersList" :elementsList="showElementsList" :mapSetting="mapSetting"></ol-map>
    </div>
</template>

<script>

    export default {

        data() {

            let layerName = [
                'layer1', 'layer2', 'layer3'
            ];

            return {

                //Название слоёв карты
                layerName: layerName,

                /* Список слоев - меняется при изменении стиля */
                layersList: {
                    /* ДТП */
                    layer1: {
                        name: layerName[0],
                        style: { shape: { fill: { color: '#e03a1350' }, stroke: { color: '#e03a13', width: 2 }, points: 66, radius: 5, }, isLabel: false, },
                        selectedStyle: { shape: { fill: { color: '#e03a1390' }, stroke: { color: '#e03a13', width: 2 }, points: 66, radius: 8, }, isLabel: true }
                    },
                    /* ЧП */
                    layer2: {
                        name: layerName[1],
                        style: { shape: { fill: { color: '#f3853650' }, stroke: { color: '#f38536', width: 2 }, points: 66, radius: 5, }, isLabel: false, },
                        selectedStyle: { shape: { fill: { color: '#f3853690' }, stroke: { color: '#f38536', width: 2 }, points: 66, radius: 8, }, isLabel: true }
                    },
                    /* Ремонты дорог */
                    layer3: {
                        name: layerName[2],
                        style: { fill: { color: '#39d64e50' }, stroke: { color: '#39d64e', width: 1 }, isLabel: false, },
                        selectedStyle: { fill: { color: '#39d64e80' }, stroke: { color: '#39d64e', width: 2 }, isLabel: true, }
                    },
                    //TODO: народный контроль - layer4
                }, 

                /* Сами геоэлементы */
                elementsList:       [],

                mapSetting: {}

            }
        },

        computed: {
            
            /* Скрыть элементы слоя и показать */
            showElementsList() {

                let elements = [];
                let selectedLayers = this.$store.state.map.selectedLayers;

                $.each(this.elementsList, (i, item) => {
                    if(selectedLayers.indexOf(item.layer) != -1) {
                        elements.push(item);
                    }
                });

                return elements;
            }

        },

        watch: {

            '$store.state.map.mode': function(mode) {
                
                if(mode == 'draw') {
                    this.drawMode();
                } else {
                    this.selectMode();
                }

            },

        },

        methods: {

            drawMode() {

                let layers = Object.assign({}, this.layersList);             
                
                //Слой для редактирования геоэлементов
                layers['editor'] = {
                    name: 'editor',
                    modify: { 
                        type: 'Point',
                        interactions: {
                            draw: {
                                drawend: (e) => {
                                    this.addFeature(e.feature);
                                }
                            },
                            snap: { }
                        }
                    },
                    style: {
                        fill: { color: '#f62496' },
                        stroke: { color: '#f62496', width: 1 },
                        shape: { fill: { color: '#f62496' }, stroke: { color: '#f62496', width: 1 }, points: 66, radius: 10, angle: 0 }
                    }
                };

                this.layersList = Object.assign({}, layers);
                
            },

            selectMode() {

                let layers = Object.assign({}, this.layersList);
                delete layers['editor'];
                this.layersList = Object.assign({}, layers);

            },

            /* Добавить новый геоэлемент */
            addFeature(feature) {
                
                //Получаем и трансформируем координаты
                let coordinates_4326 = feature.getGeometry().getCoordinates();
                let coordinates = [ol.proj.transform(coordinates_4326, 'EPSG:3857', 'EPSG:4326')];
                this.$store.dispatch('createFeature', {data: {
                    type: this.$store.state.map.feature.type, 
                    coordinates: coordinates
                }});
            },

            runGeolocation() {
                let self = this;
                var timerId = setInterval(function() {
                    navigator.geolocation.getCurrentPosition(
                        function geolocationSuccess(position) {
                            self.mapSetting = [position.coords.latitude, position.coords.longitude];
                        },     
                        (positionError) => {
                            console.log(`Ошибка геолокации: ${positionError}`);
                            clearTimeout(timerId);
                        }, {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 60000}
                        );
                }, 2000);
            },

        },

        created() {
            
            let self = this;
            
            //Ремонт на дорогах
            axios.get('./get_road_works').then(function (response) {
                
                let layers = self.elementsList;
                self.elementsList = layers.concat(response.data);

            });
            
            //Аварийность 
            axios.get('./get_road_accidents').then(function (response) {
             
                let layers = self.elementsList;
                self.elementsList = layers.concat(response.data);

            });

            //ЧП 
            axios.get('./get_road_emergencies').then(function (response) {
             
                let layers = self.elementsList;
                self.elementsList = layers.concat(response.data);

            });
        },

        mounted() {
            this.runGeolocation();
        },

    }
</script>
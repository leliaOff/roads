<template>
    <div>
        <ol-map :layersList="layersList" :elementsList="showElementsList" :mapSetting="mapSetting"></ol-map>
        <feature-information></feature-information>
        <div id="positions"><i class="fa fa-dashboard"></i> {{speed}} км/ч <i class="fa fa-map-marker"></i> {{lat.toFixed(5)}} {{lon.toFixed(5)}}</div>
    </div>
</template>

<script>

    import FeatureInformation from './FeatureInformation.vue';

    export default {

        data() {

            let layerName = [
                'layer1', 'layer2', 'layer3', 'layer4'
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
                    /* Народный контроль */
                    layer4: {
                        name: layerName[3],
                        style: { shape: { fill: { color: '#FFEF00' }, stroke: { color: '#FFEF00', width: 2 }, points: 66, radius: 5, }, isLabel: false, },
                        selectedStyle: { shape: { fill: { color: '#FFF555' }, stroke: { color: '#FFF555', width: 2 }, points: 66, radius: 8, }, isLabel: true }
                    },
                }, 

                /* Сами геоэлементы */
                elementsList:       [],
                lat: 45.235,
                lon: 54.2644,
                mapSetting: {},
                speed: 0,
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
                let timer = 0;
                let oldLat, oldLon = 0;
                let newLat, newLon = 0;
                var timerId = setInterval(function() {
                    navigator.geolocation.getCurrentPosition(
                    function geolocationSuccess(position) {
                        self.lat = position.coords.latitude;
                        self.lon = position.coords.longitude;
                        self.mapSetting = [position.coords.latitude, position.coords.longitude];
                        if (timer % 5 == 0 && timer != 0) {
                            let dis = google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(position.coords.latitude, position.coords.longitude), new google.maps.LatLng(oldLat, oldLon))
                            oldLon = position.coords.longitude;
                            oldLat = position.coords.latitude;
                            self.speed = (dis / 1000) / 12;
                            console.log('скорость', self.speed);
                        } 
                        if (timer == 0) {
                            oldLon = position.coords.longitude;
                            oldLat = position.coords.latitude;
                        }
                        timer = timer + 1;
                    },     
                    function geolocationFailure(positionError) {
                        timer = timer + 1;
                        console.log("Ошибка геолокации");
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

            //народный контроль
            axios.get('./api/activecitizen/list').then(function (response) {

                let layers = self.elementsList;
                self.elementsList = layers.concat(response.data);

            });
        },

        mounted() {
            this.runGeolocation();
        },

        components: {
            FeatureInformation: FeatureInformation,
        },

    }
</script>
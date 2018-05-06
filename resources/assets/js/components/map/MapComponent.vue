<template>
    <div>
        <ol-map :layersList="layersList" :elementsList="elementsList" :mapSetting="mapSetting"></ol-map>
        <div style="position: absolute; bottom: 0px; right: 0px; z-index: 5000; padding: 10px; color: white;">Скорость {{speed}} км./ч.</div>
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
                    layer1: {
                        name: layerName[0],
                        style: {
                            fill: {
                                color: '#24f636'
                            },
                            stroke: {
                                color: '#24f636',
                                width: 1
                            },
                            shape: {
                                fill: {
                                    color: '#24f636'
                                },
                                stroke: {
                                    color: '#24f636',
                                    width: 1
                                },
                                points: 4,
                                radius: 10,
                                angle: 0
                            }
                        }
                    },
                    layer2: {
                        name: layerName[1],
                        style: {
                            fill: {
                                color: '#f62496'
                            },
                            stroke: {
                                color: '#f62496',
                                width: 1
                            },
                            shape: {
                                fill: {
                                    color: '#f62496'
                                },
                                stroke: {
                                    color: '#f62496',
                                    width: 1
                                },
                                points: 4,
                                radius: 10,
                                angle: 0
                            }
                        }
                    },
                    layer3: {
                        name: layerName[2],
                        style: {
                            fill: {
                                color: 'rgba(255, 0, 0, 0.1)'
                            },
                            stroke: {
                                color: 'rgb(255, 0, 0)',
                                width: 1
                            },
                            shape: {
                                fill: {
                                    color: 'rgba(255, 0, 0, 0.1)'
                                },
                                stroke: {
                                    color: 'rgb(255, 0, 0)',
                                    width: 1
                                },
                                points: 4,
                                radius: 10,
                                angle: 0
                            }
                        }
                    },
                    //TODO: народный контроль - layer4
                }, 

                /* Сами геоэлементы */
                elementsList: [],

                mapSetting: {},
                speed: 0,
            }
        },

        created() {
            let self = this;
            
            //Ремонт на дорогах
            axios.get('./get_road_works')
            .then(function (response) {
                
                let layers = self.elementsList;
                self.elementsList = layers.concat(response.data);

            });
            
            //Аварийность 
            axios.get('./get_road_accidents')
            .then(function (response) {
             
                let layers = self.elementsList;
                self.elementsList = layers.concat(response.data);

            });
        },
        watch: {

            '$store.state.map.mode': function(mode) {
                
                if(mode == 'draw') {
                    this.drawMode();
                } else {
                    this.selectMode();
                }

            }

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
            }

        },

        mounted() {
            this.runGeolocation();
        }
    }
</script>
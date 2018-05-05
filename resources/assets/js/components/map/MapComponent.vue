<template>
    <div>
        <ol-map :layersList="layersList" :elementsList="elementsList"></ol-map>
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
                    }
                }, 

                /* Сами геоэлементы */
                elementsList: []

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
        }

    }
</script>

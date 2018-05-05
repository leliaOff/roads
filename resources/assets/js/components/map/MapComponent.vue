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

                data: [],

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
                elementsList: [
                    {
                        id: 1,
                        coordinates: [48.036666, 46.348826],
                        type: 'point',
                        name: 'Элемент 1',
                        layer: layerName[0]
                    },
                    {
                        id: 2,
                        coordinates: [48.035666, 46.349826],
                        type: 'point',
                        name: 'Элемент 2',
                        layer: layerName[0]
                    },
                    {
                        id: 3,
                        coordinates: [48.037666, 46.347826],
                        type: 'point',
                        name: 'Элемент 3',
                        layer: layerName[1]
                    },
                    {
                        id: 5,
                        coordinates: [[78.104434, 65.970212],[78.104634, 65.970412],[78.08259, 65.973831],[78.08059, 65.973631]],
                        type: 'MultiPolygon',
                        name: 'Элемент 5',
                        layer: layerName[2]
                    },
                ]

            }
        },

        created() {
            let self = this;
            axios.get('./get_data')
            .then(function (response) {
                self.data = response.data;
                // self.elementsList = 
            });
        }

    }
</script>

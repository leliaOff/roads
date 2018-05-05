<template>
    <div>
        <ol-map :layersList="layersList" :elementsList="elementsList"></ol-map>
    </div>
</template>

<script>

    export default {

        data() {

            let layerName = [
                'layer1', 'layer2'
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
                ]

            }
        },

    }
</script>

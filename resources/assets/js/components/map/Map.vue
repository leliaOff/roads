<template>
    <div id="map"></div>
</template>

<script>

    export default {

        name: 'map-component',

        props: {

            /* Параметры инициализации карты */
            mapSetting:            {},
            
            /* Список слоев для карты. Поля:
                - name
                - style
            */
            layersList:             {},

            /* Список элементов для карты. Поля:
                - id
                - layer
                - coordinates
                - type
                - name
            */
            elementsList:           {},

            /* Выделенный элемент */
            selectedElement:        false
        },

        data() {
            
            return {
                selector:           'map',
                map:                false,      //Карта
                view:               false,      //Вьюха
                layers:             {},         //Список слоев ol.layer
                features:           {},         //Список геоэлементов
                
                //Интерактивный слой
                modify:             {
                    modify:     false,
                    layer:      '',
                    interactions:       {
                        draw: false,
                        snap: false
                    }
                }
                
            }

        },

        watch: {

            //Изменение в составе слоев
            layersList: {
                handler(newLayersList){                    
                    //Обновление списка слоев
                    this.layersListUpdate(newLayersList);                    
                },
                deep: true
            },

            //Изменили состав геоэлементов
            elementsList: function(newElementsList) {
                console.log('elementsListUpdate', newElementsList);
                //Обновление списка элементов
                this.elementsListUpdate(newElementsList);

            },

            //Изменили зум
            zoom: function(newZoom) {
                this.map.getView().setZoom(newZoom);
            },

            //Изменили выделенный элемент 
            selectedElement: function(newSelectedElement) {
                this.updateSelectedElement(newSelectedElement);
            },

        },
        
        computed: {

            //Следим за зумом
            zoom() {                
                return this.$store.state.map.zoom;
            },
        },

        mounted() {

            //Иницииация карты
            this.init();

            //Обновление списка слоев
            this.layersListUpdate(this.layersList);

            //Обновление списка элементов
            this.elementsListUpdate(this.elementsList);

        },

        methods: {

            /* Создание карты */
            init() {

                let mapSetting = { // [78.104134, 65.970012] - ремонт дороги; [45.235, 54.2644] - авария
                    center: (this.mapSetting == undefined || this.mapSetting.center == undefined) ? [45.235, 54.2644] : this.mapSetting.center,
                    zoom:   (this.mapSetting == undefined || this.mapSetting.zoom == undefined)   ? 16                     : this.mapSetting.zoom,
                };
                
                //Если не найден контейнер с картой
                if($('#' + this.selector).length == 0) {
                    console.log('map container not found');
                }

                this.view = new ol.View({
                    center: ol.proj.transform(mapSetting.center, 'EPSG:4326', 'EPSG:3857'),
                    zoom: mapSetting.zoom
                });

                this.map = new ol.Map({
                    layers: [
                        new ol.layer.Tile({
                            source: new ol.source.OSM()
                        })
                    ],
                    target: this.selector,
                    controls: ol.control.defaults({
                        attributionOptions: ({
                            collapsible: false
                        })
                    }),
                    view: this.view
                });

                //Сохраняем карту в стори
                this.$store.state.map.map = this.map;

                //Сохраняем карту в стори
                this.$store.state.map.zoom = this.zoom;

            },

            /* Создание векторного слоя для рисования элементов */
            addVectorLayer(layer) {

                var source = new ol.source.Vector({ });
                
                var vectorLayer = new ol.layer.Vector({
                    source: source,
                    properties: {
                        id: layer.name
                    }
                });

                //Создаем стиль для слоя
                let style = false;
                if(layer.style != undefined) {
                    style = this.createStyle(layer.style);
                    vectorLayer.setStyle(style);
                }

                //Если слой для редактирования элементов
                if(layer.modify != undefined) {
                    //Если было повешано на другой слой - ничего не делаем
                    if(this.modify.layer == '') {
                        this.modify.layer = layer.name;
                        this.createInteractions(source, layer.modify);
                    }                 
                }

                this.map.addLayer(vectorLayer);
                return vectorLayer;
            },

            /* Создание стиля */
            createStyle(style, title = false) {
                    
                let styleProperties = {};
                if(style.stroke != undefined) styleProperties.stroke = new ol.style.Stroke(style.stroke);     //оконтовка
                if(style.fill != undefined) styleProperties.fill = new ol.style.Fill(style.fill);             //заливка
                if(style.shape != undefined) {                                                                //фигура
                    
                    let shapeProperties = {};

                    //Если выбранно 66 вершин фигуры - это окружность
                    //Почему именно 66? Потому что я так захотела
                    if(style.shape.points != undefined && style.shape.points == 66) {
                        
                        if(style.shape.stroke != undefined) shapeProperties.stroke = new ol.style.Stroke(style.shape.stroke);
                        if(style.shape.fill != undefined) shapeProperties.fill = new ol.style.Fill(style.shape.fill);
                        if(style.shape.radius != undefined) shapeProperties.radius = style.shape.radius;
                        styleProperties.image = new ol.style.Circle(shapeProperties);

                    } else if(style.shape.points != undefined) {
                        
                        shapeProperties.points = style.shape.points;
                        if(style.shape.stroke != undefined) shapeProperties.stroke = new ol.style.Stroke(style.shape.stroke);
                        if(style.shape.fill != undefined) shapeProperties.fill = new ol.style.Fill(style.shape.fill);
                        if(style.shape.radius != undefined) shapeProperties.radius = style.shape.radius;
                        if(style.shape.angle != undefined) shapeProperties.angle = style.shape.angle;
                        if(style.shape.rotation != undefined) shapeProperties.rotation = style.shape.rotation;
                        styleProperties.image = new ol.style.RegularShape(shapeProperties);

                    }
                }

                if(title) {
                    styleProperties.text = new ol.style.Text({
                        font: '16px Calibri, sans-serif',
                        fill: new ol.style.Fill({
                            color: '#ffffff'
                        }),
                        text: title,
                    });
                }

                let featureStyle = new ol.style.Style(styleProperties);
                return featureStyle;

            },

            /* Интерактивная карта */
            createInteractions(source, modify) {
                                    
                if(this.modify.modify == false) {
                    this.modify.modify = new ol.interaction.Modify({source: source});
                    this.map.addInteraction(this.modify.modify);
                }

                let self = this;
                $.each(modify.interactions, function(key, events) {
                    if(self.modify.interactions[key] != false) return 1;

                    if(key == 'draw') {
                        
                        let options = {
                            source: source,
                            type: modify.type,
                        };               
                        self.modify.interactions[key] = new ol.interaction.Draw(options);

                    } else if(key == 'snap') {
                        
                        let options = {
                            source: source
                        };
                        self.modify.interactions[key] = new ol.interaction.Snap(options);
                    }

                    //Вешаем события, если они есть
                    $.each(events, function(on, event) {
                        self.modify.interactions[key].on(on, event);
                    });

                    self.map.addInteraction(self.modify.interactions[key]);
                });
            },

            /* Добавить геоэлемент на карту */
            addFeature(element) {

                //Если нет координат - нет результата
                if(element.coordinates == undefined || element.coordinates.length == 0) {
                    return false;
                }
                
                let geometry;
                if(element.type == 'point') {
                    let coordinates = ol.proj.transform(element.coordinates, 'EPSG:4326', 'EPSG:3857');
                    geometry = new ol.geom.Point(coordinates);
                } else if(element.type == 'linestring') {
                    let coordinates = [];
                    $.each(element.coordinates, function(i, value) {
                        coordinates.push(ol.proj.transform(value, 'EPSG:4326', 'EPSG:3857'));
                    });
                    geometry = new ol.geom.LineString(coordinates);
                } else {
                    let coordinates = [];
                    $.each(element.coordinates, function(i, value) {
                        coordinates.push(ol.proj.transform(value, 'EPSG:4326', 'EPSG:3857'));
                    });
                    geometry = new ol.geom.Polygon([coordinates]);
                }

                //Создаем Элемент
                var feature = new ol.Feature({
                    geometry: geometry,
                    name: element.name == undefined ? '' : element.name
                });

                //Стиль элемента
                if(this.layersList[element.layer].style != undefined) {
                    let style = this.createStyle(this.layersList[element.layer].style, element.name);
                    feature.setStyle(style);
                }

                //Свойства геоэлемента - название слоя, название стиля
                feature.setProperties({
                    'layer_name':   element.layer,
                    'id':           element.id,
                    'type':         element.type,
                });

                //Добавляем геоэлементы на слой
                let vectorSource = this.layers[element.layer].getSource();
                vectorSource.addFeature(feature);

                return feature;

            },

            //Обновление списка слоев
            layersListUpdate(newLayersList) {
                
                let self = this;
                let currentLayersList = this.layers;
                let layers = {};

                //Какие слои исчезли
                $.each(currentLayersList, function(i, layer) {
                    if(newLayersList[i] == undefined) {
                        self.map.removeLayer(layer);

                        //Если на этот слой повешан интерактив
                        if(self.modify.layer == i) {                            
                            $.each(self.modify.interactions, function(j, item) {
                                if(item == false) return 1;
                                self.map.removeInteraction(item);
                                self.modify.interactions[j] = false;
                            });
                            self.modify.layer = '';
                            self.modify.modify = false;
                        }

                    } else {
                        //Переопределяем стиль для слоя
                        let style = self.createStyle(newLayersList[i].style);
                        layer.setStyle(style);
                        layers[i] = layer;

                        //Переопределяем стиль для каждого элемента
                        self.elementsListUpdate(self.elementsList);

                    }
                });

                //Какие слои появились
                $.each(newLayersList, function(i, layer) {
                    if(currentLayersList[i] == undefined) {
                        layers[i] = self.addVectorLayer(layer);
                    }
                });

                //Запоминаем
                this.layers = layers;

            },

            //Обновление списка элементов
            elementsListUpdate(newElementsList) {

                let self = this;
                let currentFeatures = this.features;
                let features = {};

                //Какие элементы исчезли
                $.each(currentFeatures, function(i, feature) {
                    if(newElementsList[i] == undefined) {
                        let properties = feature.getProperties();
                        let vectorSource = self.layers[properties.layer_name].getSource();
                        vectorSource.removeFeature(feature);
                    } else {
                        
                        //Стиль элемента - переопределяем
                        let style = self.createStyle(self.layersList[newElementsList[i].layer].style, newElementsList[i].name);
                        feature.setStyle(style);

                        features[i] = feature;
                    }
                });

                //Какие элементы появились на карте новые
                //let elements = {};
                $.each(newElementsList, function(i, element) {
                    if(currentFeatures[i] == undefined) {
                        features[i] = self.addFeature(element);
                    }
                });
    
                //Теперь это текущий список
                this.features = features;
            
            },

            updateSelectedElement(newSelectedElement) {

                /* Центровка на выделенном элементе */
                
                if(newSelectedElement === false) return;
                let feature = this.features[newSelectedElement.id];
                if(feature == undefined) return;
                
                this.view.animate({
                    zoom: 15,
                    center: ol.extent.getCenter(feature.getGeometry().getExtent()),
                    duration: 1000
                });

                /* Переопределяем стиль для каждого элемента */
                this.elementsListUpdate(this.elementsList);

                /* Переопределяем стилья для выделенного элемента */
                let style = this.layersList[newSelectedElement.layer].selectedStyle;
                style = this.createStyle(style, newSelectedElement.name);
                feature.setStyle(style);

            }

            /*
                TODO:
                    - функция добавления слоёв
                    - переключалка слоёв
                    - вернуть выделеный элемент
                    - вернуть геометрию выделеного элемента
                    - вернуть элемент по ИД
            */
        }
    }
</script>
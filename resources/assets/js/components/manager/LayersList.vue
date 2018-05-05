<template>
    <div class="layers-list">
        <div class="row" v-for="(layer, i) in layersList" :key="i" :title="layer.description" @click="toggleLayer(i)">
            <button v-bind:class="{ checkbox: true, fa: true, 'fa-check': layer.checked }" @click="toggleLayer(i)"></button><!--
            --><label class="layer-title">{{ layer.title }}</label>
        </div>
    </div>
</template>

<script>

    export default {

        data() {
            return {
                layersList: {
                    layer1: {
                        title: 'Открытые данные: дорожно-транспортные происшествия',
                        description: 'Дорожно-транспортные происшествия на автодорогах федерального, регионального и межмуниципального значения',
                        checked: true,
                    },                    
                    layer3: {
                        title: 'Открытые данные: дорожные работы, проводимые на автомобильных дорогах',
                        description: 'Дорожные работы, проводимые на автомобильных дорогах федерального, регионального и межмуниципального значения',
                        checked: true,
                    }, 
                    layer4: {
                        title: 'Народный контроль',
                        description: 'Проблемы граждан, нанесенные на карту',
                        checked: true,
                    }, 
                }
            }
        },

        methods: {
            toggleLayer(i) {
                this.layersList[i].checked = !this.layersList[i].checked;
            }
        },

        computed: {

        },

    }
</script>

<template>
    <div class="wrapper">
        <notifications></notifications>
        <map-component></map-component>
        <manager-component></manager-component>
    </div>
</template>

<script>

    import MapComponent from './map/MapComponent.vue';
    import ManagerComponent from './manager/Manager.vue';

    export default {

        components: {
            MapComponent        : MapComponent,
            ManagerComponent    : ManagerComponent,
        },

    }
</script>

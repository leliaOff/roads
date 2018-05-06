<template>
    <div class="wrapper">
        <notifications></notifications>
        <map-component></map-component>
        <manager-component></manager-component>
        <img src="images/logo-app.png" id="logo" />
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

import './bootstrap';
import router from './routes';
import { store } from './components/store/store';

import Map from './components/map/Map.vue';
Vue.component('map-component', Map);

let vueInstance = new Vue({
    el      : '#app',
    router  : router,
    store   : store
});

import AxiosConfigService from './components/services/requests/AxiosConfigService.js';
window.enableAxiosInterceptor = AxiosConfigService;
AxiosConfigService.axiosInterceptor(vueInstance);
window.vueInstance = vueInstance;



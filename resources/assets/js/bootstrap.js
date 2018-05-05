import Vue from 'vue';

/* Vue router */
import VueRouter from 'vue-router';
window.Vue = Vue;
Vue.use(VueRouter);

/* axios */
import axios from 'axios';
window.axios = axios;

/* Компонент для уведомлений (шаблон <notifications></notifications> находится в manager/TopMenu.vue) */
import Notifications from 'vue-notification';
Vue.use(Notifications);

window._ = require('lodash');

/* Красивый скролл */
import VueScrollbar from 'vue2-scrollbar';
Vue.component('vue-scrollbar', VueScrollbar);

try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap-sass');
} catch (e) {}

window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';



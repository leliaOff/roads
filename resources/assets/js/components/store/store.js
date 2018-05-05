import Vuex from 'vuex';

import map from './modules/map/map'; 

export const store = new Vuex.Store({
    
    state: {
        datatableSearch: '',
    },

    modules: {
        map,
    },

});
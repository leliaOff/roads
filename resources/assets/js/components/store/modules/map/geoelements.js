/* Управление переменными для работы с типами геоэлементов */
const state = {
    pointsArray: [],
    polygonsArray: [],
    linesArray: []
};

const mutations = {
    getAllGeoElements: (state, data) => {
        Vue.http.get(window.baseurl + 'list_geoelements/' + data.geoShape + '/' + data.geoTypes).then(response => {
            switch(data.geoShape) {
                case 'linestring':
                    state.linesArray = response.data.result;
                    break;
                case 'point':
                    state.pointsArray = response.data.result;
                    break;
                case 'polygon':
                    state.polygonsArray = response.data.result;

            }

            if(data.geoShape === 'gis_linestrings') {
                state.linesArray = response.data.result;
            } else if(data.geoShape === 'gis_points') {
                state.pointsArray = response.data.result;
            } else {
                state.polygonsArray = response.data.result;
            }
        });
    },


};

const actions = {
    getAllGeoElements: (context, payload) => {
        context.commit('getAllGeoElements', payload);
    }
};

export default {
    state: state,
    mutations: mutations,
    actions: actions
}

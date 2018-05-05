/* Управление переменными для работы с типами геоэлементов */
const state = {
    currentGeotype: false,
    geotypeArray: [],

    singleGeotype: {
        title: '',
        description: '',
        parent_id: 0,
        type: '',
        style: {
            fill: {
                color: '#6741d9'
            },
            stroke: {
                color: '#6741d9',
                width: 1
            },
            shape: {
                fill: {
                    color: '#6741d9'
                },
                stroke: {
                    color: '#6741d9',
                    width: 1
                },
                points: 4,
                radius: 10,
                angle: 0
            }
        }
    },

    singleGeotypeId: 0,

    singleGeotypeCreate: {
        title: '',
        description: '',
        parent_id: 0,
        type: 'point',
        style: {
            fill: {
                color: '#6741d9'
            },
            stroke: {
                color: '#6741d9',
                width: 1
            },
            shape: {
                fill: {
                    color: '#6741d9'
                },
                stroke: {
                    color: '#6741d9',
                    width: 1
                },
                points: 4,
                radius: 10,
                angle: 0
            }
        }
    }

};

const mutations = {
    
    getAllGeotypes: (state) => {
        Vue.http.get(window.baseurl + 'list_geotypes').then(response => {
            state.geotypeArray = response.data.result;
        });
    },

    getAllGeotypesTree: (state) => {
        Vue.http.get(window.baseurl + 'list_geotypes').then(response => {
            state.geotypeArray = window.iManupService.makeTree(response.data.result);
        });
    },

    getSingleGeotype: (state, geotypeId) => {
        state.singleGeotypeId = geotypeId;
        Vue.http.get(window.baseurl + 'get_geotype/' + geotypeId).then(response => {
            state.singleGeotype = response.data.result;
            if(state.singleGeotype.style === null) {
                state.singleGeotype.style = Object.assign({}, state.singleGeotypeCreate.style);
            }
        });
    },

    getCleanGeotype: (state) => {
        state.singleGeotype = state.singleGeotypeCreate;
    },

    deleteSingleGeotype: (state, geotypeId) => {
        Vue.http.get(window.baseurl + 'delete_geotype/' + geotypeId).then(response => {
            mutations.getAllGeotypes(state);
        });
    },
};

const actions = {
    
    getAllGeotypes: (context) => {
        context.commit('getAllGeotypes');
    },

    getAllGeotypesTree: (context) => {
        context.commit('getAllGeotypesTree');
    },

    getSingleGeotype: (context, payload) => {
        context.commit('getSingleGeotype', payload.geotypeId);
    },
    
    getCleanGeotype: (context, payload) => {
        context.commit('getCleanGeotype');
    },

    deleteSingleGeotype: (context, payload) => {
        context.commit('deleteSingleGeotype', payload.geotypeId);
    },
};

export default {
    state: state,
    mutations: mutations,
    actions: actions
}

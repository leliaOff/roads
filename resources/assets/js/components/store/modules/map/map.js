/* Управление переменными для работы с картой */
const state = {    
    map:            false,      //Сама карта
    zoom:           11,         //Зум
    mode:           'default',  //Режим работы карты: default - обычный, draw - рисование
    feature:        { type: '', coordinates: false }
};

const mutations = {

    /* Обновление размера карты - необходимо, когда карта в диалоговом окне и оно открывается */
    resize: (state) => {
        
        if(state.map != false) {
            state.map.updateSize();
        }
    },

    /* Переключаем режим работы карты */
    togleMapMode: (state, mode) => {
        state.mode = mode;
    },

    /* Создаем новые feature */
    createFeature: (state, data) => {
        state.feature = { type: data.type, coordinates: data.coordinates };
    },
    
};

const actions = {

    /* Обновление размера карты - необходимо, когда карта в диалоговом окне и оно открывается */
    mapUpdateResize: (context) => {
        context.commit('resize');
    },

    /* Переключаем режим работы карты */
    togleMapMode: (context, payload) => {
        context.commit('togleMapMode', payload.mode);
    },

    /* Создаем новые feature */
    createFeature: (context, payload) => {
        context.commit('createFeature', payload.data);
    },

};

export default {
    state: state,
    mutations: mutations,
    actions: actions
}

/* кластеризация: http://openlayers.org/en/latest/examples/earthquake-clusters.html?q=style */
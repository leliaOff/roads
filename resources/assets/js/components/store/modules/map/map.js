/* Управление переменными для работы с картой */
const state = {    
    map:            false,      //Сама карта
    zoom:           11,         //Зум
    mode:           'default',  //Режим работы карты: default - обычный, draw - рисование
    feature:        { type: '', coordinates: false },
    selectedLayers: [],
    featureInformation: false,
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

    /* Выбрать слой */
    selectLayers: (state, layer) => {
        state.selectedLayers.push(layer);
    },

    /* Снять выделение со слоя */
    unselectLayers: (state, layer) => {
        let i = state.selectedLayers.indexOf(layer);
        if(i == -1) return;
        state.selectedLayers.splice(i, 1);
    },

    /* Отобразить окно с описанием */
    showInformation: (state, data) => {
        state.featureInformation = Object.assign({}, data);
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

    /* Выбрать слой */
    selectLayers: (context, payload) => {
        context.commit('selectLayers', payload.layer);
    },

    /* Снять выделение со слоя */
    unselectLayers: (context, payload) => {
        context.commit('unselectLayers', payload.layer);
    },

    /* Отобразить окно с описанием */
    showInformation: (context, payload) => {
        context.commit('showInformation', payload.data);
    },

};

export default {
    state: state,
    mutations: mutations,
    actions: actions
}

/* кластеризация: http://openlayers.org/en/latest/examples/earthquake-clusters.html?q=style */
/* Управление переменными для работы с картой */
const state = {    
    map:            false,      //Сама карта
    zoom:           11,         //Зум
};

const mutations = {

    /* Обновление размера карты - необходимо, когда карта в диалоговом окне и оно открывается */
    resize: (state) => {
        
        if(state.map != false) {
            state.map.updateSize();
        }
    },
    
};

const actions = {

    /* Обновление размера карты - необходимо, когда карта в диалоговом окне и оно открывается */
    mapUpdateResize: (context) => {
        context.commit('resize');
    },

};

export default {
    state: state,
    mutations: mutations,
    actions: actions
}

/* кластеризация: http://openlayers.org/en/latest/examples/earthquake-clusters.html?q=style */
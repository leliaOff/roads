import axios from 'axios';

export default class AxiosConfigService {
    static axiosInterceptor(vueInstance) {
        window.customAxiosInterceptor = axios.interceptors.request.use(function(config) {
            // let url = config.url;
            // if(url != '' && vueInstance != undefined) {
            //     vueInstance.$store.dispatch('showLoader', { method: url });
            // }
            return config;

        }, function(error) {
            return Promise.reject(error);
        });

        axios.interceptors.response.use(function(response) {    
            // let url = response.url;
            // if(url != '' && vueInstance != undefined) {
            //     vueInstance.$store.dispatch('hideLoader', { method: url });
            // }            
            return response;        
        }, function (error) {    
            
            //Если получили статус релогина
            //if(error.response.status == 500 && error.response.data.status == 'relogin') {
                // vueInstance.$notify({
                //     title: vueInstance.$t("index.notify_relogin_title"),
                //     text: vueInstance.$t("index.notify_relogin_text")
                // });
                // setTimeout(function() { window.location = '/' }, 5000);
            //} else {                
                //let url = error.config.url;
                //if(url != '' && vueInstance != undefined) {
                //    vueInstance.$store.dispatch('hideLoader', { method: url });
                //}
            //}         
            return Promise.reject(error);
        });
    }
}
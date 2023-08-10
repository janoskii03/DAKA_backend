import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'


//外部函式庫 view-ui-plus
import ViewUIPlus from 'view-ui-plus';
import 'view-ui-plus/dist/styles/viewuiplus.css';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.min.js';
// ajax引入
import axios from 'axios';
import VueAxios from 'vue-axios';
import { URL, URL_MAC } from '@/assets/js/common.js';
import "@/assets/scss/_style.scss";


const app = createApp(App);
app.config.globalProperties.$URL = URL;
app.config.globalProperties.$URL_MAC = URL_MAC;
app.use(store);
app.use(VueAxios, axios);
app.use(ViewUIPlus);
app.use(router);
app.mount('#app');


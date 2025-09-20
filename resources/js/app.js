import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';

// Import Bootstrap CSS
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';

// Import Bootstrap JS
import * as bootstrap from 'bootstrap';

// Import axios
import axios from 'axios';
import VueAxios from 'vue-axios';

// Configurar axios
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://localhost:8000'; // URL do Laravel

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.use(VueAxios, axios);
app.provide('axios', app.config.globalProperties.axios);

app.mount('#app');

// Tornar bootstrap globalmente disponível
window.bootstrap = bootstrap;

console.log('PREGÃO Marketplace iniciado!');
import axios from 'axios';
windows.axios = axios;
windows.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
//axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

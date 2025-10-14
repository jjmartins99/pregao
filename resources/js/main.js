import { createApp } from 'vue'
import { createPinia } from 'pinia'
import router from './router/index.js'
import './css/app.css'
import DefaultLayout from './layouts/DefaultLayout.vue'

const app = createApp(DefaultLayout)
app.use(createPinia())
app.use(router)
app.mount('#app')

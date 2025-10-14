// resources/js/app.js

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { createPinia } from 'pinia'
import { InertiaProgress } from '@inertiajs/progress'
import '../css/app.css'

// Ativar barra de progresso nas transições de página
InertiaProgress.init({
  color: '#4B5563',
  showSpinner: false,
})

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    const pinia = createPinia()

    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(pinia)
      .mount(el)
  },
})

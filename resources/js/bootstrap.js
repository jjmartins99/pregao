// resources/js/bootstrap.js

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { createPinia } from 'pinia'
import { InertiaProgress } from '@inertiajs/progress'

// Inicializa a barra de progresso do Inertia
InertiaProgress.init({
  color: '#29d',
  showSpinner: true,
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

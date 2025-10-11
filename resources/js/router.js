import { createRouter, createWebHistory } from 'vue-router'

// Importação das páginas (verifica se os ficheiros existem em resources/js/Pages)
import Home from '@/Pages/Home.vue'
import About from '@/Pages/About.vue'

const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/about', name: 'about', component: About },
]

// Exportação default (para combinar com o import do main.js)
const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router

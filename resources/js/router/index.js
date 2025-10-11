import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/pages/Home.vue'
import Marketplace from '@/pages/Marketplace.vue'
import Dashboard from '@/pages/Dashboard.vue'
import NotFound from '@/pages/NotFound.vue'

const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/marketplace', name: 'marketplace', component: Marketplace },
  { path: '/dashboard', name: 'dashboard', component: Dashboard },
  { path: '/:pathMatch(.*)*', name: 'notfound', component: NotFound },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router

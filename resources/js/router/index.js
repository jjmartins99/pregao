import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue'
import About from '../pages/About.vue'
import Marketplace from '../pages/Marketplace.vue'
import Dashboard from '../pages/Dashboard.vue'
import Login from '../pages/auth/Login.vue'
import Register from '../pages/auth/Register.vue'

const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/about', name: 'about', component: About },
  { path: '/marketplace', name: 'marketplace', component: Marketplace },
  { path: '/dashboard', name: 'dashboard', component: Dashboard },
  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: Register },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router

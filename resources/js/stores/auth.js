import { defineStore } from 'pinia'
import api from '../api/axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || null,
  }),

  actions: {
    async login(credentials) {
      const { data } = await api.post('/login', credentials)
      this.token = data.token
      localStorage.setItem('token', data.token)
      await this.fetchUser()
    },
    async register(form) {
      await api.post('/register', form)
      await this.login({ email: form.email, password: form.password })
    },
    async fetchUser() {
      if (!this.token) return
      const { data } = await api.get('/user', {
        headers: { Authorization: `Bearer ${this.token}` },
      })
      this.user = data
    },
    logout() {
      this.user = null
      this.token = null
      localStorage.removeItem('token')
    },
  },
})

<template>
  <AuthLayout>
    <template #default>
      <h2 class="text-2xl font-bold text-center mb-6 text-indigo-600">Entrar</h2>
      <form @submit.prevent="login" class="space-y-4">
        <input v-model="form.email" type="email" placeholder="Email" class="w-full border rounded px-3 py-2" />
        <input v-model="form.password" type="password" placeholder="Senha" class="w-full border rounded px-3 py-2" />
        <button class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Entrar</button>
      </form>
      <p class="text-center text-sm mt-4">
        Não tem conta? <router-link to="/register" class="text-indigo-600">Registar</router-link>
      </p>
    </template>
  </AuthLayout>
</template>

<script setup>
import { reactive } from 'vue'
import { useAuthStore } from '../../store/auth'
import AuthLayout from '../../layouts/AuthLayout.vue'

const store = useAuthStore()
const form = reactive({ email: '', password: '' })
const login = async () => await store.login(form)
</script>

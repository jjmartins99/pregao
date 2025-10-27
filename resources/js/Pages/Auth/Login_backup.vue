<template>
  <div class="max-w-md mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4">Entrar</h2>
    <form @submit.prevent="submit">
      <div class="mb-3">
        <label class="block mb-1">Email</label>
        <input v-model="form.email" type="email" class="w-full border rounded p-2" required/>
      </div>
      <div class="mb-3">
        <label class="block mb-1">Password</label>
        <input v-model="form.password" type="password" class="w-full border rounded p-2" required/>
      </div>
      <div class="flex items-center justify-between">
        <button class="bg-indigo-600 text-white px-4 py-2 rounded">Entrar</button>
        <router-link to="/register" class="text-sm text-indigo-600">Registar</router-link>
      </div>
      <p v-if="error" class="text-red-600 mt-3">{{ error }}</p>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'

const auth = useAuthStore()
const router = useRouter()
const form = reactive({ email:'', password:'', remember:false })
const error = ref(null)

const submit = async () => {
  error.value = null
  try {
    await auth.login(form)
    router.push({ name: 'dashboard' })
  } catch (e) {
    error.value = e.response?.data?.message || 'Erro ao autenticar'
  }
}
</script>

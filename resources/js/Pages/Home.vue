<template>
  <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 text-center p-6">
    <div class="bg-white rounded-2xl shadow-lg p-10 max-w-lg w-full">
      <h1 class="text-4xl font-bold text-indigo-600 mb-4">
        👋 Olá, PREGÃO SPA Inertia/Vue 3 está ativo!
      </h1>
      <p class="text-gray-600 mb-8">
        Esta página está a ser renderizada com 
        <span class="font-semibold text-indigo-500">Laravel + Inertia + Vue 3 + TailwindCSS</span>.
      </p>

      <div class="space-x-3">
        <button
          @click="count++"
          class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition"
        >
          Clicar ({{ count }})
        </button>
        <button
          @click="reset"
          class="px-6 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition"
        >
          Reset
        </button>
      </div>
    </div>

    <footer class="mt-10 text-gray-500 text-sm">
      <p>© {{ new Date().getFullYear() }} PREGÃO SPA — Construído com ❤️ por JJMartins</p>
    </footer>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const count = ref(0)
const reset = () => (count.value = 0)
</script>

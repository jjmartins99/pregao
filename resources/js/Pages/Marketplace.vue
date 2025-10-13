<template>
  <AppLayout>
    <section class="py-12">
      <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">🛍 Marketplace</h1>
        <p class="text-gray-600 mt-2">
          Explora os produtos disponíveis no pregão.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4 md:px-10">
        <div
          v-for="product in products"
          :key="product.id"
          class="bg-white shadow rounded-xl p-6 hover:shadow-lg transition"
        >
          <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ product.name }}</h3>
          <p class="text-gray-600 mb-4">{{ product.description }}</p>
          <span class="inline-block bg-blue-100 text-blue-600 text-sm font-medium px-3 py-1 rounded-full">
            {{ product.price }} kz
          </span>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const products = ref([
  { id: 1, name: 'Arroz 25kg', description: 'Saco de arroz de alta qualidade', price: '12.000' },
  { id: 2, name: 'Feijão 10kg', description: 'Feijão vermelho importado', price: '8.500' },
  { id: 3, name: 'Óleo 5L', description: 'Óleo vegetal refinado', price: '7.200' },
])
</script>

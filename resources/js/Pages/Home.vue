
<template>
  <AppLayout>
    <div class="text-center py-20">
      <h1 class="text-4xl font-bold text-blue-600 mb-4">
        👋 Olá, PREGÃO SPA Inertia/Vue 3 está ativo!
      </h1>
      <p class="text-gray-700 text-lg mb-6">
        Este é o ecrã inicial do modo SPA com Vue Router + Inertia.
      </p>
      <div class="space-x-4">
        <RouterLink to="/about" class="text-blue-500 hover:underline">Sobre</RouterLink>
        <RouterLink to="/marketplace" class="text-blue-500 hover:underline">Marketplace</RouterLink>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

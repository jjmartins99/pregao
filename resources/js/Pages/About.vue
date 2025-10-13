<template>
  <AppLayout>
    <div class="max-w-3xl mx-auto text-center py-16">
      <h1 class="text-3xl font-bold text-gray-800 mb-4">Sobre o PREGÃO SPA</h1>
      <p class="text-gray-600 text-lg leading-relaxed">
        Esta é uma demonstração da arquitetura SPA com Inertia + Vue Router + Tailwind.
        Tudo é renderizado como uma aplicação única sem recarregar a página.
      </p>
      <RouterLink
        to="/"
        class="mt-6 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
      >
        Voltar à Home
      </RouterLink>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

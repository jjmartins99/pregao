<template>
  <nav class="bg-white shadow">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <router-link to="/" class="text-2xl font-bold text-indigo-600">Pregão</router-link>
      <div class="flex space-x-4">
        <router-link to="/" class="hover:text-indigo-500">Home</router-link>
        <router-link to="/marketplace" class="hover:text-indigo-500">Marketplace</router-link>
        <router-link to="/about" class="hover:text-indigo-500">Sobre</router-link>
        <router-link to="/dashboard" class="hover:text-indigo-500">Dashboard</router-link>
        <router-link to="/login" class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">Entrar</router-link>
      </div>
    </div>
  </nav>
</template>

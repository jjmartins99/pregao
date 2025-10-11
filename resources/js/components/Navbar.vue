<template>
  <header class="bg-white shadow-sm">
    <div class="container mx-auto px-4 py-4 flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <a href="/" class="text-lg font-bold text-gray-800">🛒 PREGÃO</a>
        <nav class="hidden md:flex space-x-4">
          <router-link to="/" class="text-gray-600 hover:text-gray-900">Início</router-link>
          <router-link to="/marketplace" class="text-gray-600 hover:text-gray-900">Marketplace</router-link>
          <router-link to="/dashboard" class="text-gray-600 hover:text-gray-900">Dashboard</router-link>
        </nav>
      </div>
      <div class="flex items-center space-x-3">
        <SearchBar />
        <a href="/login" class="text-sm text-gray-600 hover:text-gray-900">Login</a>
      </div>
    </div>
  </header>
</template>

<script>
import SearchBar from '@/components/SearchBar.vue'
export default {
  components: { SearchBar }
}
</script>

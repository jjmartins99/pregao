<template>
  <nav class="bg-blue-600 text-white shadow-md">
    <div class="container mx-auto flex justify-between items-center px-4 py-3">
      <RouterLink to="/" class="font-bold text-xl">PREGÃO</RouterLink>

      <ul class="flex space-x-6">
        <li><RouterLink to="/" class="hover:text-gray-200">Início</RouterLink></li>
        <li><RouterLink to="/about" class="hover:text-gray-200">Sobre</RouterLink></li>
        <li><RouterLink to="/marketplace" class="hover:text-gray-200">Marketplace</RouterLink></li>
      </ul>
    </div>
  </nav>
</template>

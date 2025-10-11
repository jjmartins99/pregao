<template>
  <header class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16 items-center">
        <div class="flex items-center">
          <a href="/" class="text-xl font-bold text-pregao-primary">🛒 PREGÃO</a>
          <nav class="hidden md:flex md:ml-6 space-x-4">
            <a href="/" class="text-gray-700 hover:text-gray-900">Início</a>
            <a href="/marketplace" class="text-gray-700 hover:text-gray-900">Marketplace</a>
            <a href="/stores" class="text-gray-700 hover:text-gray-900">Lojas</a>
          </nav>
        </div>
        <div class="flex items-center space-x-3">
          <a href="/profile" class="text-gray-700 hover:text-gray-900">Perfil</a>
          <button id="cartToggle" class="px-3 py-2 rounded bg-pregao-primary text-white">Carrinho</button>
        </div>
      </div>
    </div>
  </header>
</template>

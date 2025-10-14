<template>
  <div>
    <h2 class="text-3xl font-semibold text-indigo-600 mb-6">Marketplace</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div v-for="n in 6" :key="n" class="bg-white p-4 rounded-xl shadow hover:shadow-md">
        <h3 class="font-bold text-lg mb-2">Produto {{ n }}</h3>
        <p class="text-gray-500 text-sm mb-3">Descrição do produto {{ n }}.</p>
        <button class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">Ver Detalhes</button>
      </div>
    </div>
  </div>
</template>

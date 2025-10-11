<template>
  <div>
    <h2 class="text-2xl font-semibold mb-4">Marketplace</h2>
    <p class="text-gray-600 mb-6">Lista de produtos de exemplo</p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div v-for="p in products" :key="p.id" class="border rounded p-4">
        <h4 class="font-semibold">{{ p.name }}</h4>
        <p class="text-sm text-gray-500">{{ p.store }}</p>
        <div class="mt-3">
          <button class="bg-green-600 text-white px-3 py-1 rounded">Adicionar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return { products: [
      { id:1, name: 'Smartphone Android 128GB', store: 'TechStore Angola' },
      { id:2, name: 'T-shirt Algodão', store: 'Moda Africana' },
      { id:3, name: 'Conjunto de Panelas', store: 'Casa & Cozinha' }
    ] }
  }
}
</script>

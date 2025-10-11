<template>
  <div class="bg-white rounded-lg shadow-sm overflow-hidden h-full flex flex-col">
    <a :href="`/marketplace/products/${product.id}`" class="block">
      <img :src="product.image || '/images/placeholder-product.png'" alt="" class="w-full h-48 object-cover">
    </a>
    <div class="p-4 flex-1 flex flex-col">
      <div class="text-sm text-gray-500">{{ product.store_name }}</div>
      <h3 class="font-semibold text-lg my-2"><a :href="`/marketplace/products/${product.id}`">{{ product.name }}</a></h3>
      <div class="mt-auto flex items-center justify-between">
        <div class="text-pregao-primary font-bold">{{ formatCurrency(product.current_price) }}</div>
        <button @click="addToCart" class="text-sm bg-pregao-primary text-white px-3 py-1 rounded">Adicionar</button>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({ product: Object });
const addToCart = () => {
  const ev = new CustomEvent('productAddedToCart', { detail: { id: props.product.id, qty: 1 }});
  document.dispatchEvent(ev);
  alert('Produto adicionado (simulação)');
};
const formatCurrency = (v) => new Intl.NumberFormat('pt-AO', { style:'currency', currency:'AOA' }).format(v);
</script>

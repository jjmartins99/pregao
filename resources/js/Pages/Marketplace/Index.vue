<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Marketplace — Produtos</h1>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <ProductCard v-for="p in products" :key="p.id" :product="p" />
    </div>
  </div>
</template>

<script setup>
import ProductCard from '@/components/marketplace/ProductCard.vue';
const products = Array.from({length:12}).map((_,i)=>({
  id:i+1,name:'Produto '+(i+1),current_price:800+(i*200),store_name:'Loja '+(i%4+1),image:'/images/placeholder-product.png'
}));
</script>

<template>
  <div class="fixed right-0 top-0 h-full w-80 bg-white shadow-lg p-4" v-show="open">
    <h3 class="font-semibold mb-4">Carrinho</h3>
    <div v-if="items.length === 0" class="text-gray-500">Carrinho vazio</div>
    <div v-else>
      <div v-for="it in items" :key="it.id" class="flex items-center gap-3 mb-3">
        <img :src="it.image" class="w-12 h-12 object-cover rounded"/>
        <div class="flex-1">
          <div class="text-sm">{{ it.name }}</div>
          <div class="text-xs text-gray-500">{{ formatCurrency(it.price) }}</div>
        </div>
      </div>
      <div class="mt-4">
        <div class="flex justify-between font-semibold">Subtotal <span>{{ formatCurrency(subtotal) }}</span></div>
        <a href="/marketplace/cart" class="block mt-3 bg-pregao-primary text-white text-center py-2 rounded">Finalizar</a>
      </div>
    </div>
    <button class="absolute top-2 right-2 text-gray-500" @click="open=false">✕</button>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
const open = ref(false);
const items = ref([]);
const subtotal = computed(()=> items.value.reduce((s,i)=>s+(i.price*i.qty||1),0));
const formatCurrency = (v)=> new Intl.NumberFormat('pt-AO',{style:'currency',currency:'AOA'}).format(v);
onMounted(()=> {
  document.getElementById('cartToggle')?.addEventListener('click', ()=> open.value = true);
  document.addEventListener('productAddedToCart', (e)=> {
    items.value.push({ id: e.detail.id, name: 'Produto '+e.detail.id, price: 1000, image: '/images/placeholder-product.png', qty:1 });
  });
});
</script>

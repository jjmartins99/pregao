<template>
  <AdminLayout>
    <template #topbar>
      <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold">Admin Dashboard</h2>
      </div>
    </template>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="p-4 bg-white rounded shadow">
        <h3 class="font-semibold">Total Produtos</h3>
        <div class="text-3xl mt-2">{{ stats.products }}</div>
      </div>
      <div class="p-4 bg-white rounded shadow">
        <h3 class="font-semibold">Total Pedidos</h3>
        <div class="text-3xl mt-2">{{ stats.orders }}</div>
      </div>
      <div class="p-4 bg-white rounded shadow">
        <h3 class="font-semibold">Entregas</h3>
        <div class="text-3xl mt-2">{{ stats.deliveries }}</div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, onMounted } from 'vue';
import { useApi } from '@/composables/useApi';

const stats = ref({ products: 0, orders: 0, deliveries: 0 });

const { get } = useApi();

onMounted(async () => {
  try {
    const res = await get('/admin/stats'); // implementa rota API
    stats.value = res.data;
  } catch (e) {
    console.error(e);
  }
});
</script>

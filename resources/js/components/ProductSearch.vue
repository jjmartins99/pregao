<template>
  <div class="product-search position-relative">
    <input
      type="text"
      class="form-control"
      v-model="query"
      placeholder="🔍 Procurar produtos..."
      @input="searchProducts"
    />

    <ul v-if="results.length > 0" class="list-group position-absolute w-100 mt-1 shadow-sm">
      <li
        v-for="product in results"
        :key="product.id"
        class="list-group-item list-group-item-action d-flex align-items-center"
        @click="goToProduct(product.id)"
      >
        <img
          :src="product.image"
          class="me-2 rounded"
          alt="Imagem"
          style="width: 40px; height: 40px; object-fit: cover"
        />
        <div>
          <div class="fw-semibold">{{ product.name }}</div>
          <small class="text-muted">{{ formatCurrency(product.price) }}</small>
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref } from "vue";

const query = ref("");
const results = ref([]);

const searchProducts = async () => {
  if (query.value.length < 2) {
    results.value = [];
    return;
  }

  try {
    const response = await fetch(`/api/products/search?q=${encodeURIComponent(query.value)}`);
    results.value = await response.json();
  } catch (error) {
    console.error("Erro na busca:", error);
  }
};

const goToProduct = (id) => {
  window.location.href = `/marketplace/products/${id}`;
};

const formatCurrency = (amount) => {
  return new Intl.NumberFormat("pt-PT", {
    style: "currency",
    currency: "EUR",
  }).format(amount);
};
</script>

<style scoped>
.product-search ul {
  z-index: 1050;
}
</style>

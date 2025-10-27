<template>
  <div class="product-compare container py-4">
    <h4 class="mb-3">Comparação de Produtos</h4>

    <div v-if="products.length === 0" class="text-muted text-center py-5">
      <i class="fas fa-balance-scale fa-3x mb-3"></i>
      <p>Nenhum produto selecionado para comparação.</p>
    </div>

    <div v-else class="table-responsive">
      <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
          <tr>
            <th>Característica</th>
            <th v-for="p in products" :key="p.id">{{ p.name }}</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Imagem</td>
            <td v-for="p in products" :key="p.id">
              <img
                :src="p.image"
                class="img-fluid rounded"
                style="max-height: 120px; object-fit: cover"
              />
            </td>
          </tr>
          <tr>
            <td>Preço</td>
            <td v-for="p in products" :key="p.id">
              {{ formatCurrency(p.price) }}
            </td>
          </tr>
          <tr>
            <td>Descrição</td>
            <td v-for="p in products" :key="p.id">
              <small>{{ p.description }}</small>
            </td>
          </tr>
          <tr>
            <td></td>
            <td v-for="p in products" :key="p.id">
              <a :href="`/marketplace/products/${p.id}`" class="btn btn-sm btn-primary">
                Ver Produto
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";

const products = ref([]);

const formatCurrency = (amount) => {
  return new Intl.NumberFormat("pt-PT", {
    style: "currency",
    currency: "EUR",
  }).format(amount);
};

onMounted(() => {
  // Simples: carregar produtos selecionados do localStorage
  try {
    const stored = localStorage.getItem("pregao_compare");
    products.value = stored ? JSON.parse(stored) : [];
  } catch (e) {
    products.value = [];
  }

  document.addEventListener("productAddedToCompare", (e) => {
    products.value.push(e.detail);
    localStorage.setItem("pregao_compare", JSON.stringify(products.value));
  });
});
</script>

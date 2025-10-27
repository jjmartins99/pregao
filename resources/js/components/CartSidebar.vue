<template>
  <div class="offcanvas offcanvas-end" tabindex="-1" id="cartSidebar">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">🛒 Carrinho</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <div v-if="cart.length === 0" id="emptyCartMessage" class="text-center py-5">
        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
        <p class="text-muted">O seu carrinho está vazio</p>
      </div>

      <div id="cartItems">
        <div
          v-for="item in cart"
          :key="item.rowId"
          class="cart-item mb-3 pb-3 border-bottom"
        >
          <div class="d-flex align-items-center">
            <img
              :src="item.options.image"
              alt="Imagem"
              class="rounded me-3"
              style="width: 60px; height: 60px; object-fit: cover"
            />
            <div class="flex-grow-1">
              <h6 class="mb-1">{{ item.name }}</h6>
              <p class="text-muted small mb-1">{{ formatCurrency(item.price) }}</p>
              <div class="input-group input-group-sm" style="max-width: 120px;">
                <button class="btn btn-outline-secondary" @click="updateQty(item, -1)">-</button>
                <input
                  type="number"
                  class="form-control text-center"
                  v-model.number="item.qty"
                  @change="updateQty(item, 0, true)"
                />
                <button class="btn btn-outline-secondary" @click="updateQty(item, 1)">+</button>
              </div>
            </div>
            <button class="btn btn-sm btn-link text-danger ms-2" @click="removeItem(item)">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="offcanvas-footer p-3 border-top" v-if="cart.length > 0">
      <div class="d-flex justify-content-between mb-2">
        <span>Subtotal</span>
        <strong>{{ formatCurrency(subtotal) }}</strong>
      </div>
      <a href="/marketplace/cart" class="btn btn-primary w-100">
        Finalizar Compra
      </a>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";

const cart = ref([]);

const subtotal = computed(() =>
  cart.value.reduce((total, item) => total + item.price * item.qty, 0)
);

const updateQty = (item, change, manual = false) => {
  let newQty = manual ? item.qty : item.qty + change;
  if (newQty < 1) newQty = 1;
  item.qty = newQty;
  window.PregaoCart.updateQuantity(item.rowId, newQty);
};

const removeItem = (item) => {
  window.PregaoCart.removeItem(item.rowId);
};

const formatCurrency = (amount) => {
  return new Intl.NumberFormat("pt-PT", {
    style: "currency",
    currency: "EUR",
  }).format(amount);
};

onMounted(() => {
  // Sincronizar com cart.js
  cart.value = window.PregaoCart.items;

  document.addEventListener("cartUpdated", (e) => {
    cart.value = e.detail;
  });
});
</script>

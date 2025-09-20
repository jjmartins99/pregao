<template>
  <div class="product-card card h-100 shadow-sm">
    <div class="position-relative">
      <router-link :to="`/product/${product.id}`">
        <img 
          :src="product.image || '/images/placeholder-product.png'" 
          :alt="product.name"
          class="card-img-top product-image"
          @error="handleImageError"
        />
      </router-link>
      
      <div class="product-badges position-absolute top-0 start-0 p-2">
        <span v-if="product.is_featured" class="badge bg-warning text-dark me-1">Destaque</span>
        <span v-if="product.discount_percentage > 0" class="badge bg-danger">-{{ product.discount_percentage }}%</span>
      </div>
      
      <button 
        class="btn btn-sm btn-light position-absolute top-0 end-0 m-2 rounded-circle wishlist-btn"
        @click="toggleWishlist"
        :class="{ 'text-danger': isInWishlist }"
      >
        <i class="bi" :class="isInWishlist ? 'bi-heart-fill' : 'bi-heart'"></i>
      </button>
    </div>

    <div class="card-body d-flex flex-column">
      <div class="mb-2">
        <router-link 
          :to="`/store/${product.store_slug}`" 
          class="store-link text-muted small text-decoration-none"
        >
          {{ product.store_name }}
        </router-link>
      </div>

      <h6 class="card-title product-title">
        <router-link :to="`/product/${product.id}`" class="text-decoration-none text-dark">
          {{ product.name }}
        </router-link>
      </h6>

      <div class="mb-2">
        <div class="rating">
          <i 
            v-for="star in 5" 
            :key="star" 
            class="bi" 
            :class="star <= Math.round(product.rating) ? 'bi-star-fill text-warning' : 'bi-star text-muted'"
          ></i>
          <small class="text-muted ms-1">({{ product.review_count }})</small>
        </div>
      </div>

      <div class="mt-auto">
        <div class="price-container mb-2">
          <span class="current-price fw-bold text-primary">
            {{ formatCurrency(product.current_price) }}
          </span>
          <span v-if="product.original_price > product.current_price" class="original-price text-muted text-decoration-line-through ms-2 small">
            {{ formatCurrency(product.original_price) }}
          </span>
        </div>

        <div class="stock-status mb-2">
          <small :class="stockStatusClass">
            <i class="bi" :class="stockStatusIcon"></i>
            {{ stockStatusText }}
          </small>
        </div>

        <div class="d-grid gap-2">
          <button 
            v-if="product.stock_status !== 'out_of_stock'"
            class="btn btn-primary btn-sm"
            @click="addToCart"
            :disabled="addingToCart"
          >
            <span v-if="addingToCart">
              <span class="spinner-border spinner-border-sm me-1" role="status"></span>
              Adicionando...
            </span>
            <span v-else>
              <i class="bi bi-cart-plus me-1"></i>
              Adicionar
            </span>
          </button>
          <button v-else class="btn btn-outline-secondary btn-sm" disabled>
            Esgotado
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { computed, ref } from 'vue';
import { useCartStore } from '@/stores/cart';
import { useWishlistStore } from '@/stores/wishlist';
import { useToast } from '@/composables/useToast';

export default {
  name: 'ProductCard',
  props: {
    product: {
      type: Object,
      required: true
    }
  },
  setup(props) {
    const cartStore = useCartStore();
    const wishlistStore = useWishlistStore();
    const { showToast } = useToast();
    
    const addingToCart = ref(false);

    const isInWishlist = computed(() => 
      wishlistStore.items.some(item => item.id === props.product.id)
    );

    const stockStatusText = computed(() => {
      switch (props.product.stock_status) {
        case 'out_of_stock':
          return 'Esgotado';
        case 'low_stock':
          return `Últimas ${props.product.stock_quantity} unidades`;
        default:
          return 'Em stock';
      }
    });

    const stockStatusIcon = computed(() => {
      switch (props.product.stock_status) {
        case 'out_of_stock':
          return 'bi-x-circle';
        case 'low_stock':
          return 'bi-exclamation-triangle';
        default:
          return 'bi-check-circle';
      }
    });

    const stockStatusClass = computed(() => {
      switch (props.product.stock_status) {
        case 'out_of_stock':
          return 'text-danger';
        case 'low_stock':
          return 'text-warning';
        default:
          return 'text-success';
      }
    });

    const formatCurrency = (value) => {
      return new Intl.NumberFormat('pt-AO', {
        style: 'currency',
        currency: 'AOA'
      }).format(value);
    };

    const handleImageError = (event) => {
      event.target.src = '/images/placeholder-product.png';
    };

    const addToCart = async () => {
      addingToCart.value = true;
      try {
        await cartStore.addItem({
          product_id: props.product.id,
          quantity: 1,
          packaging_type: 'UN'
        });
        
        showToast('success', 'Produto adicionado ao carrinho!');
      } catch (error) {
        showToast('error', 'Erro ao adicionar produto ao carrinho');
      } finally {
        addingToCart.value = false;
      }
    };

    const toggleWishlist = () => {
      if (isInWishlist.value) {
        wishlistStore.removeItem(props.product.id);
        showToast('info', 'Removido dos favoritos');
      } else {
        wishlistStore.addItem(props.product);
        showToast('success', 'Adicionado aos favoritos!');
      }
    };

    return {
      addingToCart,
      isInWishlist,
      stockStatusText,
      stockStatusIcon,
      stockStatusClass,
      formatCurrency,
      handleImageError,
      addToCart,
      toggleWishlist
    };
  }
};
</script>

<style lang="scss" scoped>
.product-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border: none;

  &:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
  }

  .product-image {
    height: 200px;
    object-fit: cover;
    transition: opacity 0.3s ease;
  }

  .product-title {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 2.8rem;
  }

  .store-link {
    transition: color 0.3s ease;

    &:hover {
      color: var(--primary-color) !important;
    }
  }

  .wishlist-btn {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;

    &:hover {
      background-color: rgba(255, 255, 255, 0.9) !important;
      transform: scale(1.1);
    }
  }

  .current-price {
    font-size: 1.1rem;
  }

  .rating {
    font-size: 0.8rem;
  }
}
</style>
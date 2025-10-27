<template>
  <div class="marketplace-page">
    <!-- Hero Section -->
    <section class="hero-section bg-primary text-white py-5">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <h1 class="display-4 fw-bold mb-3">Descubra o Melhor de Angola</h1>
            <p class="lead mb-4">Milhares de produtos das melhores lojas angolanas. Compre com confiança e receba em casa.</p>
            <SearchBar class="hero-search" />
          </div>
          <div class="col-lg-6">
            <img src="/images/hero-marketplace.png" alt="Marketplace PREGÃO" class="img-fluid">
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Categories -->
    <section class="categories-section py-5">
      <div class="container">
        <h2 class="section-title text-center mb-5">Categorias em Destaque</h2>
        <div class="row">
          <div v-for="category in featuredCategories" :key="category.id" class="col-6 col-md-3 col-lg-2 mb-4">
            <router-link 
              :to="`/category/${category.slug}`" 
              class="category-card text-decoration-none text-center"
            >
              <div class="category-icon mb-2">
                <i :class="category.icon || 'bi bi-grid'"></i>
              </div>
              <h6 class="category-name">{{ category.name }}</h6>
            </router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Products -->
    <section class="products-section py-5 bg-light">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
          <h2 class="section-title">Produtos em Destaque</h2>
          <router-link to="/marketplace" class="btn btn-outline-primary">
            Ver Todos <i class="bi bi-arrow-right ms-1"></i>
          </router-link>
        </div>
        
        <div v-if="loading" class="row">
          <div v-for="n in 8" :key="n" class="col-6 col-md-4 col-lg-3 mb-4">
            <div class="card h-100">
              <div class="card-img-top placeholder-glow" style="height: 200px; background: #f8f9fa;"></div>
              <div class="card-body">
                <h5 class="card-title placeholder-glow">
                  <span class="placeholder col-8"></span>
                </h5>
                <p class="card-text placeholder-glow">
                  <span class="placeholder col-6"></span>
                </p>
              </div>
            </div>
          </div>
        </div>

        <div v-else class="row">
          <div 
            v-for="product in featuredProducts" 
            :key="product.id" 
            class="col-6 col-md-4 col-lg-3 mb-4"
          >
            <ProductCard :product="product" />
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Stores -->
    <section class="stores-section py-5">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
          <h2 class="section-title">Lojas em Destaque</h2>
          <router-link to="/stores" class="btn btn-outline-primary">
            Ver Todas <i class="bi bi-arrow-right ms-1"></i>
          </router-link>
        </div>

        <div class="row">
          <div v-for="store in featuredStores" :key="store.id" class="col-6 col-md-4 col-lg-3 mb-4">
            <StoreCard :store="store" />
          </div>
        </div>
      </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits-section py-5 bg-dark text-white">
      <div class="container">
        <div class="row text-center">
          <div class="col-md-4 mb-4">
            <div class="benefit-item">
              <i class="bi bi-truck fs-1 mb-3"></i>
              <h4>Entrega Rápida</h4>
              <p>Receba os seus produtos em até 24h na grande Luanda</p>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="benefit-item">
              <i class="bi bi-shield-check fs-1 mb-3"></i>
              <h4>Compra Segura</h4>
              <p>Pagamentos protegidos e garantia de satisfação</p>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="benefit-item">
              <i class="bi bi-headset fs-1 mb-3"></i>
              <h4>Suporte 24/7</h4>
              <p>Equipa de apoio sempre disponível para ajudar</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useMarketplaceStore } from '@/stores/marketplace';
import ProductCard from '@/components/marketplace/ProductCard.vue';
import StoreCard from '@/components/marketplace/StoreCard.vue';
import SearchBar from '@/components/marketplace/SearchBar.vue';

export default {
  name: 'MarketplaceIndex',
  components: {
    ProductCard,
    StoreCard,
    SearchBar
  },
  setup() {
    const marketplaceStore = useMarketplaceStore();
    const loading = ref(true);
    const featuredCategories = ref([]);
    const featuredProducts = ref([]);
    const featuredStores = ref([]);

    const fetchHomeData = async () => {
      try {
        loading.value = true;
        
        // Fetch featured data
        const [categoriesResponse, productsResponse, storesResponse] = await Promise.all([
          marketplaceStore.fetchCategories(),
          marketplaceStore.fetchProducts({ featured: true, limit: 8 }),
          marketplaceStore.fetchStores({ featured: true, limit: 4 })
        ]);

        featuredCategories.value = categoriesResponse.data.slice(0, 6);
        featuredProducts.value = productsResponse.data;
        featuredStores.value = storesResponse.data;

      } catch (error) {
        console.error('Error fetching home data:', error);
      } finally {
        loading.value = false;
      }
    };

    onMounted(() => {
      fetchHomeData();
    });

    return {
      loading,
      featuredCategories,
      featuredProducts,
      featuredStores
    };
  }
};
</script>

<style lang="scss" scoped>
.hero-section {
  margin-top: 76px;
  
  .hero-search {
    max-width: 500px;
  }
}

.section-title {
  font-weight: 700;
  color: var(--dark-color);
  position: relative;
  
  &::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: var(--primary-color);
  }
}

.category-card {
  display: block;
  padding: 1.5rem 1rem;
  border-radius: 12px;
  transition: all 0.3s ease;
  background: white;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);

  &:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    text-decoration: none;
  }

  .category-icon {
    font-size: 2rem;
    color: var(--primary-color);
  }

  .category-name {
    color: var(--dark-color);
    font-weight: 600;
    margin: 0;
  }
}

.benefit-item {
  padding: 2rem 1rem;
  
  i {
    color: var(--primary-color);
  }

  h4 {
    font-weight: 600;
    margin-bottom: 1rem;
  }

  p {
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
  }
}

// Responsive adjustments
@media (max-width: 768px) {
  .hero-section {
    text-align: center;
    padding: 3rem 0;
    
    .display-4 {
      font-size: 2.5rem;
    }
  }

  .category-card {
    padding: 1rem 0.5rem;
    
    .category-icon {
      font-size: 1.5rem;
    }
  }
}
</style>
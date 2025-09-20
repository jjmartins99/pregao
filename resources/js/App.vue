<template>
  <div id="app">
    <AppHeader />
    <main class="main-content">
      <router-view />
    </main>
    <AppFooter />
    <CartSidebar />
    <ToastNotification />
    <LoadingSpinner v-if="loading" />
  </div>
</template>

<script>
import { computed } from 'vue';
import { useUiStore } from '@/stores/ui';
import AppHeader from '@/components/layout/Header.vue';
import AppFooter from '@/components/layout/Footer.vue';
import CartSidebar from '@/components/marketplace/CartSidebar.vue';
import ToastNotification from '@/components/ui/ToastNotification.vue';
import LoadingSpinner from '@/components/ui/LoadingSpinner.vue';

export default {
  name: 'App',
  components: {
    AppHeader,
    AppFooter,
    CartSidebar,
    ToastNotification,
    LoadingSpinner
  },
  setup() {
    const uiStore = useUiStore();
    
    const loading = computed(() => uiStore.loading);

    return {
      loading
    };
  }
};
</script>

<style lang="scss">
@import '../scss/app.scss';

.main-content {
  min-height: calc(100vh - 160px);
  padding-top: 76px; // Height of header
}
</style>
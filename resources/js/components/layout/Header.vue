<template>
    <header class="marketplace-header">
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
            <div class="container">
                <router-link to="/" class="navbar-brand">
                    <img src="/images/logo.png" alt="PREGÃO" height="40" class="d-inline-block align-text-top">
                    <span class="brand-text">PREGÃO</span>
                </router-link>

                <button class="navbar-toggler" type="button" @click="toggleMobileMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" :class="{ show: mobileMenuOpen }">
                    <!-- Search Bar -->
                    <div class="mx-lg-3 flex-grow-1">
                        <SearchBar />
                    </div>

                    <!-- Navigation Links -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <router-link to="/marketplace" class="nav-link">Marketplace</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/stores" class="nav-link">Lojas</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/categories" class="nav-link">Categorias</router-link>
                        </li>
                    </ul>

                    <!-- User Actions -->
                    <div class="d-flex align-items-center">
                        <button class="btn btn-link position-relative me-2" @click="toggleCart">
                            <i class="bi bi-cart3 fs-5"></i>
                            <span v-if="cartTotalItems > 0" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ cartTotalItems }}
                            </span>
                        </button>

                        <template v-if="isAuthenticated">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle me-1"></i>
                                    {{ user.name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><router-link to="/dashboard" class="dropdown-item">Dashboard</router-link></li>
                                    <li><router-link to="/orders" class="dropdown-item">Meus Pedidos</router-link></li>
                                    <li><router-link to="/profile" class="dropdown-item">Perfil</router-link></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><button class="dropdown-item" @click="logout">Sair</button></li>
                                </ul>
                            </div>
                        </template>
                        <template v-else>
                            <router-link to="/login" class="btn btn-outline-primary me-2">Entrar</router-link>
                            <router-link to="/register" class="btn btn-primary">Registar</router-link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
import { computed } from 'vue';
import { useAuthStore } from '@/stores/auth';
import { useCartStore } from '@/stores/cart';
import { useUiStore } from '@/stores/ui';
import SearchBar from '@/components/marketplace/SearchBar.vue';

export default {
    name: 'AppHeader',
    components: {
        SearchBar
    },
    setup() {
        const authStore = useAuthStore();
        const cartStore = useCartStore();
        const uiStore = useUiStore();

        const isAuthenticated = computed(() => authStore.isAuthenticated);
        const user = computed(() => authStore.user);
        const cartTotalItems = computed(() => cartStore.totalItems);
        const mobileMenuOpen = computed(() => uiStore.mobileMenuOpen);

        const toggleCart = () => {
            uiStore.toggleCart();
        };

        const toggleMobileMenu = () => {
            uiStore.toggleMobileMenu();
        };

        const logout = async () => {
            await authStore.logout();
        };

        return {
            isAuthenticated,
            user,
            cartTotalItems,
            mobileMenuOpen,
            toggleCart,
            toggleMobileMenu,
            logout
        };
    }
};
</script>

<style lang="scss" scoped>
.marketplace-header {
    .navbar-brand {
        font-weight: 700;
        color: var(--primary-color);
        
        .brand-text {
            margin-left: 0.5rem;
            font-size: 1.5rem;
        }
    }

    .nav-link {
        font-weight: 500;
        transition: color 0.3s ease;

        &:hover {
            color: var(--primary-color) !important;
        }
    }

    .badge {
        font-size: 0.65rem;
    }
}
</style>
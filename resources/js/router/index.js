import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import('@/components/HomePage.vue'),
    },
    {
        path: '/marketplace',
        name: 'marketplace',
        component: () => import('@/components/marketplace/MarketplaceIndex.vue'),
    },
    {
        path: '/product/:id',
        name: 'product.show',
        component: () => import('@/components/marketplace/ProductShow.vue'),
        props: true,
    },
    {
        path: '/store/:slug',
        name: 'store.show',
        component: () => import('@/components/marketplace/StoreShow.vue'),
        props: true,
    },
    {
        path: '/category/:slug',
        name: 'category.show',
        component: () => import('@/components/marketplace/CategoryShow.vue'),
        props: true,
    },
    {
        path: '/search',
        name: 'search',
        component: () => import('@/components/marketplace/SearchResults.vue'),
    },
    {
        path: '/cart',
        name: 'cart',
        component: () => import('@/components/cart/CartIndex.vue'),
    },
    {
        path: '/checkout',
        name: 'checkout',
        component: () => import('@/components/cart/Checkout.vue'),
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('@/components/auth/Login.vue'),
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('@/components/auth/Register.vue'),
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'not-found',
        component: () => import('@/components/errors/NotFound.vue'),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else {
            return { top: 0 };
        }
    },
});

export default router;
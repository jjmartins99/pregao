import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import { useApi } from '@/composables/useApi';

export const useMarketplaceStore = defineStore('marketplace', () => {
    const products = ref([]);
    const stores = ref([]);
    const categories = ref([]);
    const featuredProducts = ref([]);
    const currentProduct = ref(null);
    const currentStore = ref(null);
    const searchResults = ref([]);
    const filters = ref({
        category: null,
        priceRange: [0, 10000],
        rating: 0,
        sortBy: 'name',
        sortOrder: 'asc'
    });

    const { get, post } = useApi();

    // Getters
    const filteredProducts = computed(() => {
        let filtered = [...products.value];
        
        // Apply filters
        if (filters.value.category) {
            filtered = filtered.filter(product => 
                product.categories?.includes(filters.value.category)
            );
        }
        
        if (filters.value.rating > 0) {
            filtered = filtered.filter(product => 
                product.rating >= filters.value.rating
            );
        }
        
        filtered = filtered.filter(product => 
            product.price >= filters.value.priceRange[0] && 
            product.price <= filters.value.priceRange[1]
        );
        
        // Apply sorting
        filtered.sort((a, b) => {
            const modifier = filters.value.sortOrder === 'asc' ? 1 : -1;
            
            switch (filters.value.sortBy) {
                case 'price':
                    return (a.price - b.price) * modifier;
                case 'rating':
                    return (a.rating - b.rating) * modifier;
                case 'name':
                default:
                    return a.name.localeCompare(b.name) * modifier;
            }
        });
        
        return filtered;
    });

    // Actions
    const fetchProducts = async (params = {}) => {
        try {
            const response = await get('/api/marketplace/products', { params });
            products.value = response.data.data;
            return response.data;
        } catch (error) {
            console.error('Error fetching products:', error);
            throw error;
        }
    };

    const fetchStores = async (params = {}) => {
        try {
            const response = await get('/api/marketplace/stores', { params });
            stores.value = response.data.data;
            return response.data;
        } catch (error) {
            console.error('Error fetching stores:', error);
            throw error;
        }
    };

    const fetchCategories = async () => {
        try {
            const response = await get('/api/marketplace/categories');
            categories.value = response.data.data;
            return response.data;
        } catch (error) {
            console.error('Error fetching categories:', error);
            throw error;
        }
    };

    const fetchProduct = async (id) => {
        try {
            const response = await get(`/api/marketplace/products/${id}`);
            currentProduct.value = response.data.data;
            return response.data;
        } catch (error) {
            console.error('Error fetching product:', error);
            throw error;
        }
    };

    const fetchStore = async (id) => {
        try {
            const response = await get(`/api/marketplace/stores/${id}`);
            currentStore.value = response.data.data;
            return response.data;
        } catch (error) {
            console.error('Error fetching store:', error);
            throw error;
        }
    };

    const searchProducts = async (query, params = {}) => {
        try {
            const response = await get('/api/marketplace/search', {
                params: { q: query, ...params }
            });
            searchResults.value = response.data.data;
            return response.data;
        } catch (error) {
            console.error('Error searching products:', error);
            throw error;
        }
    };

    const updateFilters = (newFilters) => {
        filters.value = { ...filters.value, ...newFilters };
    };

    const resetFilters = () => {
        filters.value = {
            category: null,
            priceRange: [0, 10000],
            rating: 0,
            sortBy: 'name',
            sortOrder: 'asc'
        };
    };

    return {
        products,
        stores,
        categories,
        featuredProducts,
        currentProduct,
        currentStore,
        searchResults,
        filters,
        filteredProducts,
        fetchProducts,
        fetchStores,
        fetchCategories,
        fetchProduct,
        fetchStore,
        searchProducts,
        updateFilters,
        resetFilters
    };
});
import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import { useApi } from '@/composables/useApi';

export const useCartStore = defineStore('cart', () => {
    const items = ref([]);
    const { post, get, del } = useApi();

    // Getters
    const totalItems = computed(() => {
        return items.value.reduce((total, item) => total + item.quantity, 0);
    });

    const subtotal = computed(() => {
        return items.value.reduce((total, item) => total + (item.price * item.quantity), 0);
    });

    const total = computed(() => {
        return subtotal.value; // Adicionar taxas e descontos depois
    });

    // Actions
    const fetchCart = async () => {
        try {
            const response = await get('/api/cart');
            items.value = response.data;
        } catch (error) {
            console.error('Error fetching cart:', error);
        }
    };

    const addItem = async (itemData) => {
        try {
            const response = await post('/api/cart/add', itemData);
            await fetchCart(); // Recarregar carrinho
            return response.data;
        } catch (error) {
            console.error('Error adding item to cart:', error);
            throw error;
        }
    };

    const updateItem = async (itemId, quantity) => {
        try {
            await post(`/api/cart/update/${itemId}`, { quantity });
            await fetchCart();
        } catch (error) {
            console.error('Error updating cart item:', error);
            throw error;
        }
    };

    const removeItem = async (itemId) => {
        try {
            await del(`/api/cart/remove/${itemId}`);
            await fetchCart();
        } catch (error) {
            console.error('Error removing cart item:', error);
            throw error;
        }
    };

    const clearCart = async () => {
        try {
            await del('/api/cart/clear');
            items.value = [];
        } catch (error) {
            console.error('Error clearing cart:', error);
            throw error;
        }
    };

    return {
        items,
        totalItems,
        subtotal,
        total,
        fetchCart,
        addItem,
        updateItem,
        removeItem,
        clearCart,
    };
});
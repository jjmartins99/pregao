import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export const useUiStore = defineStore('ui', () => {
    const isLoading = ref(false);
    const mobileMenuOpen = ref(false);
    const cartOpen = ref(false);
    const notifications = ref([]);

    const setLoading = (loading) => {
        isLoading.value = loading;
    };

    const toggleMobileMenu = () => {
        mobileMenuOpen.value = !mobileMenuOpen.value;
    };

    const toggleCart = () => {
        cartOpen.value = !cartOpen.value;
    };

    const addNotification = (notification) => {
        notifications.value.push({
            id: Date.now(),
            ...notification,
        });
    };

    const removeNotification = (id) => {
        notifications.value = notifications.value.filter(n => n.id !== id);
    };

    return {
        isLoading,
        mobileMenuOpen,
        cartOpen,
        notifications,
        setLoading,
        toggleMobileMenu,
        toggleCart,
        addNotification,
        removeNotification,
    };
});
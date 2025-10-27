/**
 * PREGÃO Marketplace - Main Application File
 * 
 * Este arquivo inicializa todas as funcionalidades principais do marketplace
 */

import './bootstrap';
import './marketplace';
import './cart';
import { ProductSearch, CartSidebar, ProductCompare } from './components';

class PregãoApp {
    constructor() {
        this.init();
    }

    init() {
        console.log('PREGÃO Marketplace initialized');
        
        // Initialize components
        this.initializeComponents();
        
        // Set up global event listeners
        this.setupEventListeners();
        
        // Load initial data
        this.loadInitialData();
    }

    initializeComponents() {
        // Initialize Vue components if they exist
        if (typeof ProductSearch !== 'undefined') {
            this.productSearch = new ProductSearch();
        }
        
        if (typeof CartSidebar !== 'undefined') {
            this.cartSidebar = new CartSidebar();
        }
        
        if (typeof ProductCompare !== 'undefined') {
            this.productCompare = new ProductCompare();
        }

        // Initialize marketplace functionality
        if (typeof marketplace !== 'undefined') {
            this.marketplace = marketplace;
        }
    }

    setupEventListeners() {
        // Global click handler for AJAX links
        document.addEventListener('click', this.handleGlobalClicks.bind(this));
        
        // Global form submission handler
        document.addEventListener('submit', this.handleFormSubmissions.bind(this));
        
        // Keyboard shortcuts
        document.addEventListener('keydown', this.handleKeyboardShortcuts.bind(this));
    }

    handleGlobalClicks(e) {
        const target = e.target;
        
        // Handle AJAX links
        if (target.hasAttribute('data-ajax')) {
            e.preventDefault();
            this.handleAjaxRequest(target.href, target.dataset.method || 'GET');
        }
        
        // Handle modal triggers
        if (target.hasAttribute('data-bs-toggle') && target.getAttribute('data-bs-toggle') === 'modal') {
            this.handleModalTrigger(target);
        }
    }

    handleFormSubmissions(e) {
        const form = e.target;
        
        // Handle AJAX forms
        if (form.hasAttribute('data-ajax')) {
            e.preventDefault();
            this.submitAjaxForm(form);
        }
        
        // Add loading state to forms
        if (form.classList.contains('needs-validation')) {
            this.handleFormValidation(form, e);
        }
    }

    handleKeyboardShortcuts(e) {
        // Search focus (Ctrl/Cmd + K)
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.querySelector('input[type="search"]');
            if (searchInput) searchInput.focus();
        }
        
        // Cart toggle (Ctrl/Cmd + B)
        if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
            e.preventDefault();
            const cartToggle = document.getElementById('cartToggle');
            if (cartToggle) cartToggle.click();
        }
    }

    async handleAjaxRequest(url, method = 'GET', data = null) {
        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: data
            });

            if (!response.ok) throw new Error('Network response was not ok');

            const result = await response.json();
            
            if (result.redirect) {
                window.location.href = result.redirect;
            } else if (result.message) {
                this.showNotification(result.message, result.success ? 'success' : 'error');
            }
            
            return result;
        } catch (error) {
            console.error('AJAX request failed:', error);
            this.showNotification('Erro ao processar solicitação', 'error');
        }
    }

    async submitAjaxForm(form) {
        const formData = new FormData(form);
        const url = form.action;
        const method = form.method;

        try {
            // Show loading state
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton?.innerHTML;
            
            if (submitButton) {
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processando...';
                submitButton.disabled = true;
            }

            const response = await this.handleAjaxRequest(url, method, formData);

            // Reset form if successful
            if (response?.success) {
                form.reset();
            }

            return response;
        } finally {
            // Restore button state
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.innerHTML = originalText;
                submitButton.disabled = false;
            }
        }
    }

    handleFormValidation(form, e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }

        form.classList.add('was-validated');
    }

    handleModalTrigger(trigger) {
        const modalId = trigger.getAttribute('data-bs-target');
        const modal = document.querySelector(modalId);
        
        if (modal) {
            // Load modal content dynamically if needed
            if (trigger.hasAttribute('data-ajax-url')) {
                this.loadModalContent(modal, trigger.getAttribute('data-ajax-url'));
            }
        }
    }

    async loadModalContent(modal, url) {
        try {
            const response = await fetch(url);
            const html = await response.text();
            
            const modalBody = modal.querySelector('.modal-body');
            if (modalBody) {
                modalBody.innerHTML = html;
            }
        } catch (error) {
            console.error('Error loading modal content:', error);
        }
    }

    loadInitialData() {
        // Load user data if authenticated
        if (window.userId) {
            this.loadUserData();
        }
        
        // Load cart count
        this.updateCartCount();
        
        // Load notifications
        this.loadNotifications();
    }

    async loadUserData() {
        try {
            const response = await fetch('/api/user/data');
            const data = await response.json();
            
            window.userData = data;
            this.updateUIWithUserData(data);
        } catch (error) {
            console.error('Error loading user data:', error);
        }
    }

    updateUIWithUserData(data) {
        // Update user-specific UI elements
        const userElements = document.querySelectorAll('[data-user-data]');
        
        userElements.forEach(element => {
            const dataKey = element.getAttribute('data-user-data');
            if (data[dataKey]) {
                element.textContent = data[dataKey];
            }
        });
    }

    async updateCartCount() {
        try {
            const response = await fetch('/api/cart/count');
            const data = await response.json();
            
            const cartCount = document.getElementById('cartCount');
            if (cartCount) {
                cartCount.textContent = data.count;
                cartCount.style.display = data.count > 0 ? 'inline-block' : 'none';
            }
        } catch (error) {
            console.error('Error updating cart count:', error);
        }
    }

    async loadNotifications() {
        if (!window.userId) return;
        
        try {
            const response = await fetch('/api/notifications');
            const notifications = await response.json();
            
            this.displayNotifications(notifications);
        } catch (error) {
            console.error('Error loading notifications:', error);
        }
    }

    displayNotifications(notifications) {
        // Implement notification display logic
        console.log('Notifications:', notifications);
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        notification.style.cssText = `
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            max-width: 500px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        `;
        
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas ${this.getNotificationIcon(type)} me-2"></i>
                <div class="flex-grow-1">${message}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        // Add to document
        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 5000);
    }

    getNotificationIcon(type) {
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };
        
        return icons[type] || 'fa-info-circle';
    }

    // Utility methods
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    throttle(func, limit) {
        let inThrottle;
        return function(...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    formatCurrency(amount, currency = 'Kz') {
        return new Intl.NumberFormat('pt-AO', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(amount) + ' ' + currency;
    }

    formatDate(date, format = 'short') {
        const options = {
            short: {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            },
            long: {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            }
        };
        
        return new Intl.DateTimeFormat('pt-AO', options[format] || options.short).format(new Date(date));
    }
}

// Initialize application when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.PregãoApp = new PregãoApp();
});

// Export for module usage
export default PregãoApp;
/**
 * PREGÃO Marketplace - Marketplace Specific Functionality
 * 
 * Funcionalidades específicas do marketplace: produtos, lojas, categorias, etc.
 */

class Marketplace {
    constructor() {
        this.cart = this.loadCart();
        this.wishlist = this.loadWishlist();
        this.compareList = this.loadCompareList();
        this.init();
    }

    init() {
        console.log('Marketplace initialized');
        
        this.initProductInteractions();
        this.initStoreInteractions();
        this.initCategoryFilters();
        this.initSearchFunctionality();
        this.initImageGalleries();
        this.initRatingSystem();
    }

    // Product Interactions
    initProductInteractions() {
        this.initAddToCart();
        this.initWishlist();
        this.initQuickView();
        this.initProductCompare();
        this.initQuantityControls();
    }

    initAddToCart() {
        document.addEventListener('click', (e) => {
            const addToCartBtn = e.target.closest('.add-to-cart-btn');
            if (addToCartBtn) {
                e.preventDefault();
                this.addToCart(addToCartBtn);
            }
        });
    }

    initWishlist() {
        document.addEventListener('click', (e) => {
            const wishlistBtn = e.target.closest('.wishlist-btn');
            if (wishlistBtn) {
                e.preventDefault();
                this.toggleWishlist(wishlistBtn);
            }
        });
    }

    initQuickView() {
        document.addEventListener('click', (e) => {
            const quickViewBtn = e.target.closest('.quick-view-btn');
            if (quickViewBtn) {
                e.preventDefault();
                this.showQuickView(quickViewBtn);
            }
        });
    }

    initProductCompare() {
        document.addEventListener('click', (e) => {
            const compareBtn = e.target.closest('.compare-btn');
            if (compareBtn) {
                e.preventDefault();
                this.toggleProductCompare(compareBtn);
            }
        });
    }

    initQuantityControls() {
        document.addEventListener('click', (e) => {
            const increaseBtn = e.target.closest('.increase-qty');
            const decreaseBtn = e.target.closest('.decrease-qty');
            
            if (increaseBtn) {
                e.preventDefault();
                this.increaseQuantity(increaseBtn);
            }
            
            if (decreaseBtn) {
                e.preventDefault();
                this.decreaseQuantity(decreaseBtn);
            }
        });
    }

    // Store Interactions
    initStoreInteractions() {
        this.initFollowStore();
        this.initStoreReviews();
        this.initStoreContact();
    }

    initFollowStore() {
        document.addEventListener('click', (e) => {
            const followBtn = e.target.closest('.follow-store-btn');
            if (followBtn) {
                e.preventDefault();
                this.toggleFollowStore(followBtn);
            }
        });
    }

    initStoreReviews() {
        // Initialize store review functionality
        const reviewForms = document.querySelectorAll('.review-form');
        reviewForms.forEach(form => {
            form.addEventListener('submit', this.handleReviewSubmit.bind(this));
        });
    }

    initStoreContact() {
        document.addEventListener('click', (e) => {
            const contactBtn = e.target.closest('.contact-store-btn');
            if (contactBtn) {
                e.preventDefault();
                this.showContactForm(contactBtn);
            }
        });
    }

    // Category Filters
    initCategoryFilters() {
        const filterForms = document.querySelectorAll('.filter-form');
        filterForms.forEach(form => {
            form.addEventListener('change', this.debounce(() => {
                this.applyFilters(form);
            }, 300));
        });

        // Price range sliders
        this.initPriceSliders();
    }

    initPriceSliders() {
        const priceSliders = document.querySelectorAll('.price-range-slider');
        priceSliders.forEach(slider => {
            noUiSlider.create(slider, {
                start: [slider.dataset.min || 0, slider.dataset.max || 10000],
                connect: true,
                range: {
                    'min': parseInt(slider.dataset.min) || 0,
                    'max': parseInt(slider.dataset.max) || 10000
                },
                step: parseInt(slider.dataset.step) || 100
            });

            slider.noUiSlider.on('update', (values) => {
                const [min, max] = values;
                document.getElementById('priceMin').value = Math.round(min);
                document.getElementById('priceMax').value = Math.round(max);
                document.getElementById('priceRange').textContent = 
                    `${Math.round(min)} Kz - ${Math.round(max)} Kz`;
            });
        });
    }

    // Search Functionality
    initSearchFunctionality() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', this.debounce(() => {
                this.handleSearchInput(searchInput.value);
            }, 300));
        }

        // Search suggestions
        this.initSearchSuggestions();
    }

    initSearchSuggestions() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('focus', () => {
                this.showSearchSuggestions();
            });

            searchInput.addEventListener('blur', () => {
                setTimeout(() => this.hideSearchSuggestions(), 200);
            });
        }
    }

    // Image Galleries
    initImageGalleries() {
        const productGalleries = document.querySelectorAll('.product-gallery');
        productGalleries.forEach(gallery => {
            this.initProductGallery(gallery);
        });

        // Lightbox functionality
        this.initLightbox();
    }

    initProductGallery(gallery) {
        const mainImage = gallery.querySelector('.main-image img');
        const thumbnails = gallery.querySelectorAll('.thumbnail');
        
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', (e) => {
                e.preventDefault();
                const newSrc = thumb.getAttribute('data-image') || thumb.src;
                mainImage.src = newSrc;
                
                // Update active thumbnail
                thumbnails.forEach(t => t.classList.remove('active'));
                thumb.classList.add('active');
            });
        });

        // Zoom functionality
        if (mainImage) {
            mainImage.addEventListener('click', () => {
                this.zoomImage(mainImage);
            });
        }
    }

    initLightbox() {
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('lightbox-trigger')) {
                e.preventDefault();
                this.showLightbox(e.target);
            }
        });
    }

    // Rating System
    initRatingSystem() {
        const ratingStars = document.querySelectorAll('.rating-stars');
        ratingStars.forEach(stars => {
            this.initStarRating(stars);
        });
    }

    initStarRating(starsContainer) {
        const stars = starsContainer.querySelectorAll('input[type="radio"]');
        stars.forEach(star => {
            star.addEventListener('change', () => {
                this.submitRating(star);
            });
        });

        // Hover effect
        stars.forEach(star => {
            star.addEventListener('mouseenter', () => {
                this.previewRating(star);
            });
        });

        starsContainer.addEventListener('mouseleave', () => {
            this.resetRatingPreview(starsContainer);
        });
    }

    // Core Methods
    async addToCart(button) {
        const productId = button.dataset.productId;
        const quantity = button.dataset.quantity || 
                        document.querySelector(`.quantity-input[data-product-id="${productId}"]`)?.value || 
                        1;

        try {
            const response = await fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: parseInt(quantity)
                })
            });

            const data = await response.json();

            if (data.success) {
                this.updateCart(data.cart);
                this.showNotification('Produto adicionado ao carrinho!', 'success');
                
                // Update cart count in navbar
                this.updateCartCount(data.cart_count);
            } else {
                this.showNotification(data.message || 'Erro ao adicionar produto', 'error');
            }
        } catch (error) {
            console.error('Error adding to cart:', error);
            this.showNotification('Erro ao adicionar produto ao carrinho', 'error');
        }
    }

    async toggleWishlist(button) {
        const productId = button.dataset.productId;
        const isInWishlist = button.dataset.inWishlist === 'true';

        try {
            const response = await fetch('/wishlist/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: productId,
                    action: isInWishlist ? 'remove' : 'add'
                })
            });

            const data = await response.json();

            if (data.success) {
                button.dataset.inWishlist = !isInWishlist;
                const icon = button.querySelector('i');
                
                if (isInWishlist) {
                    icon.classList.remove('fas', 'text-danger');
                    icon.classList.add('far');
                } else {
                    icon.classList.remove('far');
                    icon.classList.add('fas', 'text-danger');
                }

                this.showNotification(
                    isInWishlist ? 'Removido da lista de desejos' : 'Adicionado à lista de desejos',
                    'success'
                );
            }
        } catch (error) {
            console.error('Error toggling wishlist:', error);
            this.showNotification('Erro ao atualizar lista de desejos', 'error');
        }
    }

    async showQuickView(button) {
        const productId = button.dataset.productId;
        
        try {
            const response = await fetch(`/products/${productId}/quickview`);
            const html = await response.text();

            // Create modal
            const modal = this.createModal('quickViewModal', 'Visualização Rápida', html);
            document.body.appendChild(modal);

            // Show modal
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();

            // Initialize product actions in modal
            this.initProductActionsInModal(modal);
        } catch (error) {
            console.error('Error loading quick view:', error);
            this.showNotification('Erro ao carregar visualização rápida', 'error');
        }
    }

    // Utility Methods
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

    showNotification(message, type = 'info') {
        // Reuse the notification system from app.js
        if (window.PregãoApp && typeof window.PregãoApp.showNotification === 'function') {
            window.PregãoApp.showNotification(message, type);
        } else {
            // Fallback notification
            alert(`${type.toUpperCase()}: ${message}`);
        }
    }

    updateCartCount(count) {
        const cartCount = document.getElementById('cartCount');
        if (cartCount) {
            cartCount.textContent = count;
            cartCount.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }

    loadCart() {
        const cart = localStorage.getItem('marketplace_cart');
        return cart ? JSON.parse(cart) : [];
    }

    saveCart() {
        localStorage.setItem('marketplace_cart', JSON.stringify(this.cart));
    }

    loadWishlist() {
        const wishlist = localStorage.getItem('marketplace_wishlist');
        return wishlist ? JSON.parse(wishlist) : [];
    }

    saveWishlist() {
        localStorage.setItem('marketplace_wishlist', JSON.stringify(this.wishlist));
    }

    loadCompareList() {
        const compareList = localStorage.getItem('marketplace_compare');
        return compareList ? JSON.parse(compareList) : [];
    }

    saveCompareList() {
        localStorage.setItem('marketplace_compare', JSON.stringify(this.compareList));
    }
}

// Initialize marketplace when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.marketplace = new Marketplace();
});

// Export for module usage
export default Marketplace;
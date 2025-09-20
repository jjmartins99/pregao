class Marketplace {
    constructor() {
        this.cart = this.loadCart();
        this.init();
    }

    init() {
        this.initCart();
        this.initSearch();
        this.initProductInteractions();
        this.initNotifications();
    }

    // Cart Management
    initCart() {
        const cartToggle = document.getElementById('cartToggle');
        const cartSidebar = document.getElementById('cartSidebar');
        
        if (cartToggle && cartSidebar) {
            cartToggle.addEventListener('click', (e) => {
                e.preventDefault();
                const bsOffcanvas = new bootstrap.Offcanvas(cartSidebar);
                bsOffcanvas.show();
            });
        }

        // Add to cart buttons
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                this.addToCart(e.target.closest('.add-to-cart-btn'));
            });
        });
    }

    addToCart(button) {
        const productId = button.dataset.productId;
        const productName = button.dataset.productName;
        const productPrice = parseFloat(button.dataset.productPrice);
        const productImage = button.dataset.productImage;

        const item = {
            id: productId,
            name: productName,
            price: productPrice,
            image: productImage,
            quantity: 1
        };

        // Check if product already in cart
        const existingItem = this.cart.find(i => i.id === productId);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            this.cart.push(item);
        }

        this.saveCart();
        this.updateCartUI();
        this.showNotification('Produto adicionado ao carrinho!', 'success');
    }

    removeFromCart(productId) {
        this.cart = this.cart.filter(item => item.id !== productId);
        this.saveCart();
        this.updateCartUI();
    }

    updateCartQuantity(productId, quantity) {
        const item = this.cart.find(i => i.id === productId);
        if (item) {
            item.quantity = parseInt(quantity);
            if (item.quantity <= 0) {
                this.removeFromCart(productId);
            } else {
                this.saveCart();
                this.updateCartUI();
            }
        }
    }

    loadCart() {
        const cart = localStorage.getItem('marketplace_cart');
        return cart ? JSON.parse(cart) : [];
    }

    saveCart() {
        localStorage.setItem('marketplace_cart', JSON.stringify(this.cart));
    }

    updateCartUI() {
        // Update cart count
        const cartCount = document.getElementById('cartCount');
        if (cartCount) {
            const totalItems = this.cart.reduce((sum, item) => sum + item.quantity, 0);
            cartCount.textContent = totalItems;
            cartCount.style.display = totalItems > 0 ? 'inline-block' : 'none';
        }

        // Update cart sidebar
        this.updateCartSidebar();
    }

    updateCartSidebar() {
        const cartItemsContainer = document.getElementById('cartItems');
        const cartTotalElement = document.getElementById('cartTotal');
        const emptyCartMessage = document.getElementById('emptyCartMessage');

        if (!cartItemsContainer) return;

        if (this.cart.length === 0) {
            cartItemsContainer.innerHTML = '';
            emptyCartMessage.style.display = 'block';
            cartTotalElement.textContent = '0,00 Kz';
            return;
        }

        emptyCartMessage.style.display = 'none';
        
        let total = 0;
        let itemsHTML = '';

        this.cart.forEach(item => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;

            itemsHTML += `
                <div class="cart-item mb-3 pb-3 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-3">
                            <img src="${item.image}" alt="${item.name}" 
                                 class="img-fluid rounded" style="height: 60px; object-fit: cover;">
                        </div>
                        <div class="col-5">
                            <h6 class="mb-1">${item.name}</h6>
                            <p class="text-muted mb-0">${item.price.toFixed(2)} Kz</p>
                        </div>
                        <div class="col-4">
                            <div class="input-group input-group-sm">
                                <button class="btn btn-outline-secondary" 
                                        onclick="marketplace.updateCartQuantity('${item.id}', ${item.quantity - 1})">-</button>
                                <input type="number" class="form-control text-center" 
                                       value="${item.quantity}" min="1" 
                                       onchange="marketplace.updateCartQuantity('${item.id}', this.value)">
                                <button class="btn btn-outline-secondary" 
                                        onclick="marketplace.updateCartQuantity('${item.id}', ${item.quantity + 1})">+</button>
                            </div>
                            <button class="btn btn-link text-danger btn-sm mt-1 p-0" 
                                    onclick="marketplace.removeFromCart('${item.id}')">
                                <i class="fas fa-trash"></i> Remover
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });

        cartItemsContainer.innerHTML = itemsHTML;
        cartTotalElement.textContent = total.toFixed(2) + ' Kz';
    }

    // Search functionality
    initSearch() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', this.debounce(this.handleSearch.bind(this), 300));
        }
    }

    handleSearch(e) {
        const query = e.target.value.trim();
        if (query.length > 2) {
            // Implement search API call
            fetch(`/api/marketplace/search?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => this.displaySearchResults(data))
                .catch(error => console.error('Search error:', error));
        }
    }

    displaySearchResults(results) {
        // Implement search results display
        console.log('Search results:', results);
    }

    // Product interactions
    initProductInteractions() {
        // Wishlist functionality
        document.querySelectorAll('.wishlist-btn').forEach(btn => {
            btn.addEventListener('click', this.toggleWishlist.bind(this));
        });

        // Quick view functionality
        document.querySelectorAll('.quick-view-btn').forEach(btn => {
            btn.addEventListener('click', this.quickView.bind(this));
        });
    }

    toggleWishlist(e) {
        const button = e.currentTarget;
        const productId = button.dataset.productId;
        
        // Toggle wishlist state
        button.classList.toggle('active');
        
        // Update wishlist count
        this.updateWishlistCount();
    }

    quickView(e) {
        const productId = e.currentTarget.dataset.productId;
        // Implement quick view modal
        console.log('Quick view product:', productId);
    }

    // Notifications
    initNotifications() {
        // Listen for real-time notifications
        this.setupWebSocket();
    }

    setupWebSocket() {
        // Implement WebSocket connection for real-time updates
        if (typeof Echo !== 'undefined') {
            Echo.private('user.' + window.userId)
                .listen('OrderStatusUpdated', (e) => {
                    this.showNotification(`Status do pedido atualizado: ${e.order.status}`, 'info');
                })
                .listen('DeliveryStatusUpdated', (e) => {
                    this.showNotification(`Status da entrega atualizado: ${e.delivery.status}`, 'info');
                });
        }
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 5000);
    }

    // Utility functions
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
}

// Initialize marketplace
const marketplace = new Marketplace();

// Make available globally
window.marketplace = marketplace;
/**
 * PREGÃO Marketplace - Cart Functionality
 * 
 * Gestão completa do carrinho de compras
 */

class Cart {
    constructor() {
        this.items = this.loadCart();
        this.init();
    }

    init() {
        console.log('Cart initialized');
        
        this.initCartSidebar();
        this.initCartPage();
        this.initCheckoutProcess();
        this.initCartEvents();
    }

    initCartSidebar() {
        const cartToggle = document.getElementById('cartToggle');
        const cartSidebar = document.getElementById('cartSidebar');
        
        if (cartToggle && cartSidebar) {
            cartToggle.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleCartSidebar();
            });
        }

        this.updateSidebarContent();
    }

    initCartPage() {
        if (!document.querySelector('.cart-page')) return;
        
        this.initQuantityControls();
        this.initCartActions();
        this.initCouponCode();
        this.initShippingCalculator();
    }

    initCheckoutProcess() {
        if (!document.querySelector('.checkout-page')) return;
        
        this.initCheckoutSteps();
        this.initPaymentMethods();
        this.initAddressManagement();
        this.initOrderReview();
    }

    initCartEvents() {
        // Listen for cart updates from other components
        document.addEventListener('cartUpdated', (e) => {
            this.handleCartUpdate(e.detail);
        });

        // Listen for product additions
        document.addEventListener('productAddedToCart', (e) => {
            this.addItem(e.detail);
        });
    }

    // Cart Operations
    async addItem(product, quantity = 1) {
        try {
            const response = await fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: product.id,
                    quantity: quantity,
                    options: product.options || {}
                })
            });

            const data = await response.json();

            if (data.success) {
                this.items = data.cart;
                this.saveCart();
                this.updateUI();
                this.emitCartUpdated();
                
                return { success: true, message: 'Product added to cart' };
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error adding to cart:', error);
            return { success: false, message: error.message };
        }
    }

    async updateQuantity(rowId, quantity) {
        if (quantity < 1) {
            return this.removeItem(rowId);
        }

        try {
            const response = await fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    rowId: rowId,
                    quantity: quantity
                })
            });

            const data = await response.json();

            if (data.success) {
                this.items = data.cart;
                this.saveCart();
                this.updateUI();
                this.emitCartUpdated();
                
                return { success: true };
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error updating quantity:', error);
            return { success: false, message: error.message };
        }
    }

    async removeItem(rowId) {
        try {
            const response = await fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    rowId: rowId
                })
            });

            const data = await response.json();

            if (data.success) {
                this.items = data.cart;
                this.saveCart();
                this.updateUI();
                this.emitCartUpdated();
                
                return { success: true, message: 'Item removed from cart' };
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error removing item:', error);
            return { success: false, message: error.message };
        }
    }

    async clearCart() {
        try {
            const response = await fetch('/cart/clear', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();

            if (data.success) {
                this.items = [];
                this.saveCart();
                this.updateUI();
                this.emitCartUpdated();
                
                return { success: true, message: 'Cart cleared' };
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error clearing cart:', error);
            return { success: false, message: error.message };
        }
    }

    // UI Updates
    updateUI() {
        this.updateCartCount();
        this.updateSidebarContent();
        this.updateCartPage();
        this.updateCheckoutPage();
    }

    updateCartCount() {
        const totalItems = this.getTotalItems();
        const cartCountElements = document.querySelectorAll('.cart-count');
        
        cartCountElements.forEach(element => {
            element.textContent = totalItems;
            element.style.display = totalItems > 0 ? 'inline-block' : 'none';
        });
    }

    updateSidebarContent() {
        const sidebar = document.getElementById('cartSidebar');
        if (!sidebar) return;

        const emptyMessage = sidebar.querySelector('#emptyCartMessage');
        const cartItems = sidebar.querySelector('#cartItems');
        const cartFooter = sidebar.querySelector('.offcanvas-footer');

        if (this.items.length === 0) {
            emptyMessage.style.display = 'block';
            cartItems.innerHTML = '';
            if (cartFooter) cartFooter.style.display = 'none';
        } else {
            emptyMessage.style.display = 'none';
            cartItems.innerHTML = this.generateCartItemsHTML();
            if (cartFooter) cartFooter.style.display = 'block';
            
            this.initSidebarEvents();
        }

        this.updateSidebarTotals();
    }

    updateCartPage() {
        if (!document.querySelector('.cart-page')) return;
        
        const cartContainer = document.querySelector('.cart-items-container');
        if (cartContainer) {
            cartContainer.innerHTML = this.generateCartPageHTML();
            this.initCartPageEvents();
        }

        this.updateCartTotals();
    }

    updateCheckoutPage() {
        if (!document.querySelector('.checkout-page')) return;
        this.updateOrderSummary();
    }

    // HTML Generation
    generateCartItemsHTML() {
        return this.items.map(item => `
            <div class="cart-item mb-3 pb-3 border-bottom" data-row-id="${item.rowId}">
                <div class="row align-items-center">
                    <div class="col-3">
                        <img src="${item.options.image}" alt="${item.name}" 
                             class="img-fluid rounded" style="height: 60px; object-fit: cover;">
                    </div>
                    <div class="col-5">
                        <h6 class="mb-1">${this.truncateText(item.name, 30)}</h6>
                        <p class="text-muted mb-0">${this.formatCurrency(item.price)}</p>
                    </div>
                    <div class="col-4">
                        <div class="input-group input-group-sm">
                            <button class="btn btn-outline-secondary decrease-qty" 
                                    data-row-id="${item.rowId}">-</button>
                            <input type="number" class="form-control text-center quantity-input" 
                                   value="${item.qty}" min="1" 
                                   data-row-id="${item.rowId}"
                                   data-max-quantity="${item.options.max_quantity || 100}">
                            <button class="btn btn-outline-secondary increase-qty" 
                                    data-row-id="${item.rowId}">+</button>
                        </div>
                        <button class="btn btn-link text-danger btn-sm mt-1 p-0 remove-item" 
                                data-row-id="${item.rowId}">
                            <i class="fas fa-trash"></i> Remover
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    generateCartPageHTML() {
        if (this.items.length === 0) {
            return `
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Seu carrinho está vazio</h4>
                    <p class="text-muted">Adicione alguns produtos para começar</p>
                    <a href="{{ route('marketplace.index') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-store me-2"></i>Continuar Comprando
                    </a>
                </div>
            `;
        }

        return `
            <div class="table-responsive">
                <table class="table cart-table">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${this.items.map(item => `
                            <tr data-row-id="${item.rowId}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="${item.options.image}" alt="${item.name}" 
                                             class="rounded me-3" width="60" height="60" 
                                             style="object-fit: cover;">
                                        <div>
                                            <h6 class="mb-1">${item.name}</h6>
                                            ${item.options.variants ? `
                                                <small class="text-muted">${this.formatVariants(item.options.variants)}</small>
                                            ` : ''}
                                        </div>
                                    </div>
                                </td>
                                <td>${this.formatCurrency(item.price)}</td>
                                <td>
                                    <div class="input-group input-group-sm" style="width: 120px;">
                                        <button class="btn btn-outline-secondary decrease-qty">-</button>
                                        <input type="number" class="form-control text-center quantity-input" 
                                               value="${item.qty}" min="1" 
                                               data-max-quantity="${item.options.max_quantity || 100}">
                                        <button class="btn btn-outline-secondary increase-qty">+</button>
                                    </div>
                                </td>
                                <td>${this.formatCurrency(item.price * item.qty)}</td>
                                <td>
                                    <button class="btn btn-link text-danger remove-item" title="Remover">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        `;
    }

    // Event Handlers
    initSidebarEvents() {
        this.initQuantityControls('#cartSidebar');
        this.initRemoveItemButtons('#cartSidebar');
    }

    initCartPageEvents() {
        this.initQuantityControls('.cart-page');
        this.initRemoveItemButtons('.cart-page');
        this.initCartActionsHandlers();
    }

    initQuantityControls(container = document) {
        const context = typeof container === 'string' ? document.querySelector(container) : container;
        
        context.querySelectorAll('.increase-qty').forEach(btn => {
            btn.addEventListener('click', () => {
                const rowId = btn.dataset.rowId;
                const input = btn.parentElement.querySelector('.quantity-input');
                const max = parseInt(input.dataset.maxQuantity) || 100;
                
                if (parseInt(input.value) < max) {
                    this.updateQuantity(rowId, parseInt(input.value) + 1);
                }
            });
        });

        context.querySelectorAll('.decrease-qty').forEach(btn => {
            btn.addEventListener('click', () => {
                const rowId = btn.dataset.rowId;
                const input = btn.parentElement.querySelector('.quantity-input');
                
                if (parseInt(input.value) > 1) {
                    this.updateQuantity(rowId, parseInt(input.value) - 1);
                }
            });
        });

        context.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', () => {
                const rowId = input.dataset.rowId;
                const max = parseInt(input.dataset.maxQuantity) || 100;
                let quantity = parseInt(input.value);
                
                if (quantity < 1) quantity = 1;
                if (quantity > max) quantity = max;
                
                input.value = quantity;
                this.updateQuantity(rowId, quantity);
            });
        });
    }

    initRemoveItemButtons(container = document) {
        const context = typeof container === 'string' ? document.querySelector(container) : container;
        
        context.querySelectorAll('.remove-item').forEach(btn => {
            btn.addEventListener('click', () => {
                const rowId = btn.dataset.rowId;
                this.removeItem(rowId);
            });
        });
    }

    // Utility Methods
    getTotalItems() {
        return this.items.reduce((total, item) => total + item.qty, 0);
    }

    getSubtotal() {
        return this.items.reduce((total, item) => total + (item.price * item.qty), 0);
    }

    getTax() {
        return this.getSubtotal() * 0.14; // 14% IVA
    }

    getTotal() {
        return this.getSubtotal() + this.getTax() + this.getShipping();
    }

    getShipping() {
        // Exemplo simples: grátis acima de 100€, senão 5€
        return this.getSubtotal() > 100 ? 0 : 5;
    }
    formatCurrency(amount) {
        return new Intl.NumberFormat('pt-PT', {
            style: 'currency',
            currency: 'EUR'
        }).format(amount);
    }

    formatVariants(variants) {
        return Object.entries(variants)
            .map(([key, value]) => `${key}: ${value}`)
            .join(', ');
    }

    truncateText(text, maxLength) {
        return text.length > maxLength ? text.substring(0, maxLength) + '…' : text;
    }

    // -------- Storage --------
    loadCart() {
        try {
            const stored = localStorage.getItem('pregao_cart');
            return stored ? JSON.parse(stored) : [];
        } catch (e) {
            return [];
        }
    }

    saveCart() {
        localStorage.setItem('pregao_cart', JSON.stringify(this.items));
    }

    // -------- Emit Events --------
    emitCartUpdated() {
        document.dispatchEvent(new CustomEvent('cartUpdated', { detail: this.items }));
    }

    handleCartUpdate(newCart) {
        this.items = newCart;
        this.saveCart();
        this.updateUI();
    }

    // -------- Sidebar --------
    toggleCartSidebar() {
        const sidebar = document.getElementById('cartSidebar');
        if (sidebar) {
            const bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(sidebar);
            bsOffcanvas.toggle();
        }
    }
}

// Inicializar globalmente
window.PregaoCart = new Cart();

export default Cart;
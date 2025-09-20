<footer class="bg-dark text-white py-5 mt-5">
    <div class="container">
        <div class="row">
            <!-- Company Info -->
            <div class="col-lg-4 mb-4">
                <img src="{{ asset('images/logo-white.png') }}" alt="PREGÃO" height="40" class="mb-3">
                <p class="text-muted">
                    O marketplace líder em Angola, conectando empresas, lojistas e clientes.
                </p>
                <div class="social-links">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-4 mb-4">
                <h5 class="text-uppercase mb-4">Marketplace</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('marketplace.index') }}" class="text-muted">Início</a></li>
                    <li class="mb-2"><a href="{{ route('stores.index') }}" class="text-muted">Lojas</a></li>
                    <li class="mb-2"><a href="#" class="text-muted">Categorias</a></li>
                    <li class="mb-2"><a href="#" class="text-muted">Produtos em Destaque</a></li>
                </ul>
            </div>

            <!-- Customer Service -->
            <div class="col-lg-2 col-md-4 mb-4">
                <h5 class="text-uppercase mb-4">Ajuda</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-muted">Centro de Ajuda</a></li>
                    <li class="mb-2"><a href="#" class="text-muted">Como Comprar</a></li>
                    <li class="mb-2"><a href="#" class="text-muted">Devoluções</a></li>
                    <li class="mb-2"><a href="#" class="text-muted">Contactos</a></li>
                </ul>
            </div>

            <!-- Business -->
            <div class="col-lg-2 col-md-4 mb-4">
                <h5 class="text-uppercase mb-4">Para Lojistas</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-muted">Vender no PREGÃO</a></li>
                    <li class="mb-2"><a href="#" class="text-muted">Central do Lojista</a></li>
                    <li class="mb-2"><a href="#" class="text-muted">Programa de Afiliados</a></li>
                    <li class="mb-2"><a href="#" class="text-muted">Publicidade</a></li>
                </ul>
            </div>

            <!-- Contact & Newsletter -->
            <div class="col-lg-2 mb-4">
                <h5 class="text-uppercase mb-4">Newsletter</h5>
                <p class="text-muted">Subscreva para receber ofertas exclusivas</p>
                <form>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Seu email" aria-label="Email">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <hr class="my-4 bg-secondary">

        <!-- Bottom Footer -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-muted mb-0">&copy; 2024 PREGÃO. Todos os direitos reservados.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="payment-methods">
                    <span class="text-muted me-2">Métodos de pagamento:</span>
                    <i class="fab fa-cc-visa me-2"></i>
                    <i class="fab fa-cc-mastercard me-2"></i>
                    <i class="fab fa-cc-paypal me-2"></i>
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
    </div>
</footer>
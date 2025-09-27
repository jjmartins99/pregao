<footer class="bg-light border-top mt-5">
    <div class="container py-4">
        <div class="row">
            {{-- Sobre --}}
            <div class="col-md-4 mb-3">
                <h6 class="fw-bold">Sobre o PREGÃO</h6>
                <p class="text-muted small">
                    O marketplace que conecta clientes, empresas e vendedores em
                    um só lugar. Compra e venda de forma simples e segura.
                </p>
            </div>

            {{-- Links --}}
            <div class="col-md-4 mb-3">
                <h6 class="fw-bold">Navegação</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('marketplace.index') }}" class="text-decoration-none text-muted">Início</a></li>
                    <li><a href="{{ route('marketplace.categories') }}" class="text-decoration-none text-muted">Categorias</a></li>
                    <li><a href="{{ route('marketplace.stores') }}" class="text-decoration-none text-muted">Lojas</a></li>
                    <li><a href="{{ route('marketplace.compare') }}" class="text-decoration-none text-muted">Comparar</a></li>
                </ul>
            </div>

            {{-- Contactos --}}
            <div class="col-md-4 mb-3">
                <h6 class="fw-bold">Contactos</h6>
                <p class="text-muted small mb-1"><i class="fas fa-envelope me-2"></i> suporte@pregao.com</p>
                <p class="text-muted small mb-1"><i class="fas fa-phone me-2"></i> +244 999 999 999</p>
                <p class="text-muted small"><i class="fas fa-map-marker-alt me-2"></i> Luanda, Angola</p>
            </div>
        </div>

        <div class="text-center border-top pt-3 mt-3 small text-muted">
            © {{ date('Y') }} PREGÃO Marketplace. Todos os direitos reservados.
        </div>
    </div>
</footer>

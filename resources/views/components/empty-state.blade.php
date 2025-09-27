@props([
    'icon' => 'fas fa-box-open',
    'title' => 'Nada encontrado',
    'message' => 'Não existem itens para mostrar.',
    'action' => null,
])

<div class="text-center py-5">
    <i class="{{ $icon }} fa-3x text-muted mb-3"></i>
    <h5 class="fw-bold text-muted">{{ $title }}</h5>
    <p class="text-muted">{{ $message }}</p>
    @if ($action)
        <div class="mt-3">
            {{ $action }}
        </div>
    @endif
</div>

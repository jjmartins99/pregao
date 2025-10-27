@props(['type' => 'info', 'message' => null])

@php
    $types = [
        'success' => 'alert-success',
        'error'   => 'alert-danger',
        'warning' => 'alert-warning',
        'info'    => 'alert-info',
    ];
    $class = 'alert ' . ($types[$type] ?? 'alert-info') . ' alert-dismissible fade show';
@endphp


<div class="card h-100 product-card">
    <div class="position-relative">  
            @if(Auth::check())
                <button class="btn btn-primary" data-user-id="{{ Auth::id() }}">
                    <i class="fas fa-cart-plus me-2"></i> Adicionar ao Carrinho
                </button>
            @else
                <button class="btn btn-secondary" disabled>
                    <i class="fas fa-times-circle me-2"></i> Esgotado
                </button>
            @endif
    @if ($message)
    <div class="alert {{ $class }} alert-dismissible fade show" role="alert">
    @if ($message)
    <div class="{{ $class }}" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
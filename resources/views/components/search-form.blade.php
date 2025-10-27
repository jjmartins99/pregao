@props([
    'action' => route('products.search'),
    'placeholder' => 'Pesquisar produtos...',
    'name' => 'q',
])

<form method="GET" action="{{ $action }}" {{ $attributes->merge(['class' => 'd-flex search-form']) }}>
    <input type="text" 
           name="{{ $name }}" 
           value="{{ request($name) }}" 
           class="form-control me-2"
           placeholder="{{ $placeholder }}">
    <button class="btn btn-outline-primary" type="submit">
        <i class="fas fa-search"></i>
    </button>
</form>

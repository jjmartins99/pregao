@extends('layouts.marketplace')

@section('title', 'Resultados da Busca')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Resultados para: <span class="text-primary">"{{ request('q') }}"</span></h3>

    <div class="row">
        <div class="col-md-3">
            <!-- Filtros -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">Filtros</div>
                <div class="card-body">
                    <form method="GET" action="{{ route('products.search') }}">
                        <input type="hidden" name="q" value="{{ request('q') }}">

                        <div class="mb-3">
                            <label for="category" class="form-label">Categoria</label>
                            <select class="form-select" name="category">
                                <option value="">Todas</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" 
                                        {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Preço</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="min" placeholder="Mín" value="{{ request('min') }}">
                                <input type="number" class="form-control" name="max" placeholder="Máx" value="{{ request('max') }}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            @if($products->count())
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 mb-4">
                            @include('components.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>

                <div class="mt-3">
                    {{ $products->links() }}
                </div>
            @else
                <div class="alert alert-info">Nenhum produto encontrado.</div>
            @endif
        </div>
    </div>
</div>
@endsection

@extends('layouts.vendor')

@section('title', 'Dashboard do Lojista')

@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4">Bem-vindo, {{ auth()->user()->name }}</h2>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5>Produtos</h5>
                    <h3>{{ $productsCount ?? 0 }}</h3>
                    <a href="{{ route('seller.products') }}" class="btn btn-sm btn-outline-primary mt-2">Gerir</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5>Encomendas</h5>
                    <h3>{{ $ordersCount ?? 0 }}</h3>
                    <a href="{{ route('seller.orders') }}" class="btn btn-sm btn-outline-success mt-2">Ver</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5>Receita</h5>
                    <h3>{{ number_format($revenue ?? 0, 2, ',', '.') }} Kz</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

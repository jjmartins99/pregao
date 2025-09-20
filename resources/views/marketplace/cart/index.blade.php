@extends('layouts.marketplace')

@section('title', 'Carrinho de Compras')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Carrinho de Compras</h3>

    @if(count($cartItems))
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td class="d-flex align-items-center">
                                <img src="{{ $item->product->image_url ?? asset('images/product-placeholder.png') }}"
                                     alt="{{ $item->product->name }}"
                                     class="me-3 rounded"
                                     style="width: 60px; height: 60px; object-fit: cover;">
                                <div>
                                    <strong>{{ $item->product->name }}</strong><br>
                                    <small class="text-muted">{{ $item->product->store->name }}</small>
                                </div>
                            </td>
                            <td>{{ number_format($item->product->price, 2, ',', '.') }} Kz</td>
                            <td>
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                           class="form-control form-control-sm me-2" style="width: 70px;">
                                    <button class="btn btn-sm btn-outline-secondary">Atualizar</button>
                                </form>
                            </td>
                            <td>{{ number_format($item->total, 2, ',', '.') }} Kz</td>
                            <td>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Remover</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Resumo -->
        <div class="row mt-4">
            <div class="col-md-6 offset-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="d-flex justify-content-between">
                            <span>Total:</span>
                            <span class="text-primary">{{ number_format($cartTotal, 2, ',', '.') }} Kz</span>
                        </h5>
                        <a href="{{ route('checkout.index') }}" class="btn btn-success w-100 mt-3">Finalizar Compra</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">O seu carrinho está vazio.</div>
    @endif
</div>
@endsection

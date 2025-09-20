@extends('layouts.marketplace')

@section('title', 'Finalizar Compra')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Finalizar Compra</h3>

    <div class="row">
        <!-- Formulário de Dados -->
        <div class="col-md-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header">Informações do Cliente</div>
                <div class="card-body">
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Endereço</label>
                            <textarea class="form-control" name="address" id="address" rows="3" required>{{ old('address') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}" required>
                        </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header">Método de Pagamento</div>
                <div class="card-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash" checked>
                        <label class="form-check-label" for="cash">
                            Pagamento na Entrega
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="payment_method" id="card" value="card">
                        <label class="form-check-label" for="card">
                            Cartão de Crédito/Débito
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="payment_method" id="transfer" value="transfer">
                        <label class="form-check-label" for="transfer">
                            Transferência Bancária
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumo do Pedido -->
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header">Resumo do Pedido</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($cartItems as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $item->product->name }}</strong><br>
                                    <small>{{ $item->quantity }} x {{ number_format($item->product->price, 2, ',', '.') }} Kz</small>
                                </div>
                                <span>{{ number_format($item->total, 2, ',', '.') }} Kz</span>
                            </li>
                        @endforeach
                    </ul>
                    <hr>
                    <h5 class="d-flex justify-content-between">
                        <span>Total:</span>
                        <span class="text-primary">{{ number_format($cartTotal, 2, ',', '.') }} Kz</span>
                    </h5>
                    <button type="submit" class="btn btn-success w-100 mt-3">Confirmar Pedido</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('page-title', 'Gestão de Lojas')
@section('page-subtitle', 'Administre os vendedores e lojas do marketplace')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Lojas</h5>
            <a href="{{ route('admin.stores.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Nova Loja
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Loja</th>
                        <th>Proprietário</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Aprovação</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stores as $store)
                        <tr>
                            <td>{{ $store->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $store->logo_url ?? asset('images/store-placeholder.png') }}"
                                         class="rounded me-2" width="40" height="40" alt="Logo">
                                    <span>{{ $store->name }}</span>
                                </div>
                            </td>
                            <td>{{ $store->owner->name }}</td>
                            <td>{{ $store->owner->email }}</td>
                            <td>
                                <x-badge-status :status="$store->status" />
                            </td>
                            <td>
                                @if($store->approved)
                                    <span class="badge bg-success">Aprovada</span>
                                @else
                                    <form action="{{ route('admin.stores.approve', $store) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-check"></i> Aprovar
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.stores.edit', $store) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.stores.toggle', $store) }}" method="POST" 
                                      class="d-inline-block">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $store->status === 'active' ? 'btn-danger' : 'btn-success' }}">
                                        <i class="fas {{ $store->status === 'active' ? 'fa-ban' : 'fa-play' }}"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <x-empty-state 
                                    title="Nenhuma loja encontrada"
                                    description="Ainda não existem vendedores registados."
                                />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-pagination :paginator="$stores" class="mt-3" />
    </div>
</div>
@endsection

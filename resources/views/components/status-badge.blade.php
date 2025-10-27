@props(['status'])

@php
    $map = [
        'pending'   => ['badge bg-warning text-dark', 'Pendente'],
        'paid'      => ['badge bg-success', 'Pago'],
        'shipped'   => ['badge bg-info text-dark', 'Enviado'],
        'delivered' => ['badge bg-primary', 'Entregue'],
        'canceled'  => ['badge bg-danger', 'Cancelado'],
        'active'    => ['badge bg-success', 'Ativo'],
        'inactive'  => ['badge bg-secondary', 'Inativo'],
    ];

    [$class, $label] = $map[$status] ?? ['badge bg-secondary', ucfirst($status)];
@endphp

<span {{ $attributes->merge(['class' => $class]) }}>
    {{ $label }}
</span>

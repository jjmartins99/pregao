@props([
    'type' => 'primary', // primary, secondary, success, danger, outline
    'size' => 'md',      // sm, md, lg
    'icon' => null,
    'url' => null,
    'submit' => false,
])

@php
    $base = 'btn';
    $classes = match($type) {
        'secondary' => "$base btn-secondary",
        'success'   => "$base btn-success",
        'danger'    => "$base btn-danger",
        'outline'   => "$base btn-outline-primary",
        default     => "$base btn-primary",
    };

    $sizeClass = match($size) {
        'sm' => 'btn-sm',
        'lg' => 'btn-lg',
        default => '',
    };
@endphp

@if ($url)
    <a href="{{ $url }}" {{ $attributes->merge(['class' => "$classes $sizeClass"]) }}>
        @if($icon)<i class="{{ $icon }} me-1"></i>@endif
        {{ $slot }}
    </a>
@else
    <button 
        @if($submit) type="submit" @else type="button" @endif 
        {{ $attributes->merge(['class' => "$classes $sizeClass"]) }}>
        @if($icon)<i class="{{ $icon }} me-1"></i>@endif
        {{ $slot }}
    </button>
@endif

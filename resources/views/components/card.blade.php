@props([
    'title' => null,
    'footer' => null,
])

<div {{ $attributes->merge(['class' => 'card shadow-sm mb-3']) }}>
    @if($title)
        <div class="card-header fw-bold">{{ $title }}</div>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="card-footer text-muted">
            {{ $footer }}
        </div>
    @endif
</div>

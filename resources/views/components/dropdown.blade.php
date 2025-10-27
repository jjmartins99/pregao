@props([
    'label' => 'Opções',
    'icon' => 'fas fa-ellipsis-v',
    'items' => [], // array [ ['label' => '', 'url' => '', 'icon' => ''] ]
])

<div class="dropdown">
    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        @if($icon) <i class="{{ $icon }}"></i> @endif {{ $label }}
    </button>
    <ul class="dropdown-menu">
        @foreach($items as $item)
            <li>
                <a class="dropdown-item" href="{{ $item['url'] ?? '#' }}">
                    @if(!empty($item['icon'])) <i class="{{ $item['icon'] }} me-2"></i>@endif
                    {{ $item['label'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>

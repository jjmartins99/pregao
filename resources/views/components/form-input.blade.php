@props([
    'label' => null,
    'name',
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'icon' => null,
    'required' => false,
])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif

    <div class="input-group">
        @if($icon)
            <span class="input-group-text"><i class="{{ $icon }}"></i></span>
        @endif
        <input 
            type="{{ $type }}" 
            id="{{ $name }}" 
            name="{{ $name }}" 
            value="{{ old($name, $value) }}" 
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'form-control'.($errors->has($name) ? ' is-invalid' : '')]) }}>
    </div>

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

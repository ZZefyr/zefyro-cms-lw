@props([
    'label',
    'name',
    'error' => null,
    'help' => null,
])

<div class="mb-3">
    <div class="form-check">
        <input
            type="checkbox"
            id="{{ $name }}"
            name="{{ $name }}"
            value="1"
            {{ $attributes->merge(['class' => 'form-check-input' . ($error ? ' is-invalid' : '')]) }}
        >
        <label class="form-check-label" for="{{ $name }}">
            {{ $label }}
        </label>

        @if($help)
            <small class="form-text text-muted d-block">{{ $help }}</small>
        @endif

        @if($error)
            <div class="invalid-feedback d-block">{{ $error }}</div>
        @endif
    </div>
</div>

@props([
    'label' => null,
    'name',
    'options' => [],
    'error' => null,
    'help' => null,
    'required' => false,
    'placeholder' => 'Vyberte...',
])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'form-select' . ($error ? ' is-invalid' : '')]) }}
        @if($required) required @endif
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach($options as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>

    @if($help)
        <small class="form-text text-muted">{{ $help }}</small>
    @endif

    @if($error)
        <div class="invalid-feedback d-block">{{ $error }}</div>
    @endif
</div>

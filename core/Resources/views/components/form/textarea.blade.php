@props([
    'label' => null,
    'name',
    'rows' => 4,
    'error' => null,
    'help' => null,
    'required' => false,
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

    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        {{ $attributes->merge(['class' => 'form-control' . ($error ? ' is-invalid' : '')]) }}
        @if($required) required @endif
    >{{ $slot }}</textarea>

    @if($help)
        <small class="form-text text-muted">{{ $help }}</small>
    @endif

    @if($error)
        <div class="invalid-feedback d-block">{{ $error }}</div>
    @endif
</div>

@props([
    'label' => null,
    'name',
    'type' => 'text',
    'error' => null,
    'help' => null,
    'required' => false,
])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $attributes->merge([
            'class' => 'block w-full rounded-lg border px-4 py-2.5 text-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-1 ' .
            ($error
                ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500'
                : 'border-gray-300 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 hover:border-gray-400'
            )
        ]) }}
        @if($required) required @endif
    >

    @if($help)
        <p class="mt-1.5 text-xs text-gray-500">{{ $help }}</p>
    @endif

    @if($error)
        <p class="mt-1.5 text-sm text-red-600">{{ $error }}</p>
    @endif
</div>

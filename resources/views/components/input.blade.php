@props(['error' => false, 'disabled' => false, 'variant' => 'text', 'placeholder' => null])

<input
    type="{{ $variant }}"
    @disabled($disabled)
    {{ $attributes->merge(['class' => 'field-control' . ($error ? ' field-invalid' : '')]) }}
    @if($placeholder) placeholder="{{ $placeholder }}" @endif
/>
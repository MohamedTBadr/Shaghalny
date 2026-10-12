@props(['error' => false, 'disabled' => false, 'rows' => 4])

<textarea
    rows="{{ $rows }}"
    @disabled($disabled)
    {{ $attributes->merge(['class' => 'field-control resize-y' . ($error ? ' field-invalid' : '')]) }}
>{{ $slot }}</textarea>
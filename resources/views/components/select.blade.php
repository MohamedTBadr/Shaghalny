@props(['error' => false, 'disabled' => false, 'placeholder' => null])

<select
    @disabled($disabled)
    {{ $attributes->merge(['class' => 'field-control' . ($error ? ' field-invalid' : '')]) }}
>
    {{ $slot }}
</select>
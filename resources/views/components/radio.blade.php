@props(['error' => false, 'disabled' => false, 'checked' => false])

<input
    type="radio"
    @checked($checked)
    @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-border text-brand focus:ring-brand focus:ring-2 focus:ring-offset-0 transition-colors duration-150' . ($error ? ' border-accent-danger' : '')]) }}
>
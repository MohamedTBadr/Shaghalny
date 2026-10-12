@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'flex items-center px-4 py-2 w-full text-sm font-semibold text-brand bg-brand-subtle rounded-lg focus:outline-none hover:bg-brand-100 transition duration-150 ease-in-out'
        : 'flex items-center px-4 py-2 w-full text-sm font-medium text-ink-secondary hover:text-ink-primary hover:bg-surface-muted rounded-lg focus:outline-none transition duration-150 ease-in-out';
@endphp

<li>
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>
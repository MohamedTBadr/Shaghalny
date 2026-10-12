@props(['variant' => 'default'])

@php
    $variants = [
        'default' => 'text-ink-secondary hover:text-brand hover:bg-surface-muted',
        'sidebar' => 'text-white/60 hover:text-white hover:bg-white/10',
    ];
@endphp

<button type="button"
        onclick="window.toggleTheme && window.toggleTheme()"
        aria-label="Toggle color theme"
        title="Toggle light / dark theme"
        {{ $attributes->merge(['class' => 'inline-flex items-center justify-center p-2 rounded-lg transition-colors ' . ($variants[$variant] ?? $variants['default'])]) }}>
    <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
    </svg>
    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>
</button>

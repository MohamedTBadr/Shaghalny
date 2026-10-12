@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'href' => null
])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-1 disabled:opacity-50 disabled:cursor-not-allowed shadow-sm';

$variants = [
    'primary' => 'bg-brand text-accent-contrast hover:bg-brand-hover focus:ring-brand shadow-subtle',
    'secondary' => 'bg-surface text-ink-primary border border-border hover:bg-surface-subtle focus:ring-brand/30 shadow-subtle',
    'success' => 'bg-accent-success text-accent-contrast hover:brightness-95 focus:ring-accent-success',
    'danger' => 'bg-accent-danger text-accent-contrast hover:brightness-95 focus:ring-accent-danger',
    'danger-outline' => 'bg-surface text-accent-danger border border-accent-danger/30 hover:bg-accent-danger-subtle focus:ring-accent-danger/30 shadow-subtle',
    'warning' => 'bg-accent-warning text-accent-contrast hover:brightness-95 focus:ring-accent-warning',
    'subtle' => 'bg-brand-subtle text-brand hover:bg-brand-100 focus:ring-brand shadow-none',
    'ghost' => 'bg-transparent text-ink-secondary hover:text-ink-primary hover:bg-surface-muted focus:ring-brand/20 shadow-none',
];

$sizes = [
    'xs' => 'px-2 py-1 text-xs gap-1',
    'sm' => 'px-3 py-1.5 text-xs font-semibold gap-1.5',
    'md' => 'px-4 py-2 text-sm font-semibold gap-2',
    'lg' => 'px-5 py-2.5 text-base font-semibold gap-2.5',
];

$classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
 

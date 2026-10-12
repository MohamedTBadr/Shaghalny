@props([
    'variant' => 'neutral',
    'size' => 'sm'
])

@php
$baseClasses = 'inline-flex items-center font-medium rounded-full';

$variants = [
    'primary' => 'bg-brand text-accent-contrast',
    'brand'        => 'bg-brand-subtle text-brand border border-brand/20',
    'brand-subtle' => 'bg-brand-subtle text-brand border border-brand/20',
    'neutral' => 'bg-surface-muted text-ink-secondary border border-border',
    'success' => 'bg-accent-success-subtle text-accent-success border border-accent-success/25',
    'warning' => 'bg-accent-warning-subtle text-accent-warning border border-accent-warning/25',
    'danger' => 'bg-accent-danger-subtle text-accent-danger border border-accent-danger/25',
    'info' => 'bg-accent-info-subtle text-accent-info border border-accent-info/25',
    // Types
    'Full-Time' => 'bg-brand-subtle text-brand border border-brand/20',
    'Remote' => 'bg-accent-success-subtle text-accent-success border border-accent-success/25',
    'Hybrid' => 'bg-accent-info-subtle text-accent-info border border-accent-info/25',
    'Contract' => 'bg-accent-warning-subtle text-accent-warning border border-accent-warning/25',
    // Statuses
    'Pending' => 'bg-accent-warning-subtle text-accent-warning border border-accent-warning/25',
    'Accepted' => 'bg-accent-success-subtle text-accent-success border border-accent-success/25',
    'Rejected' => 'bg-accent-danger-subtle text-accent-danger border border-accent-danger/25',
];

$sizes = [
    'xs' => 'px-2 py-0.5 text-[11px]',
    'sm' => 'px-2.5 py-1 text-xs gap-1.5',
    'md' => 'px-3 py-1.5 text-sm gap-2',
];

$classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['neutral']) . ' ' . ($sizes[$size] ?? $sizes['sm']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>

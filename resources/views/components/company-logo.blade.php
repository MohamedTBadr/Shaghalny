@props(['company' => null, 'name' => null, 'size' => 'md', 'href' => null])

@php
    $label = $name ?? optional($company)->name ?? '?';
    $initials = collect(explode(' ', $label))
        ->filter()
        ->take(2)
        ->map(fn($word) => \Illuminate\Support\Str::substr($word, 0, 1))
        ->join('');

    $sizeClasses = [
        'xs' => 'w-8 h-8 text-xs rounded-lg',
        'sm' => 'w-10 h-10 text-sm rounded-xl',
        'md' => 'w-12 h-12 text-base rounded-xl',
        'lg' => 'w-16 h-16 text-xl rounded-2xl',
        'xl' => 'w-20 h-20 text-2xl rounded-2xl',
    ];
    $classes = $sizeClasses[$size]
        . ' bg-brand-subtle border border-brand/15 text-brand font-extrabold uppercase flex items-center justify-center font-display shrink-0';
@endphp

@if($href)
    <a href="{{ $href }}" class="inline-flex" aria-label="{{ $label }}">
        <div {{ $attributes->merge(['class' => $classes]) }}>{{ $initials ?: '?' }}</div>
    </a>
@else
    <div {{ $attributes->merge(['class' => $classes]) }}>{{ $initials ?: '?' }}</div>
@endif
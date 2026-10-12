@props([
    'title'    => null,
    'label'    => null,
    'value',
    'subtitle' => null,
    'caption'  => null,
    'trend'    => null,
    'trendUp'  => true,
    'icon'     => null,
])
@php
    $displayTitle    = $title ?? $label;
    $displaySubtitle = $subtitle ?? $caption;
@endphp

<div {{ $attributes->merge(['class' => 'bg-surface border border-border rounded-xl p-6 shadow-card hover:shadow-card-hover transition-all duration-200']) }}>
    <div class="flex items-center justify-between">
        <p class="text-xs font-semibold uppercase tracking-wider text-ink-secondary">{{ $displayTitle }}</p>
        @if(isset($icon))
            <div class="w-10 h-10 rounded-lg bg-brand-subtle text-brand flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icon !!}</svg>
            </div>
        @endif
    </div>
    
    <div class="mt-3 flex items-baseline gap-2">
        <h4 class="text-3xl font-extrabold text-ink-primary tracking-tight font-display">{{ $value }}</h4>
        @if($trend)
            <span class="inline-flex items-center text-xs font-semibold {{ $trendUp ? 'text-accent-success' : 'text-accent-danger' }}">
                @if($trendUp)
                    <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                @else
                    <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                @endif
                {{ $trend }}
            </span>
        @endif
    </div>

    @if($displaySubtitle)
        <p class="mt-1 text-xs text-ink-muted">{{ $displaySubtitle }}</p>
    @endif
</div>

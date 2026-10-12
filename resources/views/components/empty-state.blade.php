@props(['icon' => null, 'title' => null, 'description' => null])

<div {{ $attributes->merge(['class' => 'empty-state']) }}>
    @if($icon)
        <div class="w-12 h-12 rounded-xl bg-surface-muted text-ink-muted flex items-center justify-center mb-4">
            {!! $icon !!}
        </div>
    @endif

    @if($title)
        <h3 class="text-heading-card font-bold text-ink-primary">{{ $title }}</h3>
    @endif

    @if($description)
        <p class="mt-1.5 text-sm text-ink-muted max-w-sm">
            {{ $description }}
        </p>
    @endif

    @isset($action)
        <div class="mt-5">{{ $action }}</div>
    @endisset
</div>
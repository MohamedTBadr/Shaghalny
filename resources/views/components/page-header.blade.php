@props(['title', 'description' => null, 'icon' => null])

<div {{ $attributes->merge(['class' => 'flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4']) }}>
    <div>
        <h1 class="text-heading-page font-extrabold text-ink-primary tracking-tight">{{ $title }}</h1>
        @if($description)
            <p class="mt-1 text-body text-ink-secondary">{{ $description }}</p>
        @endif
    </div>

    @isset($actions)
        <div class="flex items-center gap-2 flex-shrink-0">
            {{ $actions }}
        </div>
    @endisset
</div>
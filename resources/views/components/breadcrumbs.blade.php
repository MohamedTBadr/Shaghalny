@props(['items' => []])

<nav aria-label="Breadcrumb" class="flex items-center gap-1.5 text-xs text-ink-muted">
    <a href="{{ url('/') }}" class="hover:text-ink-primary transition-colors">
        Home
    </a>

@foreach($items as $item)
    @if(! $item)
        @continue
    @endif
    <svg class="w-3 h-3 text-ink-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>

    @if(isset($item['href']))
        <a href="{{ $item['href'] }}" class="hover:text-ink-primary transition-colors">
            {{ $item['label'] }}
        </a>
    @else
        <span class="text-ink-primary font-medium">{{ $item['label'] }}</span>
    @endif
@endforeach
</nav>
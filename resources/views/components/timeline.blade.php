@props(['items' => []])

<ol {{ $attributes->merge(['class' => 'relative border-l border-border border-l-2 ml-1.5 space-y-5']) }}>
    @foreach($items as $item)
        @php
            $tone = $item['tone'] ?? 'brand';
            $tones = [
                'brand' => 'border-brand bg-brand',
                'success' => 'border-accent-success bg-accent-success',
                'warning' => 'border-accent-warning bg-accent-warning',
                'danger' => 'border-accent-danger bg-accent-danger',
                'neutral' => 'border-border bg-surface',
            ];
        @endphp
        <li class="relative pl-7">
            <span class="absolute -left-[7px] top-0.5 w-3.5 h-3.5 rounded-full border-2 {{ $tones[$tone] }}" aria-hidden="true"></span>

            <p class="font-semibold text-sm text-ink-primary">{{ $item['title'] }}</p>

            @if($item['description'] ?? null)
                <p class="mt-0.5 text-sm text-ink-secondary">{{ $item['description'] }}</p>
            @endif

            @if($item['timestamp'] ?? null)
                <p class="mt-1 text-xs text-ink-muted">{{ $item['timestamp'] }}</p>
            @endif
        </li>
    @endforeach
</ol>

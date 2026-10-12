@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'flex items-start gap-2 rounded-xl border border-accent-success/25 bg-accent-success-subtle px-4 py-3 font-medium text-sm text-accent-success-strong']) }}>
        {{ $status }}
    </div>
@endif

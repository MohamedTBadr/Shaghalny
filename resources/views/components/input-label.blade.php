@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-xs text-ink-secondary mb-1.5 uppercase tracking-wider']) }}>
    {{ $value ?? $slot }}
</label>


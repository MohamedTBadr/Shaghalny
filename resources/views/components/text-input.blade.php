@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border border-border bg-surface text-ink-primary placeholder:text-ink-muted rounded-lg shadow-subtle focus:border-brand focus:ring-1 focus:ring-brand text-sm px-3.5 py-2.5 transition-colors duration-150 disabled:bg-surface-muted disabled:text-ink-muted']) }}>


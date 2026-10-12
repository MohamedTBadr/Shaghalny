<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-surface text-ink-primary border border-border rounded-lg shadow-subtle font-semibold text-sm hover:bg-surface-subtle focus:outline-none focus:ring-2 focus:ring-brand/30 focus:ring-offset-1 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-150']) }}>
    {{ $slot }}
</button>

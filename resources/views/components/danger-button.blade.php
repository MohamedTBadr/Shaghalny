<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-accent-danger text-white rounded-lg border border-transparent font-semibold text-sm hover:bg-accent-danger-strong focus:outline-none focus:ring-2 focus:ring-accent-danger focus:ring-offset-1 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-150']) }}>
    {{ $slot }}
</button>

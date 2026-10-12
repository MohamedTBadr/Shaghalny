<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-brand hover:bg-brand-hover active:bg-brand-700 text-white font-semibold text-sm rounded-lg shadow-subtle focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 transition-all duration-150 disabled:opacity-50']) }}>
    {{ $slot }}
</button>


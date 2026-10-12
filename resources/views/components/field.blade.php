@props(['label' => null, 'hint' => null, 'error' => null, 'required' => false, 'for' => null])

<div {{ $attributes->only('class') }}>
    @if($label)
        <label for="{{ $for }}" class="flex items-center gap-0.5 field-label mb-1.5">
            {{ $label }}
            @if($required)
                <span class="text-accent-danger">*</span>
            @endif
        </label>
    @endif

    {{ $slot }}

    @if($hint)
        <p class="field-hint mt-1.5">{{ $hint }}</p>
    @endif

    @if($error)
        <p class="field-error">{{ $error }}</p>
    @endif
</div>
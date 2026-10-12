@php
    $layout = auth()->user()->role === 'job_seeker' ? 'app-seeker' : 'app-layout';
@endphp

<x-dynamic-component :component="$layout">
    <x-slot name="header">
        <div>
            <h1 class="text-lg font-bold text-ink-primary font-display tracking-tight">{{ __('Profile settings') }}</h1>
            <p class="text-xs text-ink-secondary mt-0.5">{{ __('Manage your account information and security.') }}</p>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="card p-6 sm:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="card p-6 sm:p-8">
            @include('profile.partials.update-password-form')
        </div>

        <div class="card p-6 sm:p-8 border-accent-danger/25">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-dynamic-component>

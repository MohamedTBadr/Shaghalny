<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold font-display tracking-tight text-ink-primary">Reset your password</h1>
        <p class="text-sm text-ink-secondary mt-1.5">
            {{ __('Enter your email address and we will send you a link to choose a new password.') }}
        </p>
    </div>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <x-field label="Email address" for="email" :error="$errors->first('email')" required>
            <x-input id="email" variant="email" name="email" :value="old('email')" required autofocus placeholder="you@example.com" :error="$errors->has('email')" />
        </x-field>

        <x-button type="submit" variant="primary" size="lg" class="w-full justify-center">
            {{ __('Email password reset link') }}
        </x-button>
    </form>

    <p class="mt-8 text-center text-sm text-ink-secondary">
        <a href="{{ route('login') }}" class="font-semibold text-brand hover:text-brand-hover transition-colors">{{ __('Back to sign in') }}</a>
    </p>
</x-guest-layout>

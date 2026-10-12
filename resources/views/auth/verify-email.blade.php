<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold font-display tracking-tight text-ink-primary">Verify your email</h1>
        <p class="text-sm text-ink-secondary mt-1.5">
            {{ __('Thanks for signing up! Please verify your email address by clicking the link we just sent you.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <x-alert variant="success" class="mb-5">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </x-alert>
    @endif

    <div class="space-y-5">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-button type="submit" variant="primary" size="lg" class="w-full justify-center">
                {{ __('Resend verification email') }}
            </x-button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit" class="text-sm font-semibold text-ink-secondary hover:text-ink-primary transition-colors">
                {{ __('Log out') }}
            </button>
        </form>
    </div>
</x-guest-layout>

<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold font-display tracking-tight text-ink-primary">Create your account</h1>
        <p class="text-sm text-ink-secondary mt-1.5">Join Shaghalny to discover roles and manage applications.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <x-field label="Full name" for="name" :error="$errors->first('name')" required>
            <x-input id="name" variant="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Jane Doe" :error="$errors->has('name')" />
        </x-field>

        <x-field label="Email address" for="email" :error="$errors->first('email')" required>
            <x-input id="email" variant="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@example.com" :error="$errors->has('email')" />
        </x-field>

        <x-field label="Password" for="password" :error="$errors->first('password')" required hint="At least 8 characters.">
            <div class="relative" x-data="{ show: false }">
                <x-input id="password" variant="password" x-bind:type="show ? 'text' : 'password'" name="password" required autocomplete="new-password" placeholder="••••••••" class="pr-11" :error="$errors->has('password')" />
                <button type="button" @click="show = !show"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-ink-muted hover:text-ink-primary transition-colors"
                        :aria-label="show ? 'Hide password' : 'Show password'">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                </button>
            </div>
        </x-field>

        <x-field label="Confirm password" for="password_confirmation" :error="$errors->first('password_confirmation')" required>
            <x-input id="password_confirmation" variant="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" :error="$errors->has('password_confirmation')" />
        </x-field>

        <x-button type="submit" variant="primary" size="lg" class="w-full justify-center">
            {{ __('Create account') }}
        </x-button>
    </form>

    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-border"></div>
        </div>
        <div class="relative flex justify-center">
            <span class="bg-surface-subtle px-3 text-xs font-medium uppercase tracking-wide text-ink-muted">{{ __('or continue with') }}</span>
        </div>
    </div>

    <a href="{{ route('google.redirect') }}"
       class="inline-flex w-full items-center justify-center gap-3 rounded-lg border border-border bg-surface px-5 py-2.5 text-base font-semibold text-ink-primary shadow-subtle transition-all duration-150 hover:bg-surface-subtle focus:outline-none focus:ring-2 focus:ring-brand/30 focus:ring-offset-1">
        <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.27-4.74 3.27-8.1z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84A11 11 0 0 0 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.1a6.6 6.6 0 0 1 0-4.2V7.06H2.18a11 11 0 0 0 0 9.88l3.66-2.84z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84C6.71 7.31 9.14 5.38 12 5.38z"/>
        </svg>
        {{ __('Sign up with Google') }}
    </a>

    @if (Route::has('login'))
        <p class="mt-8 text-center text-sm text-ink-secondary">
            {{ __('Already registered?') }}
            <a href="{{ route('login') }}" class="font-semibold text-brand hover:text-brand-hover transition-colors">{{ __('Sign in') }}</a>
        </p>
    @endif
</x-guest-layout>

<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold font-display tracking-tight text-ink-primary">Welcome back</h1>
        <p class="text-sm text-ink-secondary mt-1.5">Sign in to continue to your Shaghalny workspace.</p>
    </div>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <x-field label="Email address" for="email" :error="$errors->first('email')" required>
            <x-input id="email" variant="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" :error="$errors->has('email')" />
        </x-field>

        <x-field label="Password" for="password" :error="$errors->first('password')" required>
            <div class="relative" x-data="{ show: false }">
                <x-input id="password" variant="password" x-bind:type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="••••••••" class="pr-11" :error="$errors->has('password')" />
                <button type="button" @click="show = !show"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-ink-muted hover:text-ink-primary transition-colors"
                        :aria-label="show ? 'Hide password' : 'Show password'">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                </button>
            </div>
        </x-field>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <x-checkbox id="remember_me" name="remember" />
                <span class="text-sm text-ink-secondary">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-semibold text-brand hover:text-brand-hover transition-colors">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <x-button type="submit" variant="primary" size="lg" class="w-full justify-center">
            {{ __('Sign in') }}
        </x-button>
    </form>

    @if (Route::has('register'))
        <p class="mt-8 text-center text-sm text-ink-secondary">
            {{ __("Don't have an account?") }}
            <a href="{{ route('register') }}" class="font-semibold text-brand hover:text-brand-hover transition-colors">{{ __('Create one') }}</a>
        </p>
    @endif
</x-guest-layout>

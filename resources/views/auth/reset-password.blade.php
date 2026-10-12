<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-bold font-display tracking-tight text-ink-primary">Choose a new password</h1>
        <p class="text-sm text-ink-secondary mt-1.5">Set a secure password for your account.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <x-field label="Email address" for="email" :error="$errors->first('email')" required>
            <x-input id="email" variant="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" :error="$errors->has('email')" />
        </x-field>

        <x-field label="New password" for="password" :error="$errors->first('password')" required hint="At least 8 characters.">
            <x-input id="password" variant="password" name="password" required autocomplete="new-password" placeholder="••••••••" :error="$errors->has('password')" />
        </x-field>

        <x-field label="Confirm password" for="password_confirmation" :error="$errors->first('password_confirmation')" required>
            <x-input id="password_confirmation" variant="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" :error="$errors->has('password_confirmation')" />
        </x-field>

        <x-button type="submit" variant="primary" size="lg" class="w-full justify-center">
            {{ __('Reset password') }}
        </x-button>
    </form>
</x-guest-layout>

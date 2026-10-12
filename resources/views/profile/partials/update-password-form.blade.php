<section>
    <header class="mb-6">
        <h2 class="text-base font-bold text-ink-primary font-display">{{ __('Update Password') }}</h2>
        <p class="mt-1 text-sm text-ink-secondary">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <x-field label="Current password" for="update_password_current_password" :error="$errors->updatePassword->first('current_password')" required>
            <x-input id="update_password_current_password" name="current_password" variant="password" autocomplete="current-password" placeholder="••••••••" :error="$errors->updatePassword->has('current_password')" />
        </x-field>

        <x-field label="New password" for="update_password_password" :error="$errors->updatePassword->first('password')" required hint="At least 8 characters.">
            <x-input id="update_password_password" name="password" variant="password" autocomplete="new-password" placeholder="••••••••" :error="$errors->updatePassword->has('password')" />
        </x-field>

        <x-field label="Confirm password" for="update_password_password_confirmation" :error="$errors->updatePassword->first('password_confirmation')" required>
            <x-input id="update_password_password_confirmation" name="password_confirmation" variant="password" autocomplete="new-password" placeholder="••••••••" :error="$errors->updatePassword->has('password_confirmation')" />
        </x-field>

        <div class="flex items-center gap-4">
            <x-button type="submit" variant="primary">{{ __('Save') }}</x-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm font-medium text-accent-success">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

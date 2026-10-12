<section>
    <header class="mb-6">
        <h2 class="text-base font-bold text-ink-primary font-display">{{ __('Profile Information') }}</h2>
        <p class="mt-1 text-sm text-ink-secondary">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <x-field label="Name" for="name" :error="$errors->first('name')" required>
            <x-input id="name" name="name" variant="text" :value="old('name', $user->name)" required autofocus autocomplete="name" :error="$errors->has('name')" />
        </x-field>

        <x-field label="Email address" for="email" :error="$errors->first('email')" required>
            <x-input id="email" name="email" variant="email" :value="old('email', $user->email)" required autocomplete="username" :error="$errors->has('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 rounded-xl bg-accent-warning-subtle border border-accent-warning/25 px-4 py-3 text-sm text-accent-warning-strong">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification" type="submit" class="font-semibold underline hover:no-underline">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <x-alert variant="success" class="mt-3">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </x-alert>
                @endif
            @endif
        </x-field>

        <div class="flex items-center gap-4">
            <x-button type="submit" variant="primary">{{ __('Save') }}</x-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm font-medium text-accent-success">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

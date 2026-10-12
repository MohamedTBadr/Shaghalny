<section class="space-y-6">
    <header>
        <h2 class="text-base font-bold text-accent-danger font-display">{{ __('Delete Account') }}</h2>
        <p class="mt-1 text-sm text-ink-secondary">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-button
        type="button"
        variant="danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-ink-primary font-display">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-ink-secondary">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-field label="Password" for="password" :error="$errors->userDeletion->first('password')" class="[&>label]:sr-only">
                    <x-input id="password" name="password" variant="password" placeholder="{{ __('Password') }}" :error="$errors->userDeletion->has('password')" />
                </x-field>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-button type="button" variant="secondary" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-button>

                <x-button type="submit" variant="danger">
                    {{ __('Delete Account') }}
                </x-button>
            </div>
        </form>
    </x-modal>
</section>

<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-lg font-extrabold text-ink-primary font-display tracking-tight">Edit User</h1>
            <p class="text-xs text-ink-muted mt-0.5">{{ $user->email }}</p>
        </div>
        <x-button variant="ghost" href="{{ route('user.show', $user->id) }}">Back</x-button>
    </x-slot>

    <div class="max-w-2xl">
        <form method="POST" action="{{ route('user.update', $user->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="card p-6 space-y-5">
                <x-field label="Name" for="name" required :error="$errors->first('name')">
                    <x-input id="name" name="name" :value="old('name', $user->name)" :error="$errors->has('name')" />
                </x-field>

                <x-field label="Email" for="email" required :error="$errors->first('email')">
                    <x-input id="email" name="email" type="email" :value="old('email', $user->email)" :error="$errors->has('email')" />
                </x-field>

                <x-field label="Role" for="role" required :error="$errors->first('role')">
                    <x-select id="role" name="role" :error="$errors->has('role')">
                        @foreach(['job_seeker' => 'Job Seeker', 'company_owner' => 'Company Owner', 'admin' => 'Admin'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('role', $user->role) === $value)>{{ $label }}</option>
                        @endforeach
                    </x-select>
                </x-field>

                <x-field label="New Password" for="password" hint="Leave blank to keep the current password." :error="$errors->first('password')">
                    <div class="relative" x-data="{ show: false }">
                        <x-input id="password" name="password" x-bind:type="show ? 'text' : 'password'"
                                 autocomplete="new-password" :error="$errors->has('password')" class="pr-11" />
                        <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-ink-muted hover:text-ink-primary"
                                aria-label="Toggle password visibility">
                            <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </x-field>
            </div>

            <div class="flex items-center justify-end gap-3">
                <x-button variant="secondary" href="{{ route('user.show', $user->id) }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Changes</x-button>
            </div>
        </form>
    </div>
</x-app-layout>

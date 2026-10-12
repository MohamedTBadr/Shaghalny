@php
    if (auth()->user()->role == 'admin') {
        $formAction = route('company.update', ['company' => $company->id, 'redirectToList' => request('redirectToList')]);
        $backUrl = request('redirectToList') === 'true' ? route('company.index') : route('company.show', $company->id);
    } elseif (auth()->user()->role == 'company_owner') {
        $formAction = route('myCompany.update');
        $backUrl = route('myCompany.show');
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-lg font-extrabold text-ink-primary font-display tracking-tight">Edit Company</h1>
            <p class="text-xs text-ink-muted mt-0.5">{{ $company->name }}</p>
        </div>
        <x-button variant="ghost" href="{{ $backUrl }}">Back</x-button>
    </x-slot>

    <div class="max-w-2xl">
        <form method="POST" action="{{ $formAction }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="card p-6 space-y-5">
                <h3 class="text-heading-card font-bold text-ink-primary">Company Information</h3>

                <x-field label="Company Name" for="name" required :error="$errors->first('name')">
                    <x-input id="name" name="name" :value="old('name', $company->name)" :error="$errors->has('name')" />
                </x-field>

                <x-field label="Address" for="address" required :error="$errors->first('address')">
                    <x-input id="address" name="address" :value="old('address', $company->address)" :error="$errors->has('address')" />
                </x-field>

                <x-field label="Industry" for="industry" required :error="$errors->first('industry')">
                    <x-input id="industry" name="industry" :value="old('industry', $company->industry)" :error="$errors->has('industry')" />
                </x-field>

                <x-field label="Website" for="website" hint="Optional." :error="$errors->first('website')">
                    <x-input id="website" name="website" type="url" :value="old('website', $company->website)" placeholder="https://example.com" :error="$errors->has('website')" />
                </x-field>
            </div>

            <div class="card p-6 space-y-5">
                <h3 class="text-heading-card font-bold text-ink-primary">Owner Account</h3>

                <x-field label="Owner Name" for="Owner_Name" required :error="$errors->first('Owner_Name')">
                    <x-input id="Owner_Name" name="Owner_Name" :value="old('Owner_Name', $company->owner->name ?? '')" :error="$errors->has('Owner_Name')" />
                </x-field>

                <x-field label="Owner Email" for="Owner_Email" hint="Owner email cannot be changed." :error="$errors->first('Owner_Email')">
                    <x-input id="Owner_Email" type="email" :value="$company->owner->email ?? ''" disabled />
                    <input type="hidden" name="Owner_Email" value="{{ $company->owner->email ?? '' }}">
                </x-field>

                <x-field label="New Owner Password" for="Owner_Password" hint="Leave blank to keep the current password." :error="$errors->first('Owner_Password')">
                    <div class="relative" x-data="{ show: false }">
                        <x-input id="Owner_Password" name="Owner_Password" x-bind:type="show ? 'text' : 'password'"
                                 autocomplete="new-password" :error="$errors->has('Owner_Password')" class="pr-11" />
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
                <x-button variant="secondary" href="{{ $backUrl }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Update Company</x-button>
            </div>
        </form>
    </div>
</x-app-layout>

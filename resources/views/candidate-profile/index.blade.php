<x-app-seeker>
    <x-slot name="header">
        <x-page-header title="Candidate Profile"
                       description="Tell employers who you are. Fields here are used to match you with relevant roles." />
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-10">
        @if(session('success'))
            <div class="mb-6">
                <x-alert variant="success" dismissible>{{ session('success') }}</x-alert>
            </div>
        @endif

        <form action="{{ route('candidate-profile.update') }}" method="POST" class="bg-surface border border-border rounded-2xl shadow-card p-6 sm:p-8 space-y-6">
            @csrf

            <div>
                <h2 class="text-heading-card font-bold text-ink-primary mb-1">Basics</h2>
                <p class="text-sm text-ink-muted">Your displayed name comes from your account settings.</p>
            </div>

            <x-field label="Professional headline" for="headline" hint="e.g. Senior Product Designer specialized in fintech" :error="$errors->first('headline')">
                <x-input id="headline" name="headline" type="text" :value="old('headline', $profile->headline)"
                         placeholder="What you do, in one line" />
            </x-field>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <x-field label="Location" for="location" :error="$errors->first('location')">
                    <x-input id="location" name="location" type="text" :value="old('location', $profile->location)" placeholder="Cairo, Remote, ..." />
                </x-field>

                <x-field label="Experience level" for="experience_level" :error="$errors->first('experience_level')">
                    <x-select id="experience_level" name="experience_level">
                        <option value="">Select level...</option>
                        @foreach(['Entry', 'Mid', 'Senior', 'Lead', 'Manager'] as $level)
                            <option value="{{ $level }}" {{ old('experience_level', $profile->experience_level) === $level ? 'selected' : '' }}>
                                {{ $level }}
                            </option>
                        @endforeach
                    </x-select>
                </x-field>
            </div>

            <x-field label="About you" for="bio" hint="2-5 sentences describing your background and goals." :error="$errors->first('bio')">
                <x-textarea id="bio" name="bio" rows="5" placeholder="I am a backend engineer...">{{ old('bio', $profile->bio) }}</x-textarea>
            </x-field>

            <div class="border-t border-border pt-6">
                <h2 class="text-heading-card font-bold text-ink-primary mb-1">Skills &amp; interests</h2>
                <p class="text-sm text-ink-muted">Comma-separated. Used for role matching and shown to employers.</p>
            </div>

            <x-field label="Skills" for="skills" hint="e.g. Laravel, Vue, PostgreSQL, Product Strategy" :error="$errors->first('skills')">
                <x-input id="skills" name="skills" type="text"
                         :value="old('skills', $profile->skills ? implode(', ', $profile->skills) : '')"
                         placeholder="Comma-separated skills" />
            </x-field>

            <x-field label="Industries you work in" for="industries" hint="e.g. SaaS, Fintech, Health Tech, E-commerce" :error="$errors->first('industries')">
                <x-input id="industries" name="industries" type="text"
                         :value="old('industries', $profile->industries ? implode(', ', $profile->industries) : '')"
                         placeholder="Comma-separated industries" />
            </x-field>

            <div class="border-t border-border pt-6 space-y-4">
                <label class="flex items-start gap-3 cursor-pointer">
                    <x-checkbox name="open_to_remote" :checked="old('open_to_remote', $profile->open_to_remote ?? true)" />
                    <span>
                        <span class="block text-sm font-medium text-ink-primary">Open to remote work</span>
                        <span class="block text-xs text-ink-muted">Show remote opportunities in recommendations and to employers.</span>
                    </span>
                </label>

                <label class="flex items-start gap-3 cursor-pointer">
                    <x-checkbox name="is_available" :checked="old('is_available', $profile->is_available ?? true)" />
                    <span>
                        <span class="block text-sm font-medium text-ink-primary">Actively looking</span>
                        <span class="block text-xs text-ink-muted">Signal to employers that you are open to being contacted.</span>
                    </span>
                </label>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-button variant="primary" type="submit" class="text-sm">Save profile</x-button>
                <a href="{{ route('dashboard') }}" class="btn-ghost text-sm">Cancel</a>
            </div>
        </form>
    </div>
</x-app-seeker>

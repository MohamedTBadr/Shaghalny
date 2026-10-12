<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('job-application.show', $app->id) }}" class="text-xs font-semibold text-ink-muted hover:text-brand transition-colors">&larr; Application</a>
            <h1 class="text-lg font-extrabold text-ink-primary font-display tracking-tight mt-0.5">Update Application Status</h1>
            <p class="text-xs text-ink-muted">{{ $app->user->name ?? 'Applicant' }} &middot; {{ $app->jobVacancy?->title ?? 'Removed vacancy' }}</p>
        </div>
    </x-slot>

    <div class="max-w-xl">
        <form action="{{ route('job-application.update', $app->id) }}" method="POST" class="bg-surface border border-border rounded-2xl shadow-card p-6 sm:p-8 space-y-6">
            @csrf
            @method('PATCH')

            <x-field label="Status" for="status" :error="$errors->first('status')">
                <x-select id="status" name="status" required>
                    @foreach(['Pending' => 'Under review', 'Accepted' => 'Accepted', 'Rejected' => 'Rejected'] as $value => $label)
                        <option value="{{ $value }}" {{ old('status', $app->status) === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </x-select>
            </x-field>

            <x-field label="Internal note (optional)" for="note" hint="Stored on the application timeline." :error="$errors->first('note')">
                <x-textarea id="note" name="note" rows="3" placeholder="e.g. Strong portfolio, schedule interview">{{ old('note') }}</x-textarea>
            </x-field>

            <div class="flex items-center justify-end gap-3 border-t border-border pt-6">
                <a href="{{ route('job-application.index') }}" class="btn-ghost text-sm">Cancel</a>
                <x-button variant="primary" type="submit" class="text-sm">Save status</x-button>
            </div>
        </form>
    </div>
</x-app-layout>

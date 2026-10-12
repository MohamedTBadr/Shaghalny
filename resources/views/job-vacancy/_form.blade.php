@php
    $vacancy = $Vacancy ?? null;
    $currentStatus = old('status', $vacancy->status ?? 'published');
@endphp

<div class="max-w-3xl space-y-6">
    @if($errors->any())
        <x-alert variant="danger">
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    <form action="{{ $action }}" method="POST" class="bg-surface border border-border rounded-2xl shadow-card p-6 sm:p-8 space-y-6">
        @csrf
        @if($method === 'PUT')
            @method('PUT')
        @endif

        <section class="space-y-5">
            <h2 class="text-heading-card font-bold text-ink-primary">Role details</h2>

            <x-field label="Job title" for="title" :error="$errors->first('title')">
                <x-input id="title" name="title" type="text" required
                         :value="old('title', $vacancy->title ?? '')"
                         placeholder="e.g. Senior Backend Engineer" />
            </x-field>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <x-field label="Category" for="Category_id" :error="$errors->first('Category_id')">
                    <x-select id="Category_id" name="Category_id" required>
                        <option value="">Select a category...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('Category_id', $vacancy->Category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </x-select>
                </x-field>

                <x-field label="Employment type" for="type" :error="$errors->first('type')">
                    <x-select id="type" name="type" required>
                        @foreach($types as $type)
                            <option value="{{ $type }}" {{ old('type', $vacancy->type ?? '') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </x-select>
                </x-field>
            </div>

            @if(auth()->user()->role === 'admin')
                <x-field label="Company" for="Company_id" :error="$errors->first('Company_id')">
                    <x-select id="Company_id" name="Company_id" required>
                        <option value="">Select a company...</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('Company_id', $vacancy->Company_id ?? '') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </x-select>
                </x-field>
            @else
                <input type="hidden" name="Company_id" value="{{ auth()->user()->company->id }}">
                <div class="flex items-center gap-2.5 text-sm text-ink-secondary bg-surface-subtle border border-border rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 text-brand shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                    Posting as <span class="font-semibold text-ink-primary">{{ auth()->user()->company->name }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <x-field label="Location" for="location" :error="$errors->first('location')">
                    <x-input id="location" name="location" type="text" required
                             :value="old('location', $vacancy->location ?? '')"
                             placeholder="e.g. Cairo, Egypt or Remote" />
                </x-field>

                <x-field label="Annual salary (USD)" for="salary" :error="$errors->first('salary')">
                    <x-input id="salary" name="salary" type="number" step="0.01" min="0" required
                             :value="old('salary', $vacancy->salary ?? '')"
                             placeholder="e.g. 45000" />
                </x-field>
            </div>

            <x-field label="Description" for="description" hint="Responsibilities, requirements, and what makes this role a great fit." :error="$errors->first('description')">
                <x-textarea id="description" name="description" rows="8" required
                            placeholder="Describe the role...">{{ old('description', $vacancy->description ?? '') }}</x-textarea>
            </x-field>
        </section>

        <section class="space-y-5 border-t border-border pt-6">
            <h2 class="text-heading-card font-bold text-ink-primary">Publishing</h2>

            <x-field label="Application deadline (optional)" for="expires_at" hint="The listing stops accepting new applications after this date." :error="$errors->first('expires_at')">
                <x-input id="expires_at" name="expires_at" type="date"
                         :value="old('expires_at', $vacancy?->expires_at?->format('Y-m-d'))" />
            </x-field>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <label class="flex items-start gap-3 p-4 rounded-xl border cursor-pointer transition-all has-[:checked]:border-brand has-[:checked]:bg-brand-subtle/40 border-border hover:border-brand/40">
                    <input type="radio" name="status" value="published" class="mt-0.5 text-brand focus:ring-brand" {{ $currentStatus === 'published' ? 'checked' : '' }}>
                    <span>
                        <span class="block text-sm font-semibold text-ink-primary">Published</span>
                        <span class="block text-xs text-ink-muted mt-0.5">Visible on the public job board immediately.</span>
                    </span>
                </label>
                <label class="flex items-start gap-3 p-4 rounded-xl border cursor-pointer transition-all has-[:checked]:border-brand has-[:checked]:bg-brand-subtle/40 border-border hover:border-brand/40">
                    <input type="radio" name="status" value="draft" class="mt-0.5 text-brand focus:ring-brand" {{ $currentStatus === 'draft' ? 'checked' : '' }}>
                    <span>
                        <span class="block text-sm font-semibold text-ink-primary">Save as draft</span>
                        <span class="block text-xs text-ink-muted mt-0.5">Only visible here until you publish it.</span>
                    </span>
                </label>
            </div>
        </section>

        <div class="flex items-center justify-end gap-3 border-t border-border pt-6">
            <a href="{{ route('job-vacancy.index') }}" class="btn-ghost text-sm">Cancel</a>
            <x-button variant="primary" type="submit" class="text-sm">{{ $submitLabel }}</x-button>
        </div>
    </form>
</div>

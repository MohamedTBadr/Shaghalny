<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-lg font-extrabold text-ink-primary font-display tracking-tight">Create Job Category</h1>
            <p class="text-xs text-ink-muted mt-0.5">Add a new category for job listings</p>
        </div>
        <x-button variant="ghost" href="{{ route('job-category.index') }}">Back</x-button>
    </x-slot>

    <div class="max-w-xl">
        <form action="{{ route('job-category.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="card p-6">
                <x-field label="Name" for="name" required :error="$errors->first('name')">
                    <x-input id="name" name="name" :value="old('name')" placeholder="e.g. Engineering" :error="$errors->has('name')" />
                </x-field>
            </div>

            <div class="flex items-center justify-end gap-3">
                <x-button variant="secondary" href="{{ route('job-category.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Create Category</x-button>
            </div>
        </form>
    </div>
</x-app-layout>

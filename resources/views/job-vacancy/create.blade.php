<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-lg font-extrabold text-ink-primary font-display tracking-tight">Create Job Vacancy</h1>
            <p class="text-xs text-ink-muted mt-0.5">Publish a new role or save it as a draft to finish later</p>
        </div>
    </x-slot>

    @include('job-vacancy._form', [
        'action' => route('job-vacancy.store'),
        'method' => 'POST',
        'submitLabel' => 'Save vacancy',
    ])
</x-app-layout>
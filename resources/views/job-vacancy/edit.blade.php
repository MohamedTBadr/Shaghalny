<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-lg font-extrabold text-ink-primary font-display tracking-tight">Edit Job Vacancy</h1>
            <p class="text-xs text-ink-muted mt-0.5">Update the details, deadline, or publishing status</p>
        </div>
        <a href="{{ route('job-vacancy.show', $Vacancy->id) }}" class="btn-secondary text-xs">View listing</a>
    </x-slot>

    @include('job-vacancy._form', [
        'action' => route('job-vacancy.update', $Vacancy->id),
        'method' => 'PUT',
        'submitLabel' => 'Save changes',
    ])
</x-app-layout>
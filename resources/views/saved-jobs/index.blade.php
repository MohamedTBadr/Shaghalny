<x-app-seeker>
    <x-slot name="header">
        <x-page-header title="Saved Jobs" description="Vacancies you bookmarked for later. Remove them anytime." />
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if(session('success'))
            <div class="mb-6">
                <x-alert variant="success" dismissible>{{ session('success') }}</x-alert>
            </div>
        @endif

        @if($savedJobs->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                @foreach($savedJobs as $saved)
                    <x-job-card :job="$saved->jobVacancy" :saved="true" />
                @endforeach
            </div>

            <div class="mt-10">
                {{ $savedJobs->links() }}
            </div>
        @else
            <x-empty-state
                icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z"/></svg>'
                title="No saved jobs yet"
                description="When you find a role you want to come back to, tap the bookmark button and it will appear here.">
                <x-slot name="action">
                    <a href="{{ route('jobs.index') }}" class="btn-primary text-sm">Explore jobs</a>
                </x-slot>
            </x-empty-state>
        @endif
    </div>
</x-app-seeker>
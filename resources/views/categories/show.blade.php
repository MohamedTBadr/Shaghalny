<x-main-layout :title="$category->name . ' Jobs — Shaghalny'">
    <div class="container-page py-10 sm:py-14">
        <x-breadcrumbs :items="[
            ['label' => 'Categories', 'href' => route('categories.index')],
            ['label' => $category->name],
        ]" />

        <div class="mt-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-heading-page font-extrabold text-ink-primary">{{ $category->name }}</h1>
                <p class="mt-1 text-body text-ink-secondary">
                    {{ $category->jobs_count }} {{ Str::plural('open position', $category->jobs_count) }} in this category
                </p>
            </div>
            <a href="{{ route('jobs.index') }}" class="btn-secondary text-sm shrink-0">
                Search all jobs
            </a>
        </div>

        @if($jobs->count() > 0)
            <div class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-6">
                @foreach($jobs as $job)
                    <x-job-card :job="$job" />
                @endforeach
            </div>

            <div class="mt-10">
                {{ $jobs->links() }}
            </div>
        @else
            <div class="mt-10">
                <x-empty-state
                    icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>'
                    title="No open positions in this category"
                    description="There are no active vacancies in this category right now. Check back soon or browse all jobs.">
                    <x-slot name="action">
                        <a href="{{ route('jobs.index') }}" class="btn-primary text-sm">Browse all jobs</a>
                    </x-slot>
                </x-empty-state>
            </div>
        @endif
    </div>
</x-main-layout>
<x-main-layout title="Hiring Companies — Shaghalny">
    <div class="container-page py-10 sm:py-14">
        <x-breadcrumbs :items="[['label' => 'Companies']]" />

        <x-page-header class="mt-6">
            <x-slot name="title">Hiring companies</x-slot>
            <x-slot name="description">
                Explore the organizations actively recruiting on Shaghalny. Companies are verified before their listings go live.
            </x-slot>
        </x-page-header>

        <form action="{{ route('companies.index') }}" method="GET" class="mt-8 max-w-2xl">
            <div class="flex items-center gap-2.5 px-3.5 py-2.5 bg-surface border border-border rounded-xl shadow-card focus-within:border-brand focus-within:ring-1 focus-within:ring-brand transition-all">
                <svg class="w-5 h-5 text-ink-muted shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by company, industry, or location..." class="w-full bg-transparent border-0 p-0 text-sm focus:ring-0">
                <button type="submit" class="btn-primary text-xs sm:text-sm shrink-0">Search</button>
            </div>
        </form>

        @if($companies->count() > 0)
            <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($companies as $company)
                    <a href="{{ route('companies.show', $company->id) }}" class="card-interactive p-6 flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center justify-between mb-5">
                                <x-company-logo :company="$company" size="md" />
                                <span class="px-2.5 py-1 rounded-full bg-brand-subtle text-brand text-xs font-semibold">
                                    {{ $company->open_jobs }} Open {{ Str::plural('Role', $company->open_jobs) }}
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-ink-primary font-display group-hover:text-brand transition-colors">
                                {{ $company->name }}
                            </h3>

                            <div class="mt-1.5 space-y-1 text-sm text-ink-secondary">
                                @if($company->industry)
                                    <p class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-ink-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        {{ $company->industry }}
                                    </p>
                                @endif
                                @if($company->address)
                                    <p class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-ink-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $company->address }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-border flex items-center justify-between text-xs">
                            @if($company->website)
                                <span class="text-ink-muted inline-flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 015.656 0M10.172 13.828a4 4 0 010-5.656M8.9 15.1l6.2-6.2m-.7 7.9l-6.2 6.2"/></svg>
                                    {{ $company->website }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-ink-muted">
                                    <svg class="w-3 h-3 text-accent-success" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    Verified employer
                                </span>
                            @endif
                            <span class="text-brand font-semibold">View profile &rarr;</span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $companies->links() }}
            </div>
        @else
            <div class="mt-10">
                <x-empty-state
                    icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>'
                    title="No companies found"
                    description="We could not find any companies matching your search. Try a different keyword.">
                </x-empty-state>
            </div>
        @endif
    </div>
</x-main-layout>

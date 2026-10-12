<x-main-layout title="Explore Job Vacancies — Shaghalny">
    <div class="container-page py-10 sm:py-14">
        <x-breadcrumbs :items="[['label' => 'Explore Jobs']]" />

        <x-page-header class="mt-6">
            <x-slot name="title">
                Explore job vacancies
            </x-slot>
            <x-slot name="description">
                Search verified roles across {{
                    \App\Models\Company::whereNull('deleted_at')->count()
                }} companies. We found <strong class="text-ink-primary font-semibold">{{ $jobs->total() }}</strong>
                {{ Str::plural('position', $jobs->total()) }} matching your criteria.
            </x-slot>
            <x-slot name="actions">
                <a href="{{ route('pages.faq') }}" class="text-sm font-medium text-brand hover:underline inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    How to apply
                </a>
            </x-slot>
        </x-page-header>

        <!-- Main search console -->
        <form action="{{ route('jobs.index') }}" method="GET" class="mt-8 bg-surface border border-border rounded-2xl shadow-card p-4 sm:p-5 flex flex-col lg:flex-row gap-3">
            <div class="flex-1 flex items-center gap-2.5 px-3.5 py-2.5 bg-surface-subtle/70 rounded-xl border border-border/60 focus-within:border-brand focus-within:bg-surface transition-all">
                <svg class="w-5 h-5 text-ink-muted shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Job title, skill, or company..." class="w-full bg-transparent border-0 p-0 text-sm text-ink-primary placeholder:text-ink-muted focus:ring-0">
            </div>

            <div class="flex-1 flex items-center gap-2.5 px-3.5 py-2.5 bg-surface-subtle/70 rounded-xl border border-border/60 focus-within:border-brand focus-within:bg-surface transition-all">
                <svg class="w-5 h-5 text-ink-muted shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <input type="text" name="location" value="{{ request('location') }}" placeholder="Location or Remote..." class="w-full bg-transparent border-0 p-0 text-sm text-ink-primary placeholder:text-ink-muted focus:ring-0">
            </div>

            <div class="hidden lg:flex items-center gap-2.5 px-3 py-2.5 bg-surface-subtle/70 rounded-xl border border-border/60 focus-within:border-brand focus-within:bg-surface transition-all">
                <select name="type" class="bg-transparent border-0 p-0 text-sm text-ink-primary focus:ring-0 cursor-pointer">
                    <option value="all">Any work type</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div class="hidden lg:flex items-center gap-2.5 px-3 py-2.5 bg-surface-subtle/70 rounded-xl border border-border/60 focus-within:border-brand focus-within:bg-surface transition-all">
                <select name="min_salary" class="bg-transparent border-0 p-0 text-sm text-ink-primary focus:ring-0 cursor-pointer">
                    <option value="">Min salary</option>
                    <option value="50000" {{ request('min_salary') == '50000' ? 'selected' : '' }}>$50k+</option>
                    <option value="80000" {{ request('min_salary') == '80000' ? 'selected' : '' }}>$80k+</option>
                    <option value="100000" {{ request('min_salary') == '100000' ? 'selected' : '' }}>$100k+</option>
                    <option value="150000" {{ request('min_salary') == '150000' ? 'selected' : '' }}>$150k+</option>
                </select>
            </div>

            <button type="submit" class="btn-primary text-sm px-6 py-2.5 rounded-xl font-semibold flex items-center justify-center gap-2">
                <span>Search</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </button>
        </form>

        <!-- Mobile filter toggle -->
        <div class="mt-6 lg:hidden">
            <button type="button"
                    @click="document.getElementById('mobile-filters')?.classList.toggle('hidden')"
                    class="w-full btn-secondary text-sm flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                Show filters
            </button>

            <div id="mobile-filters" class="hidden mt-4 bg-surface border border-border rounded-2xl shadow-card p-5">
                <x-sidebar-filters :categories="$categories" />
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
            <!-- Desktop sidebar filters -->
            <aside class="hidden lg:block sticky top-24">
                <x-sidebar-filters :categories="$categories" />
            </aside>

            <!-- Results -->
            <section class="lg:col-span-3">
                <!-- Toolbar: results + sort -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                    <p class="text-sm text-ink-secondary">
                        Showing <span class="font-semibold text-ink-primary">{{ $jobs->firstItem() ?? 0 }}-{{ $jobs->lastItem() ?? 0 }}</span>
                        of <span class="font-semibold text-ink-primary">{{ $jobs->total() }}</span> positions
                    </p>

                    <div class="flex items-center gap-2">
                        <label for="sort" class="text-xs text-ink-muted font-medium">Sort by</label>
                        <select id="sort" name="sort" form="sort-form"
                                onchange="document.getElementById('sort-form').submit()"
                                class="field-control w-auto !py-1.5 !px-3 text-sm">
                            <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>Newest first</option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest first</option>
                            <option value="salary-high" {{ request('sort') === 'salary-high' ? 'selected' : '' }}>Highest salary</option>
                            <option value="salary-low" {{ request('sort') === 'salary-low' ? 'selected' : '' }}>Lowest salary</option>
                            <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Alphabetical</option>
                        </select>
                    </div>
                </div>

                <form id="sort-form" action="{{ route('jobs.index') }}" method="GET" class="hidden">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="location" value="{{ request('location') }}">
                    <input type="hidden" name="type" value="{{ request('type') }}">
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <input type="hidden" name="min_salary" value="{{ request('min_salary') }}">
                    <input type="hidden" name="sort" id="sort-value">
                </form>

                @if($jobs->count() > 0)
                    <div class="space-y-4">
                        @foreach($jobs as $job)
                            <x-job-card :job="$job" />
                        @endforeach
                    </div>

                    <div class="mt-10">
                        {{ $jobs->links() }}
                    </div>
                @else
                    <x-empty-state
                        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>'
                        title="No positions match your search"
                        description="Try broadening your keyword, or remove a couple of filters to see more opportunities.">
                        <x-slot name="action">
                            <a href="{{ route('jobs.index') }}" class="btn-primary text-sm">
                                Clear all filters
                            </a>
                        </x-slot>
                    </x-empty-state>
                @endif
            </section>
        </div>
    </div>
</x-main-layout>

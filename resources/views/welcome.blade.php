<x-main-layout title="Shaghalny — Find Your Next Career Milestone">

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-b from-white via-surface-subtle to-surface-subtle pt-12 pb-16 sm:pt-20 sm:pb-24 border-b border-border/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto">
                <!-- Eyebrow Badge -->
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-brand-subtle text-brand border border-brand/20 text-xs font-semibold uppercase tracking-wider mb-6">
                    <span class="w-2 h-2 rounded-full bg-brand"></span>
                    Verified Opportunities &bull; Editorial Platform
                </div>

                <!-- Main Heading -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-ink-primary tracking-tight font-display leading-[1.15]">
                    Where ambitious careers meet <span class="text-brand">visionary teams</span>.
                </h1>

                <!-- Subtitle -->
                <p class="mt-5 text-base sm:text-lg text-ink-secondary leading-relaxed max-w-2xl mx-auto">
                    Discover verified roles across tech, product, and leadership. Apply with automated resume evaluation and transparent status tracking.
                </p>
            </div>

            <!-- Integrated Search Console -->
            <div class="mt-10 max-w-4xl mx-auto">
                <form action="{{ route('jobs.index') }}" method="GET" class="bg-surface p-3 sm:p-4 rounded-2xl shadow-card border border-border/80 flex flex-col md:flex-row gap-3">
                    <!-- Keyword input -->
                    <div class="flex-1 flex items-center gap-2.5 px-3 py-2 bg-surface-subtle/70 rounded-xl border border-border/60 focus-within:border-brand focus-within:bg-surface transition-all">
                        <svg class="w-5 h-5 text-ink-muted shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Job title, skill, or company..." class="w-full bg-transparent border-0 p-0 text-sm text-ink-primary placeholder:text-ink-muted focus:ring-0">
                    </div>

                    <!-- Location input -->
                    <div class="flex-1 flex items-center gap-2.5 px-3 py-2 bg-surface-subtle/70 rounded-xl border border-border/60 focus-within:border-brand focus-within:bg-surface transition-all">
                        <svg class="w-5 h-5 text-ink-muted shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <input type="text" name="location" value="{{ request('location') }}" placeholder="Location, Remote, or Country..." class="w-full bg-transparent border-0 p-0 text-sm text-ink-primary placeholder:text-ink-muted focus:ring-0">
                    </div>

                    <!-- Work Type dropdown -->
                    <div class="w-full md:w-44 px-3 py-2 bg-surface-subtle/70 rounded-xl border border-border/60 focus-within:border-brand focus-within:bg-surface transition-all">
                        <select name="type" class="w-full bg-transparent border-0 p-0 text-sm text-ink-primary focus:ring-0 cursor-pointer">
                            <option value="all">Any Work Type</option>
                            <option value="Full-Time" {{ request('type') == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                            <option value="Remote" {{ request('type') == 'Remote' ? 'selected' : '' }}>Remote</option>
                            <option value="Hybrid" {{ request('type') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                            <option value="Contract" {{ request('type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                        </select>
                    </div>

                    <!-- Search Button -->
                    <button type="submit" class="btn-primary text-sm px-6 py-3 rounded-xl font-semibold flex items-center justify-center gap-2 shadow-sm">
                        <span>Find Jobs</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </form>

                <!-- Popular Tags -->
                <div class="mt-4 flex flex-wrap items-center justify-center gap-2 text-xs text-ink-secondary">
                    <span class="text-ink-muted">Popular searches:</span>
                    <a href="{{ route('jobs.index', ['type' => 'Remote']) }}" class="px-2.5 py-1 rounded-full bg-surface border border-border hover:border-brand hover:text-brand transition-colors">Remote</a>
                    <a href="{{ route('jobs.index', ['search' => 'Engineer']) }}" class="px-2.5 py-1 rounded-full bg-surface border border-border hover:border-brand hover:text-brand transition-colors">Software Engineer</a>
                    <a href="{{ route('jobs.index', ['search' => 'Product']) }}" class="px-2.5 py-1 rounded-full bg-surface border border-border hover:border-brand hover:text-brand transition-colors">Product Manager</a>
                    <a href="{{ route('jobs.index', ['type' => 'Full-Time']) }}" class="px-2.5 py-1 rounded-full bg-surface border border-border hover:border-brand hover:text-brand transition-colors">Full-Time</a>
                </div>
            </div>

            <!-- Platform Stats Ribbon -->
            <div class="mt-14 max-w-4xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4 p-6 bg-surface/70 backdrop-blur-sm rounded-2xl border border-border/60">
                <div class="text-center">
                    <p class="text-2xl sm:text-3xl font-extrabold text-ink-primary font-display">{{ $stats['totalJobs'] }}</p>
                    <p class="text-xs text-ink-muted uppercase tracking-wider font-medium mt-0.5">Active Vacancies</p>
                </div>
                <div class="text-center border-l border-border/80">
                    <p class="text-2xl sm:text-3xl font-extrabold text-brand font-display">{{ $stats['totalCompanies'] }}</p>
                    <p class="text-xs text-ink-muted uppercase tracking-wider font-medium mt-0.5">Verified Employers</p>
                </div>
                <div class="text-center border-l border-border/80">
                    <p class="text-2xl sm:text-3xl font-extrabold text-ink-primary font-display">{{ $stats['totalApplications'] }}</p>
                    <p class="text-xs text-ink-muted uppercase tracking-wider font-medium mt-0.5">Applications Placed</p>
                </div>
                <div class="text-center border-l border-border/80">
                    <p class="text-2xl sm:text-3xl font-extrabold text-accent-success font-display">{{ $stats['totalCandidates'] }}</p>
                    <p class="text-xs text-ink-muted uppercase tracking-wider font-medium mt-0.5">Candidates Registered</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Job Categories Section -->
    <section id="categories" class="py-16 sm:py-20 bg-surface border-b border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10">
                <div>
                    <span class="text-xs font-bold text-brand uppercase tracking-wider">Explore Disciplines</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-ink-primary font-display mt-1">Browse by industry and domain</h2>
                </div>
                <p class="mt-2 md:mt-0 text-sm text-ink-secondary max-w-md">
                    Target your job search across specialized categories with active hiring quotas.
                </p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category->id) }}" class="p-4 rounded-xl border border-border hover:border-brand/40 bg-surface-subtle/50 hover:bg-surface hover:shadow-card transition-all duration-200 group flex flex-col justify-between">
                        <div>
                            <div class="w-9 h-9 rounded-lg bg-brand-subtle text-brand flex items-center justify-center font-bold text-sm mb-3 group-hover:scale-105 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            </div>
                            <h3 class="text-sm sm:text-base font-bold text-ink-primary group-hover:text-brand transition-colors">{{ $category->name }}</h3>
                        </div>
                        <p class="mt-3 text-xs text-ink-muted flex items-center justify-between">
                            <span>{{ $category->jobs_count }} active jobs</span>
                            <span class="text-brand font-semibold">&rarr;</span>
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Main Job Search Results Section -->
    <section id="jobs" class="py-16 sm:py-20 bg-surface-subtle">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header & Filter Pills -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-ink-primary font-display">Featured Opportunities</h2>
                    <p class="text-sm text-ink-secondary mt-1">
                        Showing {{ $jobs->total() }} available {{ Str::plural('position', $jobs->total()) }} on the platform
                    </p>
                </div>

                <!-- Fast Filter Switcher -->
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('jobs.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-brand text-accent-contrast shadow-sm">
                        Search All Jobs
                    </a>
                    <a href="{{ route('jobs.index', ['type' => 'Full-Time']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-surface text-ink-secondary border border-border hover:bg-surface-subtle">
                        Full-Time
                    </a>
                    <a href="{{ route('jobs.index', ['type' => 'Remote']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-surface text-ink-secondary border border-border hover:bg-surface-subtle">
                        Remote
                    </a>
                    <a href="{{ route('jobs.index', ['type' => 'Hybrid']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-surface text-ink-secondary border border-border hover:bg-surface-subtle">
                        Hybrid
                    </a>
                    <a href="{{ route('jobs.index', ['type' => 'Contract']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-surface text-ink-secondary border border-border hover:bg-surface-subtle">
                        Contract
                    </a>
                </div>
            </div>

            <!-- Job Cards Grid -->
            @if($jobs->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($jobs as $job)
                        <x-job-card :job="$job" />
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $jobs->fragment('jobs')->links() }}
                </div>
            @else
                <div class="text-center py-16 bg-surface border border-border rounded-2xl shadow-card p-8 max-w-xl mx-auto">
                    <div class="w-16 h-16 rounded-full bg-surface-muted text-ink-muted flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-ink-primary font-display">No positions match your search</h3>
                    <p class="text-sm text-ink-secondary mt-1">Try broadening your search keyword or clearing the filters.</p>
                    <a href="{{ route('jobs.index') }}" class="mt-5 inline-flex btn-primary text-xs">
                        View All Available Jobs
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Top Employers Section -->
    <section id="companies" class="py-16 sm:py-20 bg-surface border-b border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-bold text-brand uppercase tracking-wider">Hiring Partners</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-ink-primary font-display mt-1">Leading companies hiring on Shaghalny</h2>
                <p class="text-sm text-ink-secondary mt-2">
                    Join forward-thinking engineering and product teams across the MENA region and worldwide.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($companies as $company)
                    <a href="{{ route('companies.show', $company->id) }}" class="bg-surface-subtle/50 border border-border rounded-xl p-5 hover:border-brand/40 hover:bg-surface hover:shadow-card transition-all duration-200 flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 rounded-xl bg-surface border border-border flex items-center justify-center text-brand font-bold text-lg font-display shadow-subtle">
                                    {{ substr($company->name, 0, 2) }}
                                </div>
                                <span class="px-2.5 py-1 rounded-full bg-brand-subtle text-brand text-xs font-semibold">
                                    {{ $company->vacancies_count }} Open {{ Str::plural('Role', $company->vacancies_count) }}
                                </span>
                            </div>

                            <h3 class="text-base font-bold text-ink-primary font-display group-hover:text-brand transition-colors">{{ $company->name }}</h3>
                            <p class="text-xs text-ink-secondary mt-0.5 flex items-center gap-1.5">
                                <span>{{ $company->industry }}</span>
                                <span>&bull;</span>
                                <span>{{ $company->address }}</span>
                            </p>
                        </div>

                        <div class="mt-5 pt-3.5 border-t border-border flex items-center justify-between text-xs">
                            @if($company->website)
                                <span class="text-ink-muted">{{ $company->website }}</span>
                            @else
                                <span class="text-ink-muted">Verified Employer</span>
                            @endif
                            <span class="text-ink-secondary group-hover:text-brand font-semibold">
                                View Company &rarr;
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('companies.index') }}" class="btn-secondary text-sm px-5">
                    Browse all companies
                </a>
            </div>
        </div>
    </section>

    <!-- How It Works & Transparency -->
    <section id="how-it-works" class="py-16 sm:py-24 bg-surface-subtle border-b border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-xs font-bold text-brand uppercase tracking-wider">Product Architecture</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-ink-primary font-display mt-1">Designed for speed, clarity, and trust</h2>
                <p class="text-sm text-ink-secondary mt-2">
                    A balanced recruitment ecosystem built without clutter, dark patterns, or fake metrics.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="bg-surface border border-border rounded-2xl p-6 shadow-card relative">
                    <div class="w-10 h-10 rounded-xl bg-brand-subtle text-brand font-extrabold text-lg flex items-center justify-center font-display mb-4">
                        1
                    </div>
                    <h3 class="text-lg font-bold text-ink-primary font-display">Targeted Discovery</h3>
                    <p class="mt-2 text-sm text-ink-secondary leading-relaxed">
                        Filter by verified compensation, remote preferences, domain expertise, and company stage without arbitrary paywalls.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="bg-surface border border-border rounded-2xl p-6 shadow-card relative">
                    <div class="w-10 h-10 rounded-xl bg-brand-subtle text-brand font-extrabold text-lg flex items-center justify-center font-display mb-4">
                        2
                    </div>
                    <h3 class="text-lg font-bold text-ink-primary font-display">Automated AI Resume Fit</h3>
                    <p class="mt-2 text-sm text-ink-secondary leading-relaxed">
                        Submit once with your PDF resume. Our backend extracts skills, generates structured match analysis, and highlights potential fit.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="bg-surface border border-border rounded-2xl p-6 shadow-card relative">
                    <div class="w-10 h-10 rounded-xl bg-brand-subtle text-brand font-extrabold text-lg flex items-center justify-center font-display mb-4">
                        3
                    </div>
                    <h3 class="text-lg font-bold text-ink-primary font-display">Transparent Status Tracking</h3>
                    <p class="mt-2 text-sm text-ink-secondary leading-relaxed">
                        No ghosting. Follow your application journey in real-time from Pending review through Accepted or feedback notes.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Banner -->
    <section class="py-16 bg-brand-900 text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight font-display">
                Ready to take the next step in your career?
            </h2>
            <p class="mt-3 text-base text-brand-100 max-w-xl mx-auto">
                Join thousands of candidates who discover, track, and land opportunities across leading organizations.
            </p>
            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="btn bg-white text-brand hover:bg-brand-50 px-6 py-3 rounded-xl font-bold text-sm shadow-card transition-transform hover:-translate-y-0.5">
                    Create Candidate Account
                </a>
                <a href="{{ route('login') }}" class="btn border border-white/30 text-white hover:bg-white/10 px-6 py-3 rounded-xl font-semibold text-sm transition-colors">
                    Employer Workspace Sign In
                </a>
            </div>
        </div>
    </section>

</x-main-layout>


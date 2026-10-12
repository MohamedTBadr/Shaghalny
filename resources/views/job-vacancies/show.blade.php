<x-main-layout :title="$jobVacancy->title . ' at ' . ($jobVacancy->company?->name ?? 'Company') . ' | Shaghalny'">

    @php
        $user = auth()->user();
        $isSaved = $user?->savedJobs()->where('job_vacancy_id', $jobVacancy->id)->exists() ?? false;
        $hasApplied = $user ? $jobVacancy->jobApplications()->where('user_id', $user->id)->exists() : false;
        $canApply = $user?->role === 'job_seeker';
    @endphp

    <div class="bg-surface-subtle py-8 sm:py-12 border-b border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Jobs', 'href' => route('jobs.index')],
                isset($jobVacancy->JobCategory) ? ['label' => $jobVacancy->JobCategory->name, 'href' => route('categories.show', $jobVacancy->JobCategory->id)] : null,
                ['label' => $jobVacancy->title],
            ]" />

            <!-- Header Card -->
            <div class="mt-6 bg-surface border border-border rounded-2xl p-6 sm:p-8 shadow-card flex flex-col xl:flex-row xl:items-start justify-between gap-8">
                <div class="flex items-start gap-5 min-w-0">
                    <x-company-logo :company="$jobVacancy->company" size="lg" class="hidden sm:flex" />

                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                            <a href="{{ route('companies.show', $jobVacancy->company?->id) }}" class="text-sm font-semibold text-ink-secondary hover:text-brand transition-colors">
                                {{ $jobVacancy->company?->name }}
                            </a>
                            <span class="text-ink-muted">&bull;</span>
                            <x-status-badge :status="$jobVacancy->type" />
                            @if($jobVacancy->JobCategory)
                                <a href="{{ route('categories.show', $jobVacancy->JobCategory->id) }}">
                                    <x-badge variant="neutral">{{ $jobVacancy->JobCategory->name }}</x-badge>
                                </a>
                            @endif
                        </div>

                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-ink-primary font-display tracking-tight leading-tight">
                            {{ $jobVacancy->title }}
                        </h1>

                        <div class="mt-3 flex flex-wrap items-center gap-y-2 gap-x-5 text-xs sm:text-sm text-ink-secondary">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-ink-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $jobVacancy->location }}
                            </span>
                            <span class="flex items-center gap-1.5 font-bold text-ink-primary">
                                <svg class="w-4 h-4 text-accent-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                ${{ number_format($jobVacancy->salary) }}<span class="font-normal text-xs text-ink-muted">/year</span>
                            </span>
                            <span class="flex items-center gap-1.5 text-ink-muted">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Posted {{ $jobVacancy->created_at->diffForHumans() }}
                            </span>
                            <span class="flex items-center gap-1.5 text-ink-muted">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ number_format($jobVacancy->viewCount) }} views
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Primary Actions -->
                <div class="flex flex-col items-stretch gap-3 shrink-0">
                    @auth
                        @if($hasApplied)
                            <div class="inline-flex items-center justify-center gap-2 px-8 py-3 rounded-xl bg-accent-success-subtle text-accent-success-strong text-sm font-bold border border-accent-success/25">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                Application Submitted
                            </div>
                        @elseif($canApply)
                            <a href="{{ route('job-vacancies.apply', $jobVacancy->id) }}" class="btn-primary text-sm px-8 py-3 rounded-xl font-bold flex items-center justify-center gap-2">
                                <span>Apply For This Position</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        @else
                            <a href="{{ route('backoffice.dashboard') }}" class="btn-primary text-sm px-8 py-3 rounded-xl font-bold flex items-center justify-center gap-2">
                                Manage in Back-Office
                            </a>
                        @endif

                        <form action="{{ $isSaved ? route('saved-jobs.destroy', $jobVacancy->id) : route('saved-jobs.store', $jobVacancy->id) }}" method="POST">
                            @csrf
                            @if($isSaved)
                                @method('DELETE')
                            @endif
                            <button type="submit" class="w-full {{ $isSaved ? 'btn-subtle' : 'btn-secondary' }} text-xs px-4 py-2.5 rounded-xl justify-center flex items-center gap-2">
                                <svg class="w-4 h-4" fill="{{ $isSaved ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z"/>
                                </svg>
                                {{ $isSaved ? 'Saved — remove' : 'Save this job' }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary text-sm px-8 py-3 rounded-xl font-bold flex items-center justify-center gap-2">
                            <span>Sign in to apply</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        <a href="{{ route('login') }}" class="btn-secondary text-xs px-4 py-2.5 rounded-xl text-center flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z"/></svg>
                            Save for later
                        </a>
                    @endauth

                    <a href="{{ route('jobs.index') }}" class="text-center text-xs text-ink-muted hover:text-brand transition-colors">
                        &larr; Back to all vacancies
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content: Description & Sidebar -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left 2 Columns: Full Job Description -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-surface border border-border rounded-2xl p-6 sm:p-8 shadow-card">
                    <h2 class="text-xl font-bold text-ink-primary font-display mb-4">About the Role</h2>
                    <div class="text-ink-secondary text-sm leading-relaxed whitespace-pre-line max-w-none">
                        {{ $jobVacancy->description }}
                    </div>

                    <div class="mt-8 pt-6 border-t border-border">
                        <h3 class="text-base font-bold text-ink-primary font-display mb-3">Key Highlights</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                            <div class="p-3.5 bg-surface-subtle rounded-xl border border-border/80">
                                <span class="font-semibold text-ink-primary block mb-1">Work Arrangement</span>
                                <span class="text-ink-secondary">This role operates on a verified {{ $jobVacancy->type }} model located at {{ $jobVacancy->location }}.</span>
                            </div>
                            <div class="p-3.5 bg-surface-subtle rounded-xl border border-border/80">
                                <span class="font-semibold text-ink-primary block mb-1">Transparent Evaluation</span>
                                <span class="text-ink-secondary">Applications are parsed by our automated AI scoring pipeline and sent directly to hiring teams. Status updates are visible on your dashboard.</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($relatedJobs) && $relatedJobs->count() > 0)
                    <div>
                        <h3 class="text-lg font-bold text-ink-primary font-display mb-4">Similar Opportunities{{ $jobVacancy->JobCategory ? ' in ' . $jobVacancy->JobCategory->name : '' }}</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($relatedJobs as $relJob)
                                <x-job-card :job="$relJob" />
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column: Sticky Employer Overview & Summary Card -->
            <div class="space-y-6">
                <div class="bg-surface border border-border rounded-2xl p-6 shadow-card">
                    <h3 class="text-base font-bold text-ink-primary font-display mb-4 pb-3 border-b border-border">Opportunity Summary</h3>

                    <dl class="space-y-3.5 text-xs sm:text-sm">
                        <div class="flex items-center justify-between">
                            <dt class="text-ink-secondary">Compensation</dt>
                            <dd class="font-bold text-ink-primary">${{ number_format($jobVacancy->salary) }} / yr</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-ink-secondary">Employment Type</dt>
                            <dd><x-status-badge :status="$jobVacancy->type" /></dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-ink-secondary">Location</dt>
                            <dd class="font-medium text-ink-primary text-right">{{ $jobVacancy->location }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-ink-secondary">Category</dt>
                            <dd class="font-medium text-brand">{{ $jobVacancy->JobCategory?->name ?? 'General' }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-ink-secondary">Hiring company</dt>
                            <dd class="font-medium text-ink-primary">{{ $jobVacancy->company?->name }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-ink-secondary">Posted</dt>
                            <dd class="font-medium text-ink-primary">{{ $jobVacancy->created_at->format('M j, Y') }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 pt-5 border-t border-border">
                        @auth
                            @if($canApply && !$hasApplied)
                                <a href="{{ route('job-vacancies.apply', $jobVacancy->id) }}" class="btn-primary w-full py-2.5 rounded-xl text-center text-sm font-bold">
                                    Apply with Resume &rarr;
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn-primary w-full py-2.5 rounded-xl text-center text-sm font-bold">
                                Sign in to Apply &rarr;
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Employer Profile -->
                <div class="bg-surface border border-border rounded-2xl p-6 shadow-card">
                    <h3 class="text-base font-bold text-ink-primary font-display mb-4">About the Employer</h3>
                    <div class="flex items-center gap-3 mb-4">
                        <x-company-logo :company="$jobVacancy->company" size="sm" />
                        <div>
                            <a href="{{ route('companies.show', $jobVacancy->company?->id) }}" class="font-bold text-ink-primary text-sm hover:text-brand transition-colors">
                                {{ $jobVacancy->company?->name }}
                            </a>
                            <p class="text-xs text-ink-muted">{{ $jobVacancy->company?->industry }} &bull; {{ $jobVacancy->company?->address }}</p>
                        </div>
                    </div>

                    @if($jobVacancy->company?->website)
                        <a href="http://{{ $jobVacancy->company->website }}" target="_blank" rel="noopener noreferrer" class="btn-secondary w-full text-xs py-2 rounded-xl text-center">
                            Visit Company Website &nearr;
                        </a>
                    @endif

                    <a href="{{ route('companies.show', $jobVacancy->company?->id) }}" class="w-full mt-2 btn-ghost text-xs py-2 rounded-xl text-center">
                        View company profile
                    </a>
                </div>
            </div>
        </div>
    </div>

</x-main-layout>

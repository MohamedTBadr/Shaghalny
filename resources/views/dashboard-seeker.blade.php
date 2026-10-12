<x-app-seeker>
    <x-slot name="header">
        <x-page-header
            :title="'Welcome back, ' . (explode(' ', auth()->user()->name)[0] ?? '')"
            description="Here is what is happening with your job hunt today.">
            <x-slot name="actions">
                <a href="{{ route('jobs.index') }}" class="btn-primary text-sm">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                        Find jobs
                    </span>
                </a>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
        {{-- Completion nudges --}}
        @if(! $stats['hasResume'] || ! $stats['hasProfile'])
            <div>
                <x-alert variant="info" dismissible>
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <span class="text-sm">
                                <strong class="font-bold">Make your profile work for you.</strong>
                                @if(! $stats['hasResume'] && ! $stats['hasProfile'])
                                    Add a resume and complete your candidate profile to unlock AI job matching.
                                @elseif(! $stats['hasResume'])
                                    Upload a resume so you can apply to jobs in one click.
                                @else
                                    Complete your candidate profile so AI can recommend better matches.
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            @if(! $stats['hasProfile'])
                                <a href="{{ route('candidate-profile.index') }}" class="btn-secondary text-xs">Complete profile</a>
                            @endif
                            @if(! $stats['hasResume'])
                                <a href="{{ route('resumes.index') }}" class="btn-secondary text-xs">Upload resume</a>
                            @endif
                        </div>
                    </div>
                </x-alert>
            </div>
        @endif

        @if(session('success'))
            <div>
                <x-alert variant="success" dismissible>{{ session('success') }}</x-alert>
            </div>
        @endif

        {{-- Stat cards --}}
        <section>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('job-applications.index') }}" class="group bg-surface border border-border rounded-2xl shadow-card p-5 hover:border-brand/30 hover:shadow-card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-muted">Applications</p>
                        <span class="w-8 h-8 rounded-lg bg-brand-subtle text-brand flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </span>
                    </div>
                    <p class="mt-3 text-3xl font-extrabold text-ink-primary font-display tabular-nums">{{ $stats['totalApplications'] }}</p>
                    <p class="mt-1 text-xs text-ink-muted">{{ $stats['pendingApplications'] }} under review &middot; {{ $stats['acceptedApplications'] }} accepted</p>
                </a>

                <a href="{{ route('jobs.index', ['location' => 'Remote']) }}" class="group bg-surface border border-border rounded-2xl shadow-card p-5 hover:border-brand/30 hover:shadow-card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-muted">Saved jobs</p>
                        <span class="w-8 h-8 rounded-lg bg-accent-warning-subtle text-accent-warning-strong flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                        </span>
                    </div>
                    <p class="mt-3 text-3xl font-extrabold text-ink-primary font-display tabular-nums">{{ $stats['savedCount'] }}</p>
                    <p class="mt-1 text-xs text-ink-muted">Shortlisted for later</p>
                </a>

                <a href="{{ route('resumes.index') }}" class="group bg-surface border border-border rounded-2xl shadow-card p-5 hover:border-brand/30 hover:shadow-card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-muted">Resume</p>
                        <span class="w-8 h-8 rounded-lg bg-accent-danger-subtle text-accent-danger flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </span>
                    </div>
                    <p class="mt-3 text-3xl font-extrabold text-ink-primary font-display tabular-nums">{{ $stats['hasResume'] ? 'Ready' : 'Add' }}</p>
                    <p class="mt-1 text-xs text-ink-muted">PDF on file for one-click apply</p>
                </a>

                <a href="{{ route('candidate-profile.index') }}" class="group bg-surface border border-border rounded-2xl shadow-card p-5 hover:border-brand/30 hover:shadow-card-hover transition-all">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-muted">Profile</p>
                        <span class="w-8 h-8 rounded-lg bg-accent-info-subtle text-accent-info-strong flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </span>
                    </div>
                    <p class="mt-3 text-3xl font-extrabold text-ink-primary font-display tabular-nums">{{ $stats['hasProfile'] ? 'Done' : 'Set up' }}</p>
                    <p class="mt-1 text-xs text-ink-muted">Skills &amp; preferences for matching</p>
                </a>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            {{-- Recent applications --}}
            <section class="lg:col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-heading-card font-bold text-ink-primary">Recent applications</h2>
                    @if($stats['totalApplications'] > 0)
                        <a href="{{ route('job-applications.index') }}" class="text-xs font-semibold text-brand hover:text-brand-hover transition-colors inline-flex items-center gap-1">
                            View all
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @endif
                </div>

                <div class="bg-surface border border-border rounded-2xl shadow-card overflow-hidden">
                    @forelse($recentApplications as $app)
                        @php
                            $statusVariant = match($app->status) {
                                'Accepted' => 'success',
                                'Rejected' => 'danger',
                                default => 'warning',
                            };
                        @endphp
                        <a href="{{ route('job-applications.show', $app->id) }}"
                           class="flex items-center justify-between gap-4 px-5 py-4 border-b border-border/60 last:border-b-0 hover:bg-surface-subtle/50 transition-colors">
                            <div class="min-w-0">
                                <p class="font-semibold text-sm text-ink-primary truncate">{{ $app->jobVacancy?->title ?? 'Removed vacancy' }}</p>
                                <p class="text-xs text-ink-muted mt-0.5">{{ $app->jobVacancy?->company?->name ?? '—' }} &middot; {{ $app->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                @if(is_numeric($app->AI_Generated_score))
                                    <span class="text-[11px] font-bold text-ink-secondary tabular-nums">AI {{ (int) $app->AI_Generated_score }}</span>
                                @endif
                                <x-badge :variant="$statusVariant">{{ $app->status === 'Pending' ? 'Under review' : $app->status }}</x-badge>
                            </div>
                        </a>
                    @empty
                        <div class="px-5 py-12 text-center">
                            <div class="w-12 h-12 rounded-xl bg-surface-subtle flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-ink-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/></svg>
                            </div>
                            <p class="text-sm font-semibold text-ink-primary">No applications yet</p>
                            <p class="text-xs text-ink-muted mt-1 mb-4">Find a role that fits and apply in a few clicks.</p>
                            <a href="{{ route('jobs.index') }}" class="btn-primary text-xs">Browse jobs</a>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- Recommended --}}
            <section>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-heading-card font-bold text-ink-primary">Recommended for you</h2>
                </div>

                <div class="space-y-3">
                    @forelse($recommendedJobs as $job)
                        <a href="{{ route('job-vacancies.show', $job->id) }}"
                           class="group block bg-surface border border-border rounded-2xl shadow-subtle p-4 hover:border-brand/30 hover:shadow-card-hover transition-all">
                            <div class="flex items-center gap-2 mb-1.5">
                                <x-company-logo :company="$job->company" size="xs" />
                                <span class="text-[11px] text-ink-muted font-medium truncate">{{ $job->company?->name }}</span>
                            </div>
                            <p class="font-bold text-sm text-ink-primary group-hover:text-brand transition-colors leading-snug">{{ $job->title }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-[11px] text-ink-secondary truncate">{{ $job->location }}</span>
                                @if($job->salary)
                                    <span class="text-[11px] font-semibold text-ink-primary shrink-0">${{ number_format($job->salary) }}/yr</span>
                                @endif
                            </div>
                        </a>
                    @empty
                        <x-empty-state
                            icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>'
                            title="No recommendations yet"
                            description="Start applying to jobs to get personalized recommendations." />
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-seeker>

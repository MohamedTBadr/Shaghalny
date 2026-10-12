<x-app-seeker>
    <x-slot name="header">
        <x-page-header>
            <x-slot name="title">{{ $application->jobVacancy?->title ?? 'Application' }}</x-slot>
            <x-slot name="description">
                Applied to {{ $application->jobVacancy?->company?->name ?? 'a company' }} on {{ $application->created_at->format('M d, Y') }}
            </x-slot>
            <x-slot name="actions">
                <a href="{{ route('job-applications.index') }}" class="btn-secondary text-xs">
                    &larr; All applications
                </a>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Main column -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Status -->
                <div class="bg-surface border border-border rounded-2xl shadow-card p-6">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-ink-muted">Current status</p>
                            <div class="mt-2">
                                <x-status-badge :status="$application->status" size="md" />
                            </div>
                        </div>

                        @php
                            $score = $application->AI_Generated_score;
                            $isScore = is_numeric($score);
                        @endphp
                        @if($isScore)
                            <div class="text-right">
                                <p class="text-xs font-semibold uppercase tracking-wider text-ink-muted">AI fit score</p>
                                <p class="mt-1 text-3xl font-extrabold text-ink-primary font-display tabular-nums">{{ (int) $score }}<span class="text-base text-ink-muted font-semibold">/100</span></p>
                            </div>
                        @endif
                    </div>

                    @if($score === 0 && !$application->AI_Generated_feedback)
                        <div class="mt-4">
                            <x-alert variant="info">
                                AI scoring was not available when this application was submitted. The employer can still review your application normally.
                            </x-alert>
                        </div>
                    @endif
                </div>

                <!-- AI Feedback -->
                @if($application->AI_Generated_feedback)
                    <div class="bg-surface border border-border rounded-2xl shadow-card p-6">
                        <h2 class="text-heading-card font-bold text-ink-primary mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                            AI evaluation
                        </h2>
                        <p class="text-sm text-ink-secondary leading-relaxed bg-surface-subtle border border-border/60 rounded-xl p-4">
                            {{ $application->AI_Generated_feedback }}
                        </p>
                        <p class="text-[11px] text-ink-muted mt-3">
                            Advisory only. Final hiring decisions are always made by the employer.
                        </p>
                    </div>
                @endif

                <!-- Timeline -->
                <div class="bg-surface border border-border rounded-2xl shadow-card p-6">
                    <h2 class="text-heading-card font-bold text-ink-primary mb-5">Application history</h2>

                    @if($application->statusHistories->count() > 0)
                        <x-timeline :items="$application->statusHistories->map(fn($h) => [
                            'title' => match ($h->status) {
                                'Accepted' => 'Application accepted',
                                'Rejected' => 'Application not selected',
                                default => 'Application received',
                            },
                            'description' => (fn($status) => match ($status) {
                                'Accepted' => 'The employer accepted your application. Next steps are typically communicated by email.',
                                'Rejected' => 'The employer has closed your application. Keep trying — new roles are posted every week.',
                                default => 'Your application is with the hiring team for review.',
                            })($h->status) . ($h->note ? ' Note: ' . $h->note : ''),
                            'timestamp' => $h->created_at->format('M d, Y · g:i A'),
                            'tone' => match ($h->status) {
                                'Accepted' => 'success',
                                'Rejected' => 'danger',
                                default => 'brand',
                            },
                        ])->all()" />
                    @else
                        <p class="text-sm text-ink-muted">No status changes recorded for this application yet.</p>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="space-y-6">
                <!-- Vacancy card -->
                @if($application->jobVacancy)
                    <div class="bg-surface border border-border rounded-2xl shadow-card p-6">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-ink-primary mb-4">Vacancy</h3>
                        <a href="{{ route('job-vacancies.show', $application->jobVacancy->id) }}" class="block group">
                            <p class="font-bold text-ink-primary text-sm group-hover:text-brand transition-colors">{{ $application->jobVacancy->title }}</p>
                        </a>
                        <div class="mt-2 space-y-1.5 text-xs text-ink-secondary">
                            <p><x-company-logo :company="$application->jobVacancy->company" size="xs" class="inline-flex mr-2" />{{ $application->jobVacancy->company?->name }}</p>
                            <p>{{ $application->jobVacancy->location }}</p>
                            <p class="font-semibold text-ink-primary">${{ number_format($application->jobVacancy->salary) }}/yr</p>
                        </div>
                        <a href="{{ route('job-vacancies.show', $application->jobVacancy->id) }}" class="mt-4 btn-secondary w-full text-xs py-2 rounded-lg text-center">
                            View vacancy
                        </a>
                    </div>
                @endif

                <!-- Resume -->
                @if($application->resume)
                    <div class="bg-surface border border-border rounded-2xl shadow-card p-6">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-ink-primary mb-4">Submitted resume</h3>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-accent-danger-subtle text-accent-danger flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-xs text-ink-primary truncate">{{ $application->resume->file_name }}</p>
                                <p class="text-[11px] text-ink-muted mt-0.5">Uploaded {{ $application->resume->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="mt-4 flex flex-col gap-2">
                            <a href="{{ route('resumes.download', $application->resume->id) }}" class="btn-secondary w-full text-xs py-2 rounded-lg text-center">
                                Download a copy
                            </a>
                            @if($application->resume->skills)
                                <p class="text-[11px] text-ink-muted">Skills: {{ Str::limit($application->resume->skills, 140) }}</p>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Similar -->
                @if($relatedJobs->count() > 0)
                    <div class="bg-surface border border-border rounded-2xl shadow-card p-6">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-ink-primary mb-4">Roles you might also like</h3>
                        <ul class="space-y-3">
                            @foreach($relatedJobs as $job)
                                <li>
                                    <a href="{{ route('job-vacancies.show', $job->id) }}" class="block group">
                                        <p class="font-semibold text-xs text-ink-primary group-hover:text-brand transition-colors">{{ $job->title }}</p>
                                        <p class="text-[11px] text-ink-muted mt-0.5">{{ $job->company?->name }} &bull; {{ $job->location }}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </aside>
        </div>
    </div>
</x-app-seeker>

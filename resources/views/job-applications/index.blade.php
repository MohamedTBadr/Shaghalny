<x-app-seeker>
    <x-slot name="header">
        <x-page-header title="My Applications" description="Track the status and AI feedback for every role you have applied to." />
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-10">
        @if(session('success'))
            <div class="mb-6">
                <x-alert variant="success" dismissible>{{ session('success') }}</x-alert>
            </div>
        @endif

        <div class="space-y-4">
            @forelse($jobApplications as $app)
                @php
                    $status = $app->status;
                    $statusVariant = match($status) {
                        'Accepted'  => 'success',
                        'Rejected'  => 'danger',
                        'Pending'   => 'warning',
                        default     => 'neutral',
                    };
                    $score = $app->AI_Generated_score ?? null;
                    $scoreColor = match(true) {
                        $score === null || $score === '' => null,
                        $score >= 80 => 'text-accent-success-strong bg-accent-success-subtle border-accent-success/25',
                        $score >= 50 => 'text-accent-warning-strong bg-accent-warning-subtle border-accent-warning/25',
                        default      => 'text-accent-danger-strong bg-accent-danger-subtle border-accent-danger/25',
                    };
                @endphp

                <a href="{{ route('job-applications.show', $app->id) }}"
                   class="group block bg-surface border border-border rounded-2xl overflow-hidden hover:border-brand/30 hover:shadow-card-hover transition-all duration-200">
                    {{-- Main row --}}
                    <div class="px-5 py-4 flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <x-company-logo :company="$app->jobVacancy?->company" size="xs" />
                                <span class="text-xs text-ink-muted font-medium truncate">{{ $app->jobVacancy?->company?->name ?? '—' }}</span>
                            </div>

                            <h2 class="text-base font-bold text-ink-primary group-hover:text-brand transition-colors truncate">
                                {{ $app->jobVacancy?->title ?? 'Removed vacancy' }}
                            </h2>

                            <div class="flex items-center gap-3 mt-1.5 flex-wrap">
                                <span class="text-xs text-ink-muted">
                                    Applied {{ $app->created_at->format('M d, Y') }}
                                    <span class="text-ink-light">/</span>
                                    {{ $app->created_at->diffForHumans() }}
                                </span>
                                @if($app->jobVacancy?->location)
                                    <span class="text-xs text-ink-secondary">{{ $app->jobVacancy->location }}</span>
                                @endif
                                @if($app->jobVacancy?->type)
                                    <x-badge variant="neutral">{{ $app->jobVacancy->type }}</x-badge>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col items-end gap-2 shrink-0">
                            <x-status-badge :status="$status" />
                            @if($score !== null && $score !== '')
                                <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg border text-xs font-bold {{ $scoreColor }}">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                    AI Score: {{ is_numeric($score) ? $score : 0 }}
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Resume row --}}
                    @if($app->resume)
                        <div class="px-5 py-2.5 bg-surface-subtle border-t border-border/50 flex items-center justify-between">
                            <span class="flex items-center gap-2 text-xs text-ink-muted min-w-0">
                                <svg class="w-3.5 h-3.5 shrink-0 text-ink-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span class="truncate">{{ $app->resume->file_name }}</span>
                            </span>
                            <span class="text-xs font-semibold text-brand group-hover:translate-x-0.5 transition-transform inline-flex items-center gap-1">
                                View details
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    @endif
                </a>
            @empty
                <x-empty-state
                    icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>'
                    title="No applications yet"
                    description="Start applying to jobs and track everything here — resume, AI score, and status updates.">
                    <x-slot name="action">
                        <a href="{{ route('jobs.index') }}" class="btn-primary text-sm">Browse jobs</a>
                    </x-slot>
                </x-empty-state>
            @endforelse
        </div>

        @if($jobApplications->hasPages())
            <div class="mt-8">
                {{ $jobApplications->links() }}
            </div>
        @endif
    </div>
</x-app-seeker>

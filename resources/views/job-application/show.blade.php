<x-app-layout>
    <x-slot name="header">
        <div class="min-w-0">
            <a href="{{ route('job-application.index') }}" class="text-xs font-semibold text-ink-muted hover:text-brand transition-colors">&larr; Applications</a>
            <h1 class="text-lg font-extrabold text-ink-primary font-display tracking-tight truncate mt-0.5">{{ $app->user->name ?? 'Applicant' }}</h1>
            <p class="text-xs text-ink-muted">{{ $app->jobVacancy?->title ?? 'Removed vacancy' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <x-status-badge :status="$app->status" size="md" />
        </div>
    </x-slot>

    <div class="max-w-7xl space-y-8">
        @if(session('success'))
            <x-alert variant="success" dismissible>{{ session('success') }}</x-alert>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Main -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Decision -->
                <div class="bg-surface border border-border rounded-2xl shadow-card p-6">
                    <h2 class="text-heading-card font-bold text-ink-primary mb-4">Hiring decision</h2>

                    <div class="flex flex-wrap gap-2 mb-5">
                        <form action="{{ route('job-application.update', $app->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Accepted">
                            <x-button variant="success" type="submit" class="text-sm" :disabled="$app->status === 'Accepted'">
                                Accept candidate
                            </x-button>
                        </form>
                        <form action="{{ route('job-application.update', $app->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="Rejected">
                            <x-button variant="danger" type="submit" class="text-sm" :disabled="$app->status === 'Rejected'">
                                Reject
                            </x-button>
                        </form>
                        @if($app->status !== 'Pending')
                            <form action="{{ route('job-application.update', $app->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="Pending">
                                <x-button variant="secondary" type="submit" class="text-sm">Move back to review</x-button>
                            </form>
                        @endif
                    </div>

                    <form action="{{ route('job-application.update', $app->id) }}" method="POST" class="space-y-4 border-t border-border pt-5">
                        @csrf
                        @method('PATCH')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <x-field label="Update status" for="status">
                                <x-select id="status" name="status">
                                    @foreach(['Pending' => 'Under review', 'Accepted' => 'Accepted', 'Rejected' => 'Rejected'] as $value => $label)
                                        <option value="{{ $value }}" {{ $app->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </x-select>
                            </x-field>
                            <x-field label="Internal note (optional)" for="note" hint="Added to the application timeline.">
                                <x-input id="note" name="note" type="text" placeholder="e.g. Moving to interview stage" />
                            </x-field>
                        </div>
                        <x-button variant="primary" type="submit" class="text-sm">Save update</x-button>
                    </form>
                </div>

                <!-- Application timeline -->
                <div class="bg-surface border border-border rounded-2xl shadow-card p-6">
                    <h2 class="text-heading-card font-bold text-ink-primary mb-5">Application timeline</h2>
                    @if($app->statusHistories->count() > 0)
                        <x-timeline :items="$app->statusHistories->map(fn($h) => [
                            'title' => match ($h->status) {
                                'Accepted' => 'Accepted',
                                'Rejected' => 'Rejected',
                                default => 'Under review',
                            },
                            'description' => ($h->note ?: 'Status updated by the hiring team.'),
                            'timestamp' => $h->created_at->format('M d, Y · g:i A'),
                            'tone' => match ($h->status) {
                                'Accepted' => 'success',
                                'Rejected' => 'danger',
                                default => 'brand',
                            },
                        ])->all()" />
                    @else
                        <p class="text-sm text-ink-muted">No status changes recorded yet.</p>
                    @endif
                </div>

                <!-- Resume parsed content -->
                @if($app->resume)
                    <div class="bg-surface border border-border rounded-2xl shadow-card p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-heading-card font-bold text-ink-primary">Resume</h2>
                            <a href="{{ route('resumes.download', $app->resume->id) }}" class="btn-secondary text-xs">Download PDF</a>
                        </div>
                        <p class="text-xs text-ink-muted mb-4">{{ $app->resume->file_name }}</p>
                        <dl class="space-y-4 text-sm">
                            @foreach(['summary' => 'Summary', 'skills' => 'Skills', 'experience' => 'Experience', 'education' => 'Education'] as $field => $label)
                                <div>
                                    <dt class="text-xs font-bold uppercase tracking-wider text-ink-muted mb-1">{{ $label }}</dt>
                                    <dd class="text-ink-secondary whitespace-pre-line">{{ $app->resume->{$field} ?: '—' }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <aside class="space-y-6">
                <div class="bg-surface border border-border rounded-2xl shadow-card p-6">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-ink-muted mb-4">AI evaluation</h3>
                    @if(is_numeric($app->AI_Generated_score))
                        <p class="text-4xl font-extrabold text-ink-primary font-display tabular-nums">{{ (int) $app->AI_Generated_score }}<span class="text-base text-ink-muted font-semibold">/100</span></p>
                    @else
                        <p class="text-sm text-ink-muted">No AI score available.</p>
                    @endif
                    @if($app->AI_Generated_feedback)
                        <p class="mt-4 text-sm text-ink-secondary leading-relaxed bg-surface-subtle border border-border/60 rounded-xl p-4">{{ $app->AI_Generated_feedback }}</p>
                        <p class="text-[11px] text-ink-muted mt-3">Advisory signal only — always review the resume directly.</p>
                    @endif
                </div>

                <div class="bg-surface border border-border rounded-2xl shadow-card p-6 space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-ink-muted">Applicant</h3>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-brand-subtle text-brand flex items-center justify-center font-bold border border-brand/20">
                            {{ substr($app->user->name ?? '?', 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-sm text-ink-primary truncate">{{ $app->user->name ?? '—' }}</p>
                            <p class="text-xs text-ink-muted truncate">{{ $app->user->email ?? '' }}</p>
                        </div>
                    </div>
                    <dl class="space-y-2 text-sm border-t border-border pt-4">
                        <div class="flex items-center justify-between">
                            <dt class="text-ink-muted">Applied</dt>
                            <dd class="font-medium text-ink-primary">{{ $app->created_at->format('M d, Y') }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-ink-muted">Vacancy</dt>
                            <dd class="font-medium text-ink-primary truncate max-w-[10rem]">{{ $app->jobVacancy?->title ?? '—' }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-ink-muted">Company</dt>
                            <dd class="font-medium text-ink-primary">{{ $app->jobVacancy?->company?->name ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>

                <form action="{{ route('job-application.destroy', $app->id) }}" method="POST"
                      onsubmit="return confirm('Archive this application? You can restore it later.')">
                    @csrf
                    @method('DELETE')
                    <x-button variant="danger-outline" type="submit" class="w-full text-sm">Archive application</x-button>
                </form>
            </aside>
        </div>
    </div>
</x-app-layout>

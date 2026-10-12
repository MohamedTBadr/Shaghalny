<x-app-layout>
    <x-slot name="header">
        <div class="min-w-0">
            <div class="flex items-center gap-2">
                <a href="{{ route('job-vacancy.index') }}" class="text-xs font-semibold text-ink-muted hover:text-brand transition-colors">&larr; Vacancies</a>
            </div>
            <h1 class="text-lg font-extrabold text-ink-primary font-display tracking-tight truncate mt-0.5">{{ $Vacancy->title }}</h1>
        </div>
        <div class="flex items-center gap-2">
            @php
                $statusBadge = match(true) {
                    $Vacancy->status === 'published' && $Vacancy->isExpired() => ['danger', 'Expired'],
                    $Vacancy->status === 'published' => ['success', 'Published'],
                    default => ['warning', 'Draft'],
                };
            @endphp
            <x-badge :variant="$statusBadge[0]">{{ $statusBadge[1] }}</x-badge>
            <x-button variant="primary" size="sm" href="{{ route('job-vacancy.edit', $Vacancy->id) }}">Edit</x-button>
            <form action="{{ route('job-vacancy.destroy', $Vacancy->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <x-button variant="danger-outline" size="sm" type="submit">Archive</x-button>
            </form>
        </div>
    </x-slot>

    <div class="max-w-7xl space-y-8">
        @if(session('success'))
            <x-alert variant="success" dismissible>{{ session('success') }}</x-alert>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Details -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-surface border border-border rounded-2xl shadow-card p-6">
                    <h2 class="text-heading-card font-bold text-ink-primary mb-4">Role overview</h2>
                    <p class="text-sm text-ink-secondary leading-relaxed whitespace-pre-line">{{ $Vacancy->description }}</p>
                </div>

                <!-- Applicants -->
                <div class="bg-surface border border-border rounded-2xl shadow-card overflow-hidden">
                    <div class="px-6 py-4 border-b border-border flex items-center justify-between">
                        <h2 class="text-heading-card font-bold text-ink-primary">Applicants</h2>
                        <span class="text-xs font-semibold text-ink-muted">{{ $Vacancy->jobApplications->count() }} total</span>
                    </div>

                    @if($Vacancy->jobApplications->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-border text-sm">
                                <thead>
                                    <tr class="bg-surface-subtle/70">
                                        <th class="text-left px-6 py-3 text-xs font-bold text-ink-muted uppercase tracking-wider">Applicant</th>
                                        <th class="text-left px-6 py-3 text-xs font-bold text-ink-muted uppercase tracking-wider">Status</th>
                                        <th class="text-right px-6 py-3 text-xs font-bold text-ink-muted uppercase tracking-wider">AI score</th>
                                        <th class="px-6 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border">
                                    @foreach($Vacancy->jobApplications as $app)
                                        <tr class="hover:bg-surface-subtle transition-colors">
                                            <td class="px-6 py-4">
                                                <p class="font-semibold text-ink-primary">{{ $app->user->name ?? '—' }}</p>
                                                <p class="text-xs text-ink-muted mt-0.5">{{ $app->created_at->diffForHumans() }}</p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <x-status-badge :status="$app->status" />
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                @if(is_numeric($app->AI_Generated_score))
                                                    <span class="text-sm font-bold text-ink-primary tabular-nums">{{ (int) $app->AI_Generated_score }}</span>
                                                @else
                                                    <span class="text-xs text-ink-muted">—</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('job-application.show', $app->id) }}" class="text-xs font-semibold text-brand hover:text-brand-hover transition-colors">Review</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="px-6 py-12 text-center">
                            <p class="text-sm font-semibold text-ink-primary">No applications yet</p>
                            <p class="text-xs text-ink-muted mt-1">Applications will appear here as candidates apply.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="space-y-6">
                <div class="bg-surface border border-border rounded-2xl shadow-card p-6 space-y-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-ink-muted">Summary</h3>
                    <dl class="space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <dt class="text-ink-muted">Company</dt>
                            <dd class="font-semibold text-ink-primary">{{ $Vacancy->company->name ?? '—' }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-ink-muted">Category</dt>
                            <dd class="font-semibold text-ink-primary">{{ $Vacancy->JobCategory->name ?? '—' }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-ink-muted">Type</dt>
                            <dd><x-badge variant="neutral">{{ $Vacancy->type }}</x-badge></dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-ink-muted">Location</dt>
                            <dd class="font-semibold text-ink-primary">{{ $Vacancy->location }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-ink-muted">Salary</dt>
                            <dd class="font-semibold text-ink-primary">${{ number_format($Vacancy->salary) }}/yr</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-ink-muted">Views</dt>
                            <dd class="font-semibold text-ink-primary tabular-nums">{{ $Vacancy->viewCount }}</dd>
                        </div>
                        @if($Vacancy->expires_at)
                            <div class="flex items-center justify-between">
                                <dt class="text-ink-muted">Deadline</dt>
                                <dd class="font-semibold text-ink-primary">{{ $Vacancy->expires_at->format('M d, Y') }}</dd>
                            </div>
                        @endif
                    </dl>

                    <div class="border-t border-border pt-4">
                        <a href="{{ route('job-vacancies.show', $Vacancy->id) }}" target="_blank" class="btn-secondary w-full text-xs py-2 rounded-lg text-center">
                            Preview public listing
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-app-layout>

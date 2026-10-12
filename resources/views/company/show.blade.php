<x-app-layout>
    <x-slot name="header">
        <div class="min-w-0">
            <div class="flex items-center gap-2">
                <h1 class="text-lg font-extrabold text-ink-primary font-display tracking-tight truncate">{{ $company->name }}</h1>
                <x-badge variant="neutral">{{ $company->industry ?? '—' }}</x-badge>
            </div>
            <p class="text-xs text-ink-muted mt-0.5">{{ $company->address }}</p>
        </div>
        <div class="flex items-center gap-2">
            @if(auth()->user()->role === 'admin')
                <x-button variant="ghost" href="{{ route('company.index') }}">Back</x-button>
                <x-button variant="primary" href="{{ route('company.edit', ['company' => $company->id, 'redirectToList' => 'false']) }}">Edit</x-button>
                <form action="{{ route('company.destroy', $company->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-button variant="danger" type="submit">Archive</x-button>
                </form>
            @else
                <x-button variant="primary" href="{{ route('myCompany.edit') }}">Edit</x-button>
            @endif
        </div>
    </x-slot>

    <div class="max-w-7xl space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 card p-6">
                <h3 class="text-heading-card font-bold text-ink-primary mb-4">Company Details</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-muted">Industry</dt>
                        <dd class="mt-1 text-sm text-ink-primary">{{ $company->industry ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-muted">Website</dt>
                        <dd class="mt-1 text-sm">
                            @if($company->website)
                                <a href="{{ Str::startsWith($company->website, ['http://', 'https://']) ? $company->website : 'http://'.$company->website }}"
                                   target="_blank" rel="noopener" class="text-brand hover:text-brand-hover transition-colors break-all">
                                    {{ $company->website }}
                                </a>
                            @else
                                <span class="text-ink-muted">—</span>
                            @endif
                        </dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-muted">Address</dt>
                        <dd class="mt-1 text-sm text-ink-primary">{{ $company->address ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="card p-6">
                <h3 class="text-heading-card font-bold text-ink-primary mb-4">Owner</h3>
                @if($company->owner)
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-brand-subtle text-brand font-bold flex items-center justify-center text-sm">
                            {{ Str::of($company->owner->name)->substr(0, 1)->upper() }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-ink-primary truncate">{{ $company->owner->name }}</p>
                            <p class="text-xs text-ink-muted truncate">{{ $company->owner->email }}</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-border grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-ink-muted">Vacancies</p>
                            <p class="text-lg font-bold text-ink-primary">{{ $company->job_vacancies_count }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-ink-muted">Applications</p>
                            <p class="text-lg font-bold text-ink-primary">{{ $applications->count() }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-ink-muted">No owner assigned.</p>
                @endif
            </div>
        </div>

        <div>
            <h3 class="text-heading-card font-bold text-ink-primary mb-3">Job Vacancies</h3>
            @if($company->jobVacancies->count() > 0)
                <x-table :headers="['Title', 'Location', 'Type', 'Status']">
                    @foreach($company->jobVacancies as $job)
                        @php
                            $statusBadge = match(true) {
                                $job->status === 'published' && $job->isExpired() => ['danger', 'Expired'],
                                $job->status === 'published' => ['success', 'Published'],
                                default => ['warning', 'Draft'],
                            };
                        @endphp
                        <tr class="hover:bg-surface-subtle transition-colors">
                            <td class="px-6 py-4">
                                <a href="{{ route('job-vacancy.show', $job->id) }}" class="font-semibold text-ink-primary hover:text-brand transition-colors">
                                    {{ $job->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-ink-secondary">{{ $job->location ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge variant="neutral">{{ $job->type }}</x-badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-badge :variant="$statusBadge[0]">{{ $statusBadge[1] }}</x-badge>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <x-button variant="secondary" size="sm" href="{{ route('job-vacancy.show', $job->id) }}">View</x-button>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            @else
                <x-empty-state
                    icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>'
                    title="No vacancies yet"
                    description="This company has not created any job vacancies." />
            @endif
        </div>

        <div>
            <h3 class="text-heading-card font-bold text-ink-primary mb-3">Recent Applications</h3>
            @if($applications->count() > 0)
                <x-table :headers="['Applicant', 'Job', 'Applied', 'Status']">
                    @foreach($applications as $app)
                        <tr class="hover:bg-surface-subtle transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-semibold text-ink-primary">{{ $app->user->name ?? '—' }}</span>
                                <p class="text-xs text-ink-muted mt-0.5">{{ $app->user->email ?? '' }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-ink-secondary">{{ $app->jobVacancy->title ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-ink-muted text-xs">{{ $app->created_at?->diffForHumans() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-status-badge :status="$app->status" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <x-button variant="secondary" size="sm" href="{{ route('job-application.show', $app->id) }}">View</x-button>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            @else
                <x-empty-state
                    icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>'
                    title="No applications yet"
                    description="Applications to this company's vacancies will show up here." />
            @endif
        </div>
    </div>
</x-app-layout>

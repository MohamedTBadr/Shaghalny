<x-app-layout>
    <x-slot name="header">
        <div class="min-w-0">
            <div class="flex items-center gap-2">
                <h1 class="text-lg font-extrabold text-ink-primary font-display tracking-tight truncate">{{ $user->name }}</h1>
                <x-badge :variant="$user->role === 'admin' ? 'brand' : ($user->role === 'company_owner' ? 'info' : 'success')">
                    {{ $user->role ?? 'N/A' }}
                </x-badge>
                @if($user->trashed())
                    <x-badge variant="warning">Archived</x-badge>
                @endif
            </div>
            <p class="text-xs text-ink-muted mt-0.5">{{ $user->email }}</p>
        </div>
        <div class="flex items-center gap-2">
            <x-button variant="ghost" href="{{ route('user.index') }}">Back</x-button>
            @if($user->role !== 'admin' || $user->id === auth()->id())
                <x-button variant="primary" href="{{ route('user.edit', $user->id) }}">Edit</x-button>
            @endif
            @if($user->trashed())
                <form action="{{ route('user.restore', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <x-button variant="success" type="submit">Restore</x-button>
                </form>
            @elseif($user->role !== 'admin' && $user->id !== auth()->id())
                <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <x-button variant="danger" type="submit">Archive</x-button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="max-w-7xl space-y-6">
        @if(session('success'))
            <x-alert variant="success" dismissible>{{ session('success') }}</x-alert>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 card p-6">
                <h3 class="text-heading-card font-bold text-ink-primary mb-4">Account Details</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-muted">Email</dt>
                        <dd class="mt-1 text-sm text-ink-primary break-all">{{ $user->email ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-muted">Role</dt>
                        <dd class="mt-1 text-sm text-ink-primary capitalize">{{ str_replace('_', ' ', $user->role ?? '—') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-muted">Joined</dt>
                        <dd class="mt-1 text-sm text-ink-primary">{{ $user->created_at?->format('M j, Y') ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-muted">Email verified</dt>
                        <dd class="mt-1 text-sm text-ink-primary">{{ $user->email_verified_at ? 'Yes' : 'No' }}</dd>
                    </div>
                </dl>

                @if($user->company)
                    <div class="mt-6 pt-6 border-t border-border">
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-muted mb-2">Company</dt>
                        <a href="{{ route('company.show', $user->company->id) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand hover:text-brand-hover transition-colors">
                            {{ $user->company->name }}
                        </a>
                    </div>
                @endif

                @if($user->candidateProfile)
                    @php $profile = $user->candidateProfile; @endphp
                    <div class="mt-6 pt-6 border-t border-border space-y-3">
                        <h4 class="text-sm font-bold text-ink-primary">Candidate Profile</h4>
                        @if($profile->headline)
                            <p class="text-sm text-ink-primary">{{ $profile->headline }}</p>
                        @endif
                        <div class="flex flex-wrap gap-2">
                            @if($profile->location)
                                <x-badge variant="neutral">{{ $profile->location }}</x-badge>
                            @endif
                            @if($profile->experience_level)
                                <x-badge variant="neutral">{{ $profile->experience_level }}</x-badge>
                            @endif
                            @if($profile->open_to_remote)
                                <x-badge variant="info">Open to remote</x-badge>
                            @endif
                            @if($profile->is_available)
                                <x-badge variant="success">Available</x-badge>
                            @endif
                        </div>
                        @if($profile->bio)
                            <p class="text-sm text-ink-secondary">{{ $profile->bio }}</p>
                        @endif
                        @if(! empty($profile->skills))
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($profile->skills as $skill)
                                    <span class="badge-neutral">{{ $skill }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="card p-6">
                <h3 class="text-heading-card font-bold text-ink-primary mb-4">Activity</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-ink-secondary">Applications</span>
                        <span class="text-lg font-bold text-ink-primary">{{ $user->job_applications_count }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-ink-secondary">Resumes</span>
                        <span class="text-lg font-bold text-ink-primary">{{ $user->resumes_count }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($recentApplications->count() > 0)
            <div>
                <h3 class="text-heading-card font-bold text-ink-primary mb-3">Recent Applications</h3>
                <x-table :headers="['Job', 'Company', 'Applied', 'Status']">
                    @foreach($recentApplications as $app)
                        <tr class="hover:bg-surface-subtle transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-semibold text-ink-primary">{{ $app->jobVacancy->title ?? '—' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-ink-secondary">{{ $app->jobVacancy->company->name ?? '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-ink-muted">{{ $app->created_at?->diffForHumans() }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-status-badge :status="$app->status" />
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <x-button variant="secondary" size="sm" href="{{ route('job-application.show', $app->id) }}">View</x-button>
                            </td>
                        </tr>
                    @endforeach
                </x-table>
            </div>
        @endif
    </div>
</x-app-layout>

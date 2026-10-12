<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-lg font-extrabold text-ink-primary font-display tracking-tight">Job Vacancies</h1>
            <p class="text-xs text-ink-muted mt-0.5">
                @if(request()->boolean('archieve')) Archived vacancies
                @else Manage your active job listings @endif
            </p>
        </div>
        <div class="flex items-center gap-2">
            @if(request()->boolean('archieve'))
                <x-button variant="ghost" href="{{ route('job-vacancy.index') }}">View Active</x-button>
            @else
                <x-button variant="ghost" href="{{ route('job-vacancy.index', ['archieve' => true]) }}">Archived</x-button>
                <x-button variant="primary" href="{{ route('job-vacancy.create') }}" id="create-vacancy-btn">
                    + New Vacancy
                </x-button>
            @endif
        </div>
    </x-slot>

    <div class="max-w-7xl space-y-6">
        @if(session('success'))
            <x-alert variant="success" dismissible>{{ session('success') }}</x-alert>
        @endif

        @php
            if (auth()->user()->role === 'company_owner') {
                $headers = ['Title', 'Type', 'Status', 'Applications'];
            } else {
                $headers = ['Title', 'Company', 'Type', 'Status', 'Applications'];
            }
        @endphp

        @if($Vacancies->count() > 0)
            <x-table :headers="$headers">
                @foreach($Vacancies as $Vacancy)
                    @php
                        $statusBadge = match(true) {
                            $Vacancy->trashed() => ['neutral', 'Archived'],
                            $Vacancy->status === 'published' && $Vacancy->isExpired() => ['danger', 'Expired'],
                            $Vacancy->status === 'published' => ['success', 'Published'],
                            default => ['warning', 'Draft'],
                        };
                    @endphp
                    <tr class="hover:bg-surface-subtle transition-colors">
                        <td class="px-6 py-4">
                            @if(request()->boolean('archieve'))
                                <span class="font-semibold text-ink-primary">{{ $Vacancy->title }}</span>
                            @else
                                <a href="{{ route('job-vacancy.show', $Vacancy->id) }}" class="font-semibold text-ink-primary hover:text-brand transition-colors">
                                    {{ $Vacancy->title }}
                                </a>
                                <p class="text-xs text-ink-muted mt-0.5">{{ Str::limit($Vacancy->location, 40) }}</p>
                            @endif
                        </td>
                        @if(auth()->user()->role === 'admin')
                            <td class="px-6 py-4 whitespace-nowrap text-ink-secondary">{{ $Vacancy->company->name ?? '—' }}</td>
                        @endif
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-badge variant="neutral">{{ $Vacancy->type }}</x-badge>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-badge :variant="$statusBadge[0]">{{ $statusBadge[1] }}</x-badge>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center justify-center min-w-[2rem] h-8 px-2 rounded-lg bg-brand-subtle text-brand text-xs font-bold border border-brand/20">
                                {{ $Vacancy->job_applications_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="inline-flex items-center gap-2">
                                @if(request()->boolean('archieve'))
                                    <form action="{{ route('job-vacancy.restore', $Vacancy->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <x-button variant="success" size="sm" type="submit">Restore</x-button>
                                    </form>
                                @else
                                    <x-button variant="primary" size="sm" href="{{ route('job-vacancy.edit', $Vacancy->id) }}">Edit</x-button>
                                    <form action="{{ route('job-vacancy.toggle-status', $Vacancy->id) }}" method="POST">
                                        @csrf
                                        <x-button :variant="$Vacancy->status === 'published' ? 'secondary' : 'success'" size="sm" type="submit">
                                            {{ $Vacancy->status === 'published' ? 'Unpublish' : 'Publish' }}
                                        </x-button>
                                    </form>
                                    <form action="{{ route('job-vacancy.destroy', $Vacancy->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-button variant="danger-outline" size="sm" type="submit">Archive</x-button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-table>

            <div>
                {{ $Vacancies->links() }}
            </div>
        @else
            <x-empty-state
                icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>'
                :title="request()->boolean('archieve') ? 'No archived vacancies' : 'No vacancies yet'"
                :description="request()->boolean('archieve') ? 'Vacancies you archive will appear here and can be restored anytime.' : 'Create your first job listing and start receiving applications.'">
                @unless(request()->boolean('archieve'))
                    <x-slot name="action">
                        <x-button variant="primary" href="{{ route('job-vacancy.create') }}">+ New Vacancy</x-button>
                    </x-slot>
                @endunless
            </x-empty-state>
        @endif
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-lg font-extrabold text-ink-primary font-display tracking-tight">Companies</h1>
            <p class="text-xs text-ink-muted mt-0.5">
                @if(request()->boolean('archieve')) Archived companies
                @else Manage companies and their owners @endif
            </p>
        </div>
        <div class="flex items-center gap-2">
            @if(request()->boolean('archieve'))
                <x-button variant="ghost" href="{{ route('company.index') }}">View Active</x-button>
            @else
                <x-button variant="ghost" href="{{ route('company.index', ['archieve' => true]) }}">Archived</x-button>
                <x-button variant="primary" href="{{ route('company.create') }}">+ New Company</x-button>
            @endif
        </div>
    </x-slot>

    <div class="max-w-7xl space-y-6">
        @if(session('success'))
            <x-alert variant="success" dismissible>{{ session('success') }}</x-alert>
        @endif
        @if(session('error'))
            <x-alert variant="danger" dismissible>{{ session('error') }}</x-alert>
        @endif

        @if($companies->count() > 0)
            <x-table :headers="['Company', 'Industry', 'Owner', 'Jobs']">
                @foreach($companies as $company)
                    <tr class="hover:bg-surface-subtle transition-colors">
                        <td class="px-6 py-4">
                            @if(request()->boolean('archieve'))
                                <span class="font-semibold text-ink-primary">{{ $company->name }}</span>
                            @else
                                <a href="{{ route('company.show', $company->id) }}" class="font-semibold text-ink-primary hover:text-brand transition-colors">
                                    {{ $company->name }}
                                </a>
                            @endif
                            <p class="text-xs text-ink-muted mt-0.5">{{ Str::limit($company->address, 50) }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-ink-secondary">{{ $company->industry ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($company->owner)
                                <span class="text-ink-primary">{{ $company->owner->name }}</span>
                                <p class="text-xs text-ink-muted mt-0.5">{{ $company->owner->email }}</p>
                            @else
                                <span class="text-ink-muted">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center justify-center min-w-[2rem] h-8 px-2 rounded-lg bg-brand-subtle text-brand text-xs font-bold border border-brand/20">
                                {{ $company->job_vacancies_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="inline-flex items-center gap-2">
                                @if(request()->boolean('archieve'))
                                    <form action="{{ route('company.restore', $company->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <x-button variant="success" size="sm" type="submit">Restore</x-button>
                                    </form>
                                @else
                                    <x-button variant="secondary" size="sm" href="{{ route('company.show', $company->id) }}">View</x-button>
                                    <x-button variant="primary" size="sm" href="{{ route('company.edit', $company->id) }}">Edit</x-button>
                                    <form action="{{ route('company.destroy', $company->id) }}" method="POST">
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
                {{ $companies->links() }}
            </div>
        @else
            <x-empty-state
                icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>'
                :title="request()->boolean('archieve') ? 'No archived companies' : 'No companies yet'"
                :description="request()->boolean('archieve') ? 'Companies you archive will appear here and can be restored anytime.' : 'Create your first company and assign an owner to it.'">
                @unless(request()->boolean('archieve'))
                    <x-slot name="action">
                        <x-button variant="primary" href="{{ route('company.create') }}">+ New Company</x-button>
                    </x-slot>
                @endunless
            </x-empty-state>
        @endif
    </div>
</x-app-layout>

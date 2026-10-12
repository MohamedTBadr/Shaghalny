<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-lg font-extrabold text-ink-primary font-display tracking-tight">Job Categories</h1>
            <p class="text-xs text-ink-muted mt-0.5">
                @if(request()->boolean('archieve')) Archived job categories
                @else Organize job listings into categories @endif
            </p>
        </div>
        <div class="flex items-center gap-2">
            @if(request()->boolean('archieve'))
                <x-button variant="ghost" href="{{ route('job-category.index') }}">View Active</x-button>
            @else
                <x-button variant="ghost" href="{{ route('job-category.index', ['archieve' => true]) }}">Archived</x-button>
                <x-button variant="primary" href="{{ route('job-category.create') }}">+ New Category</x-button>
            @endif
        </div>
    </x-slot>

    <div class="max-w-4xl space-y-6">
        @if(session('success'))
            <x-alert variant="success" dismissible>{{ session('success') }}</x-alert>
        @endif

        @if($jobCategories->count() > 0)
            <x-table :headers="['Category', 'Vacancies']">
                @foreach($jobCategories as $category)
                    <tr class="hover:bg-surface-subtle transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-semibold text-ink-primary">{{ $category->name }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center justify-center min-w-[2rem] h-8 px-2 rounded-lg bg-brand-subtle text-brand text-xs font-bold border border-brand/20">
                                {{ $category->job_vacancies_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="inline-flex items-center gap-2">
                                @if(request()->boolean('archieve'))
                                    <form action="{{ route('job-category.restore', $category->id) }}" method="POST">
                                        @csrf
                                        <x-button variant="success" size="sm" type="submit">Restore</x-button>
                                    </form>
                                @else
                                    <x-button variant="primary" size="sm" href="{{ route('job-category.edit', $category->id) }}">Edit</x-button>
                                    <form action="{{ route('job-category.destroy', $category->id) }}" method="POST">
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
                {{ $jobCategories->links() }}
            </div>
        @else
            <x-empty-state
                icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>'
                :title="request()->boolean('archieve') ? 'No archived categories' : 'No categories yet'"
                :description="request()->boolean('archieve') ? 'Categories you archive will appear here and can be restored anytime.' : 'Create categories to help candidates browse job listings.'">
                @unless(request()->boolean('archieve'))
                    <x-slot name="action">
                        <x-button variant="primary" href="{{ route('job-category.create') }}">+ New Category</x-button>
                    </x-slot>
                @endunless
            </x-empty-state>
        @endif
    </div>
</x-app-layout>

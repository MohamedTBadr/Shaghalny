<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-lg font-extrabold text-ink-primary font-display tracking-tight">Users</h1>
            <p class="text-xs text-ink-muted mt-0.5">
                @if(request()->boolean('archieve')) Archived users
                @else Manage all platform accounts @endif
            </p>
        </div>
        <div class="flex items-center gap-2">
            @if(request()->boolean('archieve'))
                <x-button variant="ghost" href="{{ route('user.index') }}">View Active</x-button>
            @else
                <x-button variant="ghost" href="{{ route('user.index', ['archieve' => true]) }}">Archived</x-button>
            @endif
        </div>
    </x-slot>

    <div class="max-w-7xl space-y-6">
        @if(session('success'))
            <x-alert variant="success" dismissible>{{ session('success') }}</x-alert>
        @endif

        @php
            $roleVariant = [
                'admin' => 'brand',
                'company_owner' => 'info',
                'job_seeker' => 'success',
            ];
        @endphp

        @if($users->count() > 0)
            <x-table :headers="['User', 'Role', 'Joined']">
                @foreach($users as $user)
                    <tr class="hover:bg-surface-subtle transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-brand-subtle text-brand font-bold flex items-center justify-center text-xs shrink-0">
                                    {{ Str::of($user->name)->substr(0, 1)->upper() }}
                                </div>
                                <div class="min-w-0">
                                    <a href="{{ route('user.show', $user->id) }}" class="font-semibold text-ink-primary hover:text-brand transition-colors">
                                        {{ $user->name }}
                                    </a>
                                    <p class="text-xs text-ink-muted mt-0.5">{{ $user->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-badge :variant="$roleVariant[$user->role] ?? 'neutral'">{{ $user->role ?? 'N/A' }}</x-badge>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-ink-muted">{{ $user->created_at?->format('M j, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="inline-flex items-center gap-2">
                                @if(request()->boolean('archieve'))
                                    @if($user->role !== 'admin')
                                        <form action="{{ route('user.restore', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <x-button variant="success" size="sm" type="submit">Restore</x-button>
                                        </form>
                                    @endif
                                @else
                                    <x-button variant="secondary" size="sm" href="{{ route('user.show', $user->id) }}">View</x-button>
                                    @if($user->role !== 'admin' || $user->id === auth()->id())
                                        <x-button variant="primary" size="sm" href="{{ route('user.edit', $user->id) }}">Edit</x-button>
                                    @endif
                                    @if($user->role !== 'admin' && $user->id !== auth()->id())
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <x-button variant="danger-outline" size="sm" type="submit">Archive</x-button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-table>

            <div>
                {{ $users->links() }}
            </div>
        @else
            <x-empty-state
                icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'
                :title="request()->boolean('archieve') ? 'No archived users' : 'No users found'"
                :description="request()->boolean('archieve') ? 'Users you archive will appear here and can be restored anytime.' : 'No user accounts match this view.'" />
        @endif
    </div>
</x-app-layout>

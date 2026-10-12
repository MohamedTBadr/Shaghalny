<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-lg font-extrabold text-ink-primary font-display tracking-tight">Applications</h1>
            <p class="text-xs text-ink-muted mt-0.5">
                @if(request()->boolean('archieve')) Archived applications
                @else Review and manage candidate applications @endif
            </p>
        </div>
        <div class="flex items-center gap-2">
            @if(request()->boolean('archieve'))
                <x-button variant="ghost" href="{{ route('job-application.index', array_filter(['status' => request('status')])) }}">View Active</x-button>
            @else
                <x-button variant="ghost" href="{{ route('job-application.index', array_filter(['archieve' => true, 'status' => request('status')])) }}">Archived</x-button>
            @endif
        </div>
    </x-slot>

    <div class="max-w-7xl space-y-6">
        @if(session('success'))
            <x-alert variant="success" dismissible>{{ session('success') }}</x-alert>
        @endif

        @unless(request()->boolean('archieve'))
            @php
                $tabs = [
                    ['key' => null, 'label' => 'All', 'count' => $counts['all']],
                    ['key' => 'Pending', 'label' => 'Under review', 'count' => $counts['Pending']],
                    ['key' => 'Accepted', 'label' => 'Accepted', 'count' => $counts['Accepted']],
                    ['key' => 'Rejected', 'label' => 'Rejected', 'count' => $counts['Rejected']],
                ];
            @endphp
            <div class="flex items-center gap-2 flex-wrap">
                @foreach($tabs as $tab)
                    @php $active = request('status') === $tab['key'] || (is_null($tab['key']) && ! request('status')); @endphp
                    <a href="{{ route('job-application.index', array_filter(['status' => $tab['key']])) }}"
                       class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-sm font-semibold border transition-all {{ $active ? 'bg-brand text-accent-contrast border-brand shadow-subtle' : 'bg-surface text-ink-secondary border-border hover:border-brand hover:text-brand' }}">
                        {{ $tab['label'] }}
                        <span class="inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1.5 rounded-full text-[10px] font-bold {{ $active ? 'bg-white/20 text-white' : 'bg-surface-muted text-ink-secondary' }}">
                            {{ $tab['count'] }}
                        </span>
                    </a>
                @endforeach
            </div>
        @endunless

        @if($apps->count() > 0)
            <div class="hidden lg:block">
                @php
                    $headers = auth()->user()->role === 'admin'
                        ? ['Applicant', 'Job', 'Company', 'Status', 'AI score', 'Applied']
                        : ['Applicant', 'Job', 'Status', 'AI score', 'Applied'];
                @endphp
                <x-table :headers="$headers">
                    @foreach($apps as $app)
                        <tr class="hover:bg-surface-subtle transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-brand-subtle text-brand flex items-center justify-center text-xs font-bold border border-brand/20 shrink-0">
                                        {{ substr($app->user->name ?? '?', 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <a href="{{ route('job-application.show', $app->id) }}" class="font-semibold text-ink-primary hover:text-brand transition-colors">{{ $app->user->name ?? '—' }}</a>
                                        <p class="text-xs text-ink-muted truncate">{{ $app->user->email ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-ink-primary">{{ $app->jobVacancy?->title ?? 'Removed vacancy' }}</span>
                            </td>
                            @if(auth()->user()->role === 'admin')
                                <td class="px-6 py-4 whitespace-nowrap text-ink-secondary">{{ $app->jobVacancy?->company?->name ?? '—' }}</td>
                            @endif
                            <td class="px-6 py-4">
                                <x-status-badge :status="$app->status" />
                            </td>
                            <td class="px-6 py-4">
                                @if(is_numeric($app->AI_Generated_score))
                                    <span class="text-sm font-bold text-ink-primary tabular-nums">{{ (int) $app->AI_Generated_score }}</span>
                                @else
                                    <span class="text-xs text-ink-muted">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-ink-muted">{{ $app->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="inline-flex items-center gap-2">
                                    @if(request()->boolean('archieve'))
                                        <form action="{{ route('job-application.restore', $app->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <x-button variant="success" size="sm" type="submit">Restore</x-button>
                                        </form>
                                    @else
                                        <x-button variant="primary" size="sm" href="{{ route('job-application.show', $app->id) }}">Review</x-button>
                                        <form action="{{ route('job-application.destroy', $app->id) }}" method="POST">
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
            </div>

            <!-- Mobile cards -->
            <div class="lg:hidden space-y-3">
                @foreach($apps as $app)
                    <a href="{{ route('job-application.show', $app->id) }}" class="block bg-surface border border-border rounded-2xl shadow-card p-4 hover:border-brand/30 transition-all">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <p class="font-semibold text-ink-primary truncate">{{ $app->user->name ?? '—' }}</p>
                                <p class="text-xs text-ink-muted mt-0.5">{{ $app->jobVacancy?->title ?? 'Removed vacancy' }}</p>
                                @if(auth()->user()->role === 'admin')
                                    <p class="text-xs text-ink-muted">{{ $app->jobVacancy?->company?->name ?? '—' }}</p>
                                @endif
                            </div>
                            <x-status-badge :status="$app->status" />
                        </div>
                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-border/60">
                            <span class="text-xs text-ink-muted">{{ $app->created_at->diffForHumans() }}</span>
                            @if(is_numeric($app->AI_Generated_score))
                                <span class="text-xs font-bold text-ink-secondary">AI {{ (int) $app->AI_Generated_score }}</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div>{{ $apps->links() }}</div>
        @else
            <x-empty-state
                icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>'
                title="No applications found"
                description="There are no applications matching this view yet." />
        @endif
    </div>
</x-app-layout>

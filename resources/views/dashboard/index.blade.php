<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-lg font-extrabold text-ink-primary font-display tracking-tight">Dashboard</h1>
            <p class="text-xs text-ink-muted mt-0.5">Platform analytics and performance overview</p>
        </div>
        <span class="text-xs text-ink-muted">{{ now()->format('l, M d Y') }}</span>
    </x-slot>

    <div class="space-y-8 max-w-7xl">

        {{-- ── Stat Cards ─────────────────────────────────────────────────── --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-stat-card
                label="Active Users"
                :value="$Analytics['activeUsers']"
                caption="Last 30 days"
                icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>'
                id="stat-active-users"
            />
            <x-stat-card
                label="Total Jobs"
                :value="$Analytics['totalJobs']"
                caption="All time"
                icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>'
                id="stat-total-jobs"
            />
            <x-stat-card
                label="Total Applications"
                :value="$Analytics['totalApplications']"
                caption="All time"
                icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>'
                id="stat-total-applications"
            />
        </div>

        {{-- ── Most Applied Jobs ──────────────────────────────────────────── --}}
        <div class="bg-surface border border-border rounded-2xl overflow-hidden" id="most-applied-table">
            <div class="px-6 py-4 border-b border-border flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-extrabold text-ink-primary font-display">Most Applied Jobs</h2>
                    <p class="text-xs text-ink-muted mt-0.5">Top performing listings by application volume</p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-surface-subtle border-b border-border">
                            <th class="text-left px-6 py-3 text-xs font-bold text-ink-muted uppercase tracking-wider">Job Title</th>
                            <th class="text-left px-6 py-3 text-xs font-bold text-ink-muted uppercase tracking-wider">Company</th>
                            <th class="text-right px-6 py-3 text-xs font-bold text-ink-muted uppercase tracking-wider">Applications</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($Analytics['mostAppliedJobs'] as $job)
                            <tr class="hover:bg-surface-subtle transition-colors" id="applied-job-{{ $loop->iteration }}">
                                <td class="px-6 py-3.5">
                                    <a href="{{ route('job-vacancy.show', $job->id) }}" class="font-semibold text-ink-primary hover:text-brand transition-colors">
                                        {{ $job->title }}
                                    </a>
                                </td>
                                <td class="px-6 py-3.5 text-ink-secondary">{{ $job->company->name ?? '—' }}</td>
                                <td class="px-6 py-3.5 text-right">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-brand-subtle text-brand text-xs font-bold border border-brand/20">
                                        {{ $job->totalCount }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-sm text-ink-muted">No data yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ── Conversion Rates ───────────────────────────────────────────── --}}
        <div class="bg-surface border border-border rounded-2xl overflow-hidden" id="conversion-table">
            <div class="px-6 py-4 border-b border-border">
                <h2 class="text-sm font-extrabold text-ink-primary font-display">Conversion Rates</h2>
                <p class="text-xs text-ink-muted mt-0.5">Views to applications conversion per listing</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-surface-subtle border-b border-border">
                            <th class="text-left px-6 py-3 text-xs font-bold text-ink-muted uppercase tracking-wider">Job Title</th>
                            <th class="text-right px-6 py-3 text-xs font-bold text-ink-muted uppercase tracking-wider">Views</th>
                            <th class="text-right px-6 py-3 text-xs font-bold text-ink-muted uppercase tracking-wider">Applications</th>
                            <th class="text-right px-6 py-3 text-xs font-bold text-ink-muted uppercase tracking-wider">Conversion</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($Analytics['Conversions'] as $c)
                            @php $rate = (float)($c->conversionRate ?? 0); @endphp
                            <tr class="hover:bg-surface-subtle transition-colors" id="conversion-row-{{ $loop->iteration }}">
                                <td class="px-6 py-3.5 font-semibold text-ink-primary">{{ $c->title }}</td>
                                <td class="px-6 py-3.5 text-right text-ink-secondary">{{ $c->viewCount }}</td>
                                <td class="px-6 py-3.5 text-right text-ink-secondary">{{ $c->totalCount }}</td>
                                <td class="px-6 py-3.5 text-right">
                                    @php
                                        $rateClass = match(true) {
                                            $rate >= 20 => 'text-accent-success-strong bg-accent-success-subtle border-accent-success/25',
                                            $rate >= 10 => 'text-accent-warning-strong bg-accent-warning-subtle border-accent-warning/25',
                                            default     => 'text-accent-danger-strong bg-accent-danger-subtle border-accent-danger/25',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg border text-xs font-bold {{ $rateClass }}">
                                        {{ $rate }}%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-sm text-ink-muted">No conversion data available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

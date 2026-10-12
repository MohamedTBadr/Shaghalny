<x-main-layout :title="$company->name . ' — Hiring & Open Roles'">
    <div class="container-page py-10 sm:py-14">
        <x-breadcrumbs :items="[
            ['label' => 'Companies', 'href' => route('companies.index')],
            ['label' => $company->name],
        ]" />

        <!-- Company header card -->
        <div class="mt-8 bg-surface border border-border rounded-2xl shadow-card p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-start gap-6">
                <x-company-logo :company="$company" size="xl" />

                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-3">
                        <h1 class="text-heading-page font-extrabold text-ink-primary">{{ $company->name }}</h1>
                        <x-badge variant="success">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Verified employer
                        </x-badge>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-ink-secondary">
                        @if($company->industry)
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-ink-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                {{ $company->industry }}
                            </span>
                        @endif
                        @if($company->address)
                            <span class="inline-flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-ink-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $company->address }}
                            </span>
                        @endif
                        @if($company->website)
                            <a href="http://{{ $company->website }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-brand hover:underline font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 015.656 0M10.172 13.828a4 4 0 010-5.656M8.9 15.1l6.2-6.2m-.7 7.9l-6.2 6.2"/></svg>
                                {{ $company->website }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Open roles -->
            <section class="lg:col-span-2">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-heading-section font-bold text-ink-primary">
                        Open vacancies
                        <span class="text-base text-ink-muted font-medium">({{ $jobs->count() }})</span>
                    </h2>
                    <a href="{{ route('jobs.index', ['search' => $company->name]) }}" class="text-sm font-medium text-brand hover:underline">
                        View all
                    </a>
                </div>

                @if($jobs->count() > 0)
                    <div class="space-y-4">
                        @foreach($jobs as $job)
                            <x-job-card :job="$job" />
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="w-12 h-12 rounded-xl bg-surface-muted text-ink-muted flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-heading-card font-bold text-ink-primary">No open roles right now</h3>
                        <p class="mt-1.5 text-sm text-ink-muted max-w-sm">
                            {{ $company->name }} is not hiring through Shaghalny at the moment. Check back soon.
                        </p>
                    </div>
                @endif
            </section>

            <!-- About sidebar -->
            <aside class="space-y-6">
                <div class="surface-card p-6">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-ink-primary mb-4">At a glance</h3>
                    <dl class="space-y-3.5 text-sm">
                        <div class="flex items-center justify-between">
                            <dt class="text-ink-muted">Open roles</dt>
                            <dd class="font-semibold text-ink-primary">{{ $jobs->count() }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-ink-muted">Industry</dt>
                            <dd class="font-semibold text-ink-primary">{{ $company->industry ?? '—' }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-ink-muted">Location</dt>
                            <dd class="font-semibold text-ink-primary text-right">{{ $company->address ?? '—' }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-ink-muted">Verification</dt>
                            <dd>
                                <span class="inline-flex items-center gap-1 text-accent-success font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    Verified
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-brand-900 text-white rounded-2xl p-6">
                    <h3 class="text-heading-card font-bold">Hiring on Shaghalny?</h3>
                    <p class="mt-2 text-sm text-brand-100 leading-relaxed">
                        Post vacancies, review AI-scored applications, and manage your pipeline from one workspace.
                    </p>
                    <a href="{{ route('register') }}" class="mt-4 inline-flex btn bg-white text-brand hover:bg-brand-50 font-semibold text-sm px-4 py-2.5 rounded-lg">
                        Get started
                    </a>
                </div>
            </aside>
        </div>
    </div>
</x-main-layout>

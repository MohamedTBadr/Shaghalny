@props(['job', 'saved' => false])

@php
    $isSaved = $saved || (auth()->check() && auth()->user()->savedJobs()->where('job_vacancy_id', $job->id)->exists());
@endphp

<div {{ $attributes->merge(['class' => 'group relative bg-surface border border-border rounded-xl p-5 sm:p-6 shadow-card hover:shadow-card-hover hover:border-brand/40 transition-all duration-200 flex flex-col justify-between']) }}>
    <div>
        <!-- Top row: Company & Badges -->
        <div class="flex items-start justify-between gap-4 mb-3">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-lg bg-surface-muted border border-border/80 flex items-center justify-center text-brand font-bold text-base uppercase shrink-0 font-display">
                    {{ substr($job->company?->name ?? 'C', 0, 2) }}
                </div>
                <div>
                    <span class="text-xs font-semibold text-ink-secondary flex items-center gap-1">
                        {{ $job->company?->name ?? 'Company' }}
                        @if($job->company?->website)
                            <svg class="w-3.5 h-3.5 text-accent-info" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        @endif
                    </span>
                    <h3 class="text-base sm:text-lg font-bold text-ink-primary group-hover:text-brand transition-colors line-clamp-1 mt-0.5">
                        <a href="{{ route('job-vacancies.show', $job->id) }}" class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            {{ $job->title }}
                        </a>
                    </h3>
                </div>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <x-badge :variant="$job->type">
                    {{ $job->type }}
                </x-badge>

                @auth
                    <form action="{{ $isSaved ? route('saved-jobs.destroy', $job->id) : route('saved-jobs.store', $job->id) }}"
                          method="POST"
                          class="relative z-10">
                        @csrf
                        @if($isSaved)
                            @method('DELETE')
                        @endif
                        <button type="submit"
                                title="{{ $isSaved ? 'Remove from saved' : 'Save this job' }}"
                                class="w-9 h-9 inline-flex items-center justify-center rounded-lg border transition-colors {{ $isSaved ? 'bg-brand-subtle border-brand/30 text-brand hover:bg-brand-100' : 'border-border bg-surface text-ink-muted hover:text-brand hover:border-brand/40' }}">
                            <svg class="w-4.5 h-4.5" fill="{{ $isSaved ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z"/>
                            </svg>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       title="Sign in to save this job"
                       class="relative z-10 w-9 h-9 inline-flex items-center justify-center rounded-lg border border-border bg-surface text-ink-muted hover:text-brand hover:border-brand/40 transition-colors">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z"/>
                        </svg>
                    </a>
                @endauth
            </div>
        </div>

        <!-- Description snippet -->
        <p class="text-xs sm:text-sm text-ink-secondary line-clamp-2 mb-4 leading-relaxed">
            {{ Str::limit($job->description, 130) }}
        </p>

        <!-- Metadata pill strip -->
        <div class="flex flex-wrap items-center gap-y-2 gap-x-4 text-xs text-ink-muted">
            <span class="flex items-center gap-1.5 text-ink-secondary">
                <svg class="w-3.5 h-3.5 text-ink-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ $job->location }}
            </span>
            <span class="flex items-center gap-1.5 font-semibold text-ink-primary">
                <svg class="w-3.5 h-3.5 text-accent-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                ${{ number_format($job->salary) }}<span class="text-ink-muted font-normal text-[11px]">/yr</span>
            </span>
            @if($job->JobCategory)
                <span class="px-2 py-0.5 rounded bg-surface-muted text-ink-secondary text-[11px] font-medium border border-border">
                    {{ $job->JobCategory->name }}
                </span>
            @endif
        </div>
    </div>

    <!-- Card Footer -->
    <div class="mt-4 pt-3.5 border-t border-border flex items-center justify-between text-xs text-ink-muted">
        <span>Posted {{ $job->created_at->diffForHumans() }}</span>
        <span class="inline-flex items-center text-brand font-semibold group-hover:translate-x-0.5 transition-transform">
            View Role &rarr;
        </span>
    </div>
</div>

@props(['categories' => []])

<div class="space-y-7">
    <!-- Categories -->
    <div>
        <h3 class="text-xs font-bold uppercase tracking-wider text-ink-primary mb-3">Category</h3>
        <ul class="space-y-1">
            <li>
                <a href="{{ request()->fullUrlWithQuery(['category' => null, 'page' => null]) }}"
                   class="{{ !request('category') ? 'text-brand font-semibold bg-brand-subtle' : 'text-ink-secondary hover:text-ink-primary hover:bg-surface-muted' }} flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-colors">
                    <span>All categories</span>
                    <span class="text-xs tabular-nums">{{ $categories->sum('jobs_count') }}</span>
                </a>
            </li>
            @foreach($categories as $category)
                <li>
                    <a href="{{ request()->fullUrlWithQuery(['category' => $category->id, 'page' => null]) }}"
                       class="{{ request('category') == $category->id ? 'text-brand font-semibold bg-brand-subtle' : 'text-ink-secondary hover:text-ink-primary hover:bg-surface-muted' }} flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-colors">
                        <span class="truncate">{{ $category->name }}</span>
                        <span class="text-xs tabular-nums">{{ $category->jobs_count }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Employment type -->
    <div>
        <h3 class="text-xs font-bold uppercase tracking-wider text-ink-primary mb-3">Work type</h3>
        <ul class="space-y-1">
            @foreach(['Full-Time', 'Remote', 'Hybrid', 'Contract', 'Part-Time', 'Freelance', 'Internship'] as $type)
                <li>
                    <a href="{{ request()->fullUrlWithQuery(['type' => $type === 'Full-Time' ? null : $type, 'page' => null]) }}"
                       class="{{ request('type') === $type ? 'text-brand font-semibold bg-brand-subtle' : 'text-ink-secondary hover:text-ink-primary hover:bg-surface-muted' }} flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-colors">
                        <span>{{ $type }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Salary -->
    <div>
        <h3 class="text-xs font-bold uppercase tracking-wider text-ink-primary mb-3">Annual salary</h3>
        <ul class="space-y-1">
            @foreach([
                '' => 'Any salary',
                '50000' => '$50k and above',
                '80000' => '$80k and above',
                '100000' => '$100k and above',
                '150000' => '$150k and above',
            ] as $value => $label)
                <li>
                    <a href="{{ request()->fullUrlWithQuery(['min_salary' => $value ?: null, 'page' => null]) }}"
                       class="{{ request('min_salary') == $value ? 'text-brand font-semibold bg-brand-subtle' : 'text-ink-secondary hover:text-ink-primary hover:bg-surface-muted' }} flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-colors">
                        <span>{{ $label }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    @if(request()->hasAny(['search', 'location', 'type', 'category', 'min_salary']))
        <div class="border-t border-border pt-4">
            <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-accent-danger hover:text-accent-danger-strong">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                Clear all filters
            </a>
        </div>
    @endif
</div>
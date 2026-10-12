<x-main-layout title="Job Categories — Shaghalny">
    <div class="container-page py-10 sm:py-14">
        <x-breadcrumbs :items="[['label' => 'Categories']]" />

        <x-page-header class="mt-6">
            <x-slot name="title">Browse by category</x-slot>
            <x-slot name="description">
                Narrow your search across {{ $categories->count() }} industry categories with live hiring counts.
            </x-slot>
        </x-page-header>

        @if($categories->count() > 0)
            <div class="mt-10 grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($categories as $category)
                    @php
                        $accent = ['bg-brand-subtle text-brand', 'bg-accent-success-subtle text-accent-success', 'bg-accent-info-subtle text-accent-info', 'bg-accent-warning-subtle text-accent-warning', 'bg-accent-danger-subtle text-accent-danger'][fmod(crc32($category->id), 5)];
                    @endphp
                    <a href="{{ route('categories.show', $category->id) }}"
                       class="card-interactive p-5 flex flex-col justify-between group">
                        <div>
                            <div class="w-10 h-10 rounded-xl {{ $accent }} flex items-center justify-center font-bold text-sm mb-4 group-hover:scale-105 transition-transform">
                                {{ strtoupper(Str::substr(Str::slug($category->name), 0, 2)) }}
                            </div>
                            <h3 class="text-sm sm:text-base font-bold text-ink-primary group-hover:text-brand transition-colors">{{ $category->name }}</h3>
                        </div>
                        <p class="mt-4 text-xs text-ink-muted flex items-center justify-between">
                            <span>{{ $category->jobs_count }} {{ Str::plural('open role', $category->jobs_count) }}</span>
                            <span class="text-brand font-semibold">&rarr;</span>
                        </p>
                    </a>
                @endforeach
            </div>
        @else
            <div class="mt-10">
                <x-empty-state
                    icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>'
                    title="No categories yet"
                    description="Categories will appear here as employers post their first vacancies.">
                </x-empty-state>
            </div>
        @endif
    </div>
</x-main-layout>
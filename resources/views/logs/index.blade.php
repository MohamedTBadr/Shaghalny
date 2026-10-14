<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-lg font-extrabold text-ink-primary font-display tracking-tight">System Logs</h1>
            <p class="text-xs text-ink-muted mt-0.5">
                Structured application activity from the dedicated <span class="font-mono text-ink-secondary">system</span> channel
            </p>
        </div>
        <div class="flex items-center gap-2">
            <x-button variant="secondary" size="sm" href="{{ route('logs.index', $selectedFile ? ['file' => $selectedFile] : []) }}">
                Refresh
            </x-button>
        </div>
    </x-slot>

    <style>
        .log-level {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.04em;
            line-height: 1.4;
            border: 1px solid transparent;
        }
        .log-level.INFO     { background: #dbeafe; color: #1d4ed8; border-color: #bfdbfe; }
        .log-level.DEBUG    { background: #f1f5f9; color: #475569; border-color: #e2e8f0; }
        .log-level.NOTICE   { background: #e0e7ff; color: #4338ca; border-color: #c7d2fe; }
        .log-level.WARNING  { background: #fef3c7; color: #b45309; border-color: #fde68a; }
        .log-level.ERROR    { background: #fee2e2; color: #b91c1c; border-color: #fecaca; }
        .log-level.CRITICAL { background: #fecaca; color: #991b1b; border-color: #fca5a5; }
        .log-level.UNKNOWN  { background: #f3f4f6; color: #6b7280; border-color: #e5e7eb; }
    </style>

    <div class="max-w-7xl space-y-4"
         x-data="logViewer(@json($logFiles), @json($logs), @json($selectedFile))">

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">

            {{-- File list --}}
            <aside class="lg:col-span-1">
                <div class="bg-surface border border-border rounded-xl overflow-hidden">
                    <div class="px-4 py-3 border-b border-border">
                        <h2 class="text-xs font-bold uppercase tracking-wider text-ink-muted">Log Files</h2>
                    </div>

                    @if(count($logFiles) === 0)
                        <div class="px-4 py-6 text-xs text-ink-muted text-center">No log files found.</div>
                    @else
                        <nav class="p-2 space-y-0.5 max-h-[70vh] overflow-y-auto">
                            @foreach($logFiles as $file)
                                @php $isActive = $file === $selectedFile; @endphp
                                <a href="{{ route('logs.index', ['file' => $file]) }}"
                                   class="block px-3 py-2 rounded-lg text-xs font-mono truncate transition-colors {{ $isActive ? 'bg-brand-subtle text-brand font-semibold' : 'text-ink-secondary hover:bg-surface-subtle hover:text-ink-primary' }}"
                                   title="{{ $file }}">
                                    {{ $file }}
                                </a>
                            @endforeach
                        </nav>
                    @endif
                </div>
            </aside>

            {{-- Entries --}}
            <section class="lg:col-span-3 space-y-3">

                @if($selectedFile)
                    <div class="flex items-center justify-between gap-3">
                        <div class="text-xs text-ink-muted truncate">
                            Showing newest first from
                            <span class="font-mono text-ink-secondary">{{ $selectedFile }}</span>
                        </div>
                        <span class="text-[11px] font-semibold text-ink-muted"
                              x-text="entries.length + ' entr' + (entries.length === 1 ? 'y' : 'ies')"></span>
                    </div>
                @endif

                <template x-if="entries.length === 0">
                    <div class="bg-surface border border-border rounded-xl px-6 py-12 text-center">
                        <p class="text-sm font-semibold text-ink-secondary">No entries to display</p>
                        <p class="text-xs text-ink-muted mt-1">Interact with the application and refresh to see structured log entries.</p>
                    </div>
                </template>

                <div class="bg-surface border border-border rounded-xl divide-y divide-border overflow-hidden">
                    <template x-for="(entry, index) in entries" :key="index">
                        <article class="px-4 py-3 hover:bg-surface-subtle transition-colors">
                            <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                                <span class="text-[11px] font-mono text-ink-muted whitespace-nowrap"
                                      x-text="entry.time || '—'"></span>
                                <span class="log-level" :class="entry.level || 'UNKNOWN'"
                                      x-text="entry.level || 'UNKNOWN'"></span>
                                <span class="text-[11px] font-mono text-ink-muted"
                                      x-show="entry.channel" x-text="'#' + (entry.channel || '')"></span>
                            </div>

                            <p class="mt-1.5 text-sm font-medium text-ink-primary break-words"
                               x-text="entry.message || '(no message)'"></p>

                            {{-- Meta chips --}}
                            <div class="mt-2 flex flex-wrap items-center gap-1.5">
                                <template x-if="entry.user">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-brand-subtle text-brand border border-brand/20">
                                        <span>user:</span><span x-text="entry.user"></span>
                                    </span>
                                </template>

                                <template x-if="entry.ip">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-mono bg-surface-muted text-ink-secondary border border-border">
                                        <span>ip:</span><span x-text="entry.ip"></span>
                                    </span>
                                </template>

                                <template x-if="entry.method || entry.status">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-mono bg-surface-muted text-ink-secondary border border-border">
                                        <span x-text="entry.method || ''"></span>
                                        <span x-show="entry.status" x-text="entry.status || ''"></span>
                                    </span>
                                </template>

                                <template x-if="entry.duration_ms !== null && entry.duration_ms !== undefined && entry.duration_ms !== ''">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-mono bg-surface-muted text-ink-secondary border border-border">
                                        <span x-text="entry.duration_ms + ' ms'"></span>
                                    </span>
                                </template>
                            </div>

                            {{-- URL line --}}
                            <div class="mt-2 text-[11px] font-mono text-ink-muted break-all"
                                 x-show="entry.url">
                                <span x-show="entry.method" class="text-ink-secondary" x-text="entry.method"></span>
                                <span x-text="entry.url"></span>
                            </div>

                            {{-- Extra context --}}
                            <template x-if="hasContext(entry.context)">
                                <pre class="mt-2 p-3 rounded-lg bg-surface-muted border border-border text-[11px] font-mono text-ink-secondary overflow-x-auto whitespace-pre-wrap break-words"
                                     x-text="formatContext(entry.context)"></pre>
                            </template>
                        </article>
                    </template>
                </div>
            </section>
        </div>
    </div>

    <script>
        function logViewer(files, entries, selected) {
            return {
                files: files || [],
                entries: entries || [],
                selected: selected || null,

                hasContext(context) {
                    return !!context
                        && typeof context === 'object'
                        && !Array.isArray(context)
                        && Object.keys(context).length > 0;
                },

                formatContext(context) {
                    try {
                        return JSON.stringify(context, null, 2);
                    } catch (error) {
                        return String(context);
                    }
                },
            };
        }
    </script>
</x-app-layout>

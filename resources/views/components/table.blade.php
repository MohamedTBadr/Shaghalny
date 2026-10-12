@props(['headers', 'actions' => true])

<div class="overflow-hidden bg-surface border border-border rounded-xl shadow-card">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-border text-left">
            <thead>
                <tr class="bg-surface-subtle/80 border-b border-border">
                    @foreach($headers as $header)
                        <th scope="col" class="px-6 py-3.5 text-xs font-semibold text-ink-secondary uppercase tracking-wider">
                            {{ $header }}
                        </th>
                    @endforeach
                    @if($actions)
                        <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold text-ink-secondary uppercase tracking-wider">
                            Actions
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-border bg-surface text-sm text-ink-primary font-normal">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
 

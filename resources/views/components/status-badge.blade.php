@props(['status', 'size' => 'sm'])

@php
    $map = [
        // Job application statuses (schema enum)
        'Pending'   => ['warning', 'Under review'],
        'Accepted'  => ['success', 'Accepted'],
        'Rejected'  => ['danger', 'Rejected'],
        // Job vacancy lifecycle
        'Open'      => ['success', 'Open'],
        'Active'    => ['success', 'Active'],
        'Published' => ['success', 'Published'],
        'Closed'    => ['neutral', 'Closed'],
        'Draft'     => ['neutral', 'Draft'],
        'Archived'  => ['neutral', 'Archived'],
        'Expired'   => ['warning', 'Expired'],
        // Employment types
        'Full-Time' => ['brand', 'Full-Time'],
        'Part-Time' => ['info', 'Part-Time'],
        'Remote'    => ['success', 'Remote'],
        'Hybrid'    => ['info', 'Hybrid'],
        'Contract'  => ['warning', 'Contract'],
        'Freelance' => ['neutral', 'Freelance'],
        'Internship'=> ['purple', 'Internship'],
    ];

    [$variant, $label] = $map[$status] ?? ['neutral', $status];
@endphp

<x-badge :variant="$variant" :size="$size">
    @if(in_array($status, ['Pending', 'Accepted', 'Rejected']))
        <span class="w-1.5 h-1.5 rounded-full {{ \Illuminate\Support\Str::of($variant) == 'danger' ? 'bg-accent-danger' : (\Illuminate\Support\Str::of($variant) == 'success' ? 'bg-accent-success' : 'bg-accent-warning') }}"></span>
    @endif
    {{ $label }}
</x-badge>
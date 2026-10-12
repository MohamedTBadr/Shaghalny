<x-app-seeker>
    <x-slot name="header">
        <x-page-header title="Resume Management"
                       description="Upload the PDF used when applying for roles. It is only shared with an employer when you apply to one of their vacancies." />
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">
        @if(session('success'))
            <div class="mb-6">
                <x-alert variant="success" dismissible>{{ session('success') }}</x-alert>
            </div>
        @endif

        @if($errors->has('resume_file'))
            <div class="mb-6">
                <x-alert variant="danger" dismissible>{{ $errors->first('resume_file') }}</x-alert>
            </div>
        @endif

        @if(auth()->user()->resumes->count() === 0)
            <div class="mb-8">
                <x-alert variant="info">
                    <strong>Getting started:</strong> Add a resume now so applying to a job takes only a single click.
                </x-alert>
            </div>
        @endif

        <!-- Upload card -->
        <form action="{{ route('resumes.store') }}" method="POST" enctype="multipart/form-data"
              x-data="{ dragging: false, fileName: '' }"
              class="bg-surface border border-border rounded-2xl shadow-card p-8 mb-10">
            @csrf

            <label
                for="resume_file"
                @dragover.prevent="dragging = true"
                @dragleave.prevent="dragging = false"
                @drop.prevent="dragging = false"
                :class="dragging ? 'border-brand bg-brand-subtle/50' : 'border-dashed border-border'"
                class="block border-2 rounded-xl p-10 text-center cursor-pointer transition-colors hover:border-brand/50 hover:bg-surface-subtle/40"
            >
                <div class="mx-auto w-12 h-12 rounded-xl bg-brand-subtle text-brand flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                </div>
                <p class="font-semibold text-ink-primary text-sm">
                    <span x-show="!fileName" class="inline">Drag and drop your PDF, or <span class="text-brand">browse</span></span>
                    <span x-show="fileName" class="inline" x-text="fileName"></span>
                </p>
                <p class="text-xs text-ink-muted mt-1.5">PDF up to 10 MB</p>
                <input
                    id="resume_file"
                    name="resume_file"
                    type="file"
                    accept="application/pdf"
                    class="sr-only"
                    @change="fileName = $event.target.files[0]?.name || ''"
                    required
                >
            </label>

            <div class="mt-6 flex items-center justify-center">
                <x-button variant="primary" type="submit" class="text-sm">
                    <span>Upload resume</span>
                </x-button>
            </div>
        </form>

        <!-- Resume list -->
        @if($resumes->count() > 0)
            <div class="space-y-3">
                @foreach($resumes as $resume)
                    <div class="bg-surface border border-border rounded-xl shadow-subtle p-5 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="w-10 h-10 rounded-lg bg-accent-danger-subtle text-accent-danger flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-sm text-ink-primary truncate">{{ $resume->file_name }}</p>
                                <p class="text-xs text-ink-muted mt-0.5">
                                    Uploaded {{ $resume->created_at->format('M d, Y') }} &bull; used in {{ $resume->jobApplications()->count() }} {{ Str::plural('application', $resume->jobApplications()->count()) }}
                                </p>
                                @if($resume->skills)
                                    <p class="text-xs text-ink-muted mt-1 truncate"><span class="font-medium text-ink-secondary">Parsed skills:</span> {{ Str::limit($resume->skills, 120) }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ route('resumes.download', $resume->id) }}" class="btn-secondary text-xs">
                                <span>Download</span>
                            </a>
                            <form action="{{ route('resumes.destroy', $resume->id) }}" method="POST"
                                  onsubmit="return confirm('Delete this resume? Applications already submitted are not affected.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger-outline text-xs">
                                    <span>Delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <p class="text-xs text-ink-muted mt-5">
                Latest resume is used as the default when applying. You may upload as many as you need for different job types.
            </p>
        @else
            <x-empty-state
                icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>'
                title="No resumes uploaded yet"
                description="Upload your first resume above and it will be ready to use when you apply." />
        @endif
    </div>
</x-app-seeker>

<x-dynamic-component :component="'app-seeker'">
    <div class="min-h-screen bg-surface">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 py-10">

            {{-- Back link --}}
            <a
                href="{{ route('job-vacancies.show', $jobVacancy->id) }}"
                class="inline-flex items-center gap-1.5 text-sm font-semibold text-ink-secondary hover:text-brand transition-colors mb-8 group"
                id="back-to-job-btn"
            >
                <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Job Details
            </a>

            {{-- Job summary card --}}
            <div class="bg-surface border border-border rounded-2xl px-6 py-5 mb-8">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-brand-subtle text-brand flex items-center justify-center text-lg font-black border border-brand/10 shrink-0">
                        {{ substr($jobVacancy->company->name ?? 'C', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h1 class="text-lg font-extrabold text-ink-primary font-display tracking-tight">{{ $jobVacancy->title }}</h1>
                        <p class="text-sm text-ink-secondary font-medium mt-0.5">{{ $jobVacancy->company->name ?? '' }}</p>
                        <div class="flex items-center gap-3 mt-2 flex-wrap">
                            @if($jobVacancy->location)
                                <span class="text-xs text-ink-muted flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $jobVacancy->location }}
                                </span>
                            @endif
                            @if($jobVacancy->salary)
                                <span class="text-xs font-semibold text-ink-secondary">${{ number_format($jobVacancy->salary) }}/yr</span>
                            @endif
                            @if($jobVacancy->type)
                                <x-badge variant="brand">{{ $jobVacancy->type }}</x-badge>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Application form --}}
            <div class="bg-surface border border-border rounded-2xl overflow-hidden" id="application-form-card">
                <div class="px-6 py-5 border-b border-border">
                    <h2 class="text-base font-extrabold text-ink-primary font-display">Submit Your Application</h2>
                    <p class="text-xs text-ink-secondary mt-0.5">Choose a resume below. Our AI will evaluate your fit for this role.</p>
                </div>

                @if($errors->any())
                    <div class="mx-6 mt-4 bg-accent-danger-subtle border border-accent-danger/25 text-accent-danger-strong px-4 py-3 rounded-xl text-sm" id="form-errors">
                        <p class="font-semibold mb-1">Please fix the following:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    enctype="multipart/form-data"
                    action="{{ route('job-vacancies.process-application', $jobVacancy->id) }}"
                    method="POST"
                    class="px-6 pb-6 pt-5 space-y-6"
                    id="apply-form"
                >
                    @csrf

                    {{-- Existing resumes --}}
                    @if($resumes->isNotEmpty())
                        <fieldset>
                            <legend class="block text-sm font-bold text-ink-primary mb-3">Select an existing resume</legend>
                            <div class="space-y-2">
                                @foreach($resumes as $resume)
                                    <label
                                        for="resume-{{ $resume->id }}"
                                        class="flex items-center gap-3 px-4 py-3 rounded-xl border border-border cursor-pointer hover:border-brand hover:bg-brand-subtle/30 transition-all has-[:checked]:border-brand has-[:checked]:bg-brand-subtle/40"
                                        id="resume-label-{{ $loop->iteration }}"
                                    >
                                        <input
                                            type="radio"
                                            name="resume_option"
                                            id="resume-{{ $resume->id }}"
                                            value="{{ $resume->id }}"
                                            class="accent-brand"
                                        >
                                        <div class="flex items-center gap-2 flex-1 min-w-0">
                                            <svg class="w-4 h-4 text-ink-muted shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            <span class="text-sm font-semibold text-ink-primary truncate">{{ $resume->file_name }}</span>
                                        </div>
                                        <span class="text-xs text-ink-muted shrink-0">Updated {{ $resume->updated_at->format('M d, Y') }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>

                        <div class="flex items-center gap-3 text-xs text-ink-muted">
                            <div class="flex-1 border-t border-border"></div>
                            <span class="font-medium">or upload a new one</span>
                            <div class="flex-1 border-t border-border"></div>
                        </div>
                    @endif

                    {{-- Upload new resume --}}
                    <div x-data="{ fileName: '', dragging: false }">
                        <div class="flex items-center gap-3 mb-3">
                            <input
                                x-ref="newResumeRadio"
                                type="radio"
                                name="resume_option"
                                id="new_resume"
                                value="new_resume"
                                class="accent-brand"
                            >
                            <label for="new_resume" class="text-sm font-bold text-ink-primary cursor-pointer">Upload a new Resume</label>
                        </div>

                        <label
                            for="resume_file"
                            @dragover.prevent="dragging = true"
                            @dragleave.prevent="dragging = false"
                            @drop.prevent="
                                dragging = false;
                                let file = $event.dataTransfer.files[0];
                                if(file) { fileName = file.name; $refs.newResumeRadio.checked = true; }
                            "
                            :class="dragging ? 'border-brand bg-brand-subtle/40' : (fileName ? 'border-brand bg-brand-subtle/20' : 'border-border bg-surface-subtle hover:border-brand/50 hover:bg-brand-subtle/10')"
                            class="flex flex-col items-center justify-center gap-3 px-6 py-10 rounded-2xl border-2 border-dashed cursor-pointer transition-all"
                            id="resume-upload-zone"
                        >
                            <input
                                type="file"
                                name="resume_file"
                                id="resume_file"
                                @change="fileName = $event.target.files[0].name; $refs.newResumeRadio.checked = true"
                                class="hidden"
                                accept=".pdf"
                            >

                            <template x-if="!fileName">
                                <div class="text-center">
                                    <div class="w-10 h-10 rounded-xl bg-surface border border-border shadow-subtle flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-5 h-5 text-ink-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-ink-primary">Drag & drop or click to upload</p>
                                    <p class="text-xs text-ink-muted mt-1">PDF only · Max 5 MB</p>
                                </div>
                            </template>
                            <template x-if="fileName">
                                <div class="text-center">
                                    <div class="w-10 h-10 rounded-xl bg-brand-subtle border border-brand/20 flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-brand" x-text="fileName"></p>
                                    <p class="text-xs text-ink-muted mt-1">Click to change file</p>
                                </div>
                            </template>
                        </label>
                        @error('resume_file')
                            <p class="text-xs text-accent-danger mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="btn btn-primary w-full py-3.5 text-sm font-bold flex items-center justify-center gap-2"
                        id="submit-application-btn"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Submit Application
                    </button>

                    <p class="text-center text-xs text-ink-muted">
                        Your application will be evaluated by our AI model instantly.
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-dynamic-component>

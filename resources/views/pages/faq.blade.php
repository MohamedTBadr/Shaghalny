<x-main-layout title="Frequently Asked Questions — Shaghalny">
    <div class="container-page py-10 sm:py-14">
        <x-breadcrumbs :items="[['label' => 'FAQ']]" />

        <div class="mt-8 max-w-3xl">
            <h1 class="text-heading-page font-extrabold text-ink-primary">Frequently asked questions</h1>
            <p class="mt-3 text-body-lg text-ink-secondary leading-relaxed">
                Everything you need to know about searching, applying, and hiring on Shaghalny.
            </p>
        </div>

        <div class="mt-10 max-w-3xl space-y-4" x-data="{ open: null }">
            @php
                $faqs = [
                    'How do I create an account?' => 'Choose "Create Account" from the header, pick whether you are a candidate starting your job search or an employer looking to hire, fill in your details, and confirm your email. You are ready to browse within a minute.',
                    'Is it free to apply to jobs?' => 'Yes. Applying for vacancies and tracking your applications on Shaghalny is completely free for candidates. The AI resume fit score is included at no cost.',
                    'How does the AI resume fit score work?' => 'When you apply, your uploaded PDF resume is parsed and compared against the vacancy requirements. The result is a structured score with a short analysis of the strongest matches and any gaps, which is shared with you on your application page.',
                    'How do employers receive my resume?' => 'Your resume is only shared with an employer when you actively submit an application for one of their vacancies. It is never shown in a public directory.',
                    'How can I track my application status?' => 'From the Candidate Workspace, open My Applications. Each application shows a timeline with every status change: under review, accepted, or rejected, along with any feedback the employer left.',
                    'How much does it cost to post a job?' => 'Posting vacancies is free on Shaghalny. Employers get an application pipeline with AI scoring included.',
                    'How do I update my resume?' => 'Go to your Candidate Workspace, open Resume, and upload a new PDF. The new version is used for any future applications you submit.',
                    'Can a company owner manage multiple companies?' => 'Each employer account is linked to a single company profile. For additional companies, contact us and we will set up the appropriate access.',
                    'What happens to my data if I close my account?' => 'Closing your account removes your profile and resume from the platform. Applications you submitted are anonymized so employers can still comply with their records. See our Privacy Policy for details.',
                ];
            @endphp

            @foreach($faqs as $question => $answer)
                <div class="surface-card overflow-hidden">
                    <button type="button"
                            @click="open = open === {{ $loop->index }} ? null : {{ $loop->index }}"
                            class="w-full flex items-center justify-between gap-4 px-5 sm:px-6 py-4 text-left">
                        <span class="font-semibold text-sm sm:text-base text-ink-primary">{{ $question }}</span>
                        <span class="shrink-0 w-6 h-6 rounded-full bg-surface-muted text-ink-muted flex items-center justify-center transition-transform duration-200"
                              :class="open === {{ $loop->index }} ? 'rotate-45' : ''">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        </span>
                    </button>
                    <div x-show="open === {{ $loop->index }}" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         class="px-5 sm:px-6 pb-5 -mt-0.5">
                        <p class="text-sm text-ink-secondary leading-relaxed">{{ $answer }}</p>
                    </div>
                </div>
            @endforeach

            <div class="rounded-2xl bg-brand-900 text-white p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-8">
                <div>
                    <h3 class="font-bold text-heading-card">Still have questions?</h3>
                    <p class="text-sm text-brand-100 mt-1">Our team usually replies within two business days.</p>
                </div>
                <a href="{{ route('pages.contact') }}" class="btn bg-white text-brand hover:bg-brand-50 font-semibold text-sm shrink-0">
                    Contact support
                </a>
            </div>
        </div>
    </div>
</x-main-layout>
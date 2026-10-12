<x-main-layout title="About Shaghalny">
    <div class="container-page py-10 sm:py-14">
        <x-breadcrumbs :items="[['label' => 'About']]" />

        <div class="mt-8 max-w-3xl">
            <h1 class="text-heading-page font-extrabold text-ink-primary">About Shaghalny</h1>
            <p class="mt-3 text-body-lg text-ink-secondary leading-relaxed">
                Shaghalny (شغّلني — "hire me") is an editorial-grade recruitment platform connecting
                ambitious candidates with verified employers across the MENA region and beyond.
            </p>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="surface-card p-6">
                <div class="w-10 h-10 rounded-xl bg-brand-subtle text-brand flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-heading-card font-bold text-ink-primary">Verified listings</h3>
                <p class="mt-2 text-sm text-ink-secondary leading-relaxed">
                    Every company is checked before their roles go live. No scraped listings, no expired postings living in the archive.
                </p>
            </div>

            <div class="surface-card p-6">
                <div class="w-10 h-10 rounded-xl bg-accent-info-subtle text-accent-info flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-heading-card font-bold text-ink-primary">Transparent pipeline</h3>
                <p class="mt-2 text-sm text-ink-secondary leading-relaxed">
                    Every application gets a real status. No ghosting: track your application from submission to an employer decision.
                </p>
            </div>

            <div class="surface-card p-6">
                <div class="w-10 h-10 rounded-xl bg-accent-success-subtle text-accent-success flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                </div>
                <h3 class="text-heading-card font-bold text-ink-primary">AI resume fit scoring</h3>
                <p class="mt-2 text-sm text-ink-secondary leading-relaxed">
                    Upload your resume once. Our pipeline extracts your skills and produces a structured fit analysis with honest, actionable feedback.
                </p>
            </div>
        </div>

        <div class="mt-14 surface-card p-8 sm:p-10">
            <h2 class="text-heading-section font-bold text-ink-primary">Our promise</h2>
            <div class="mt-4 prose-content">
                <p>
                    Recruitment should not be a black box. Shaghalny was built on three principles:
                </p>
                <ul>
                    <li><strong>Honest metrics.</strong> The numbers you see on this site are computed from real data, never fabricated for marketing.</li>
                    <li><strong>Candidate-first privacy.</strong> Your resume is only shared with an employer when you apply to their vacancy.</li>
                    <li><strong>Clarity over clutter.</strong> A focused interface—no dark patterns, no forced upgrades, no paywalls on core features.</li>
                </ul>
                <p>
                    Whether you are taking your first step or your next big leap, Shaghalny is designed to get you there faster and with full visibility.
                </p>
            </div>
        </div>
    </div>
</x-main-layout>
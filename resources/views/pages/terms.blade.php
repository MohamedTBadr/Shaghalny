<x-main-layout title="Terms of Service — Shaghalny">
    <div class="container-page py-10 sm:py-14">
        <x-breadcrumbs :items="[['label' => 'Terms of Service']]" />

        <div class="mt-8 max-w-3xl">
            <h1 class="text-heading-page font-extrabold text-ink-primary">Terms of Service</h1>
            <p class="mt-2 text-sm text-ink-muted">Last updated: January 2025</p>

            <div class="mt-8 prose-content">
                <p>
                    These terms govern your use of the Shaghalny recruitment platform ("the Service"). By creating an account, you agree to these terms.
                </p>

                <h2>1. Accounts and eligibility</h2>
                <ul>
                    <li>You must be at least 16 years old to use the Service.</li>
                    <li>You are responsible for keeping your credentials secure and for everything done with your account.</li>
                    <li>One individual account per person. Employers operate a single company workspace.</li>
                </ul>

                <h2>2. Candidate responsibilities</h2>
                <ul>
                    <li>You are responsible for the accuracy of the information and resume you submit.</li>
                    <li>Only upload resumes you have the right to share.</li>
                    <li>Do not misrepresent your identity, experience, or qualifications.</li>
                </ul>

                <h2>3. Employer responsibilities</h2>
                <ul>
                    <li>Vacancies must be genuine openings; no bait listings designed to collect resumes without an active hiring intent.</li>
                    <li>You may only process applications through the tools provided.</li>
                    <li>You must not use the Service to discriminate on grounds prohibited by applicable law.</li>
                </ul>

                <h2>4. Prohibited conduct</h2>
                <ul>
                    <li>Scraping the platform or harvesting other users' data without permission.</li>
                    <li>Posting unlawful, fraudulent, misleading, or infringing content.</li>
                    <li>Attempting to disrupt, overload, or gain unauthorized access to the Service.</li>
                    <li>Impersonating another person or organization.</li>
                </ul>

                <h2>5. Content and licenses</h2>
                <p>
                    You retain ownership of content you submit. You grant the Service a limited license to store, process, and display that content strictly to operate the platform — for example, sharing your resume with the employer you applied to.
                </p>

                <h2>6. Termination</h2>
                <p>
                    You may close your account at any time. We may suspend or close accounts that violate these terms, subject to applicable law. Closing an account does not erase an employer's lawful records of applications they received.
                </p>

                <h2>7. Limitations of liability &amp; disclaimers</h2>
                <p>
                    The Service is provided "as is" without warranties of any kind. We are not a party to any hiring decision, and we are not liable for the actions of employers or candidates on the platform. Automated resume fit scores are advisory and do not guarantee outcomes.
                </p>

                <h2>8. Changes to these terms</h2>
                <p>
                    We may update these terms from time to time. Material changes will be announced within the Service. Continued use after changes take effect means acceptance of the updated terms.
                </p>

                <h2>9. Contact</h2>
                <p>
                    Questions? Reach us at <a href="{{ route('pages.contact') }}">support@shaghalny.com</a>.
                </p>
            </div>
        </div>
    </div>
</x-main-layout>
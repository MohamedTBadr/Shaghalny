<x-main-layout title="Privacy Policy — Shaghalny">
    <div class="container-page py-10 sm:py-14">
        <x-breadcrumbs :items="[['label' => 'Privacy Policy']]" />

        <div class="mt-8 max-w-3xl">
            <h1 class="text-heading-page font-extrabold text-ink-primary">Privacy Policy</h1>
            <p class="mt-2 text-sm text-ink-muted">Last updated: January 2025</p>

            <div class="mt-8 prose-content">
                <p>
                    This policy explains what information Shaghalny collects, why we collect it, and the choices you have over your data.
                </p>

                <h2>1. Information we collect</h2>
                <p>We collect information you provide directly, including:</p>
                <ul>
                    <li>Account details: name and email address.</li>
                    <li>Profile information: your industry, location, and work preferences when you complete your profile.</li>
                    <li>Resumes: the PDF you upload when applying for a vacancy.</li>
                    <li>Application data: the vacancies you apply to and your status through their review process.</li>
                    <li>Employer data: company information shared while creating an employer account.</li>
                    <li>Contact messages: if you reach out, we retain your message and reply thread.</li>
                </ul>

                <h2>2. How we use your information</h2>
                <ul>
                    <li>To operate your account and match you with relevant vacancies.</li>
                    <li>To share your resume and application with a specific employer when you apply to one of their roles.</li>
                    <li>To run the automated resume fit analysis that produces your match score and feedback.</li>
                    <li>To improve the platform through anonymized usage analytics.</li>
                    <li>To respond to support requests.</li>
                </ul>

                <h2>3. When we share your information</h2>
                <p>
                    Your resume and application materials are shared with the employer who owns the vacancy you applied to — and only them, and only after you take the action to apply. We do not sell personal data, and we do not show your resume in any public directory.
                </p>

                <h2>4. Data retention</h2>
                <p>
                    Your resume is retained while your account is active and for as long as you may wish to apply to further roles, which you can delete at any time. After account closure, applications are anonymized in employer records. Employer-facilitated records follow their own retention obligations.
                </p>

                <h2>5. Your rights</h2>
                <ul>
                    <li>Access and correct your data from your profile settings.</li>
                    <li>Delete your resume from Resume Management at any time.</li>
                    <li>Close your account from Profile, which removes your profile and resume.</li>
                    <li>Contact us to request data export or erasure.</li>
                </ul>

                <h2>6. Security</h2>
                <p>
                    We use encrypted connections, password hashing, and least-privilege access to keep your data safe. No method of transmission is 100% secure, but we follow industry best practice.
                </p>

                <h2>7. Contact</h2>
                <p>
                    Questions about this policy or your data? Reach us at <a href="{{ route('pages.contact') }}">support@shaghalny.com</a>.
                </p>
            </div>
        </div>
    </div>
</x-main-layout>
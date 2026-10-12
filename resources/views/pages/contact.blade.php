<x-main-layout title="Contact Us — Shaghalny">
    <div class="container-page py-10 sm:py-14">
        <x-breadcrumbs :items="[['label' => 'Contact']]" />

        <div class="mt-8 grid grid-cols-1 lg:grid-cols-5 gap-10 items-start">
            <div class="lg:col-span-3">
                <h1 class="text-heading-page font-extrabold text-ink-primary">Contact support</h1>
                <p class="mt-3 text-body text-ink-secondary leading-relaxed max-w-xl">
                    Questions about an application, a vacancy, or your account? Drop us a message and the team will get back to you.
                </p>

                @if(session('success'))
                    <div class="mt-6">
                        <x-alert variant="success" dismissible>
                            {{ session('success') }}
                        </x-alert>
                    </div>
                @endif

                <form action="{{ route('pages.contact.store') }}" method="POST" class="mt-8 space-y-5 max-w-xl">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <x-field label="Your name" for="name" required :error="$errors->first('name')">
                            <x-input id="name" name="name" type="text" :value="old('name', auth()->user()->name ?? '')" required autocomplete="name" placeholder="Jane Smith" />
                        </x-field>

                        <x-field label="Email address" for="email" required :error="$errors->first('email')">
                            <x-input id="email" name="email" type="email" :value="old('email', auth()->user()->email ?? '')" required autocomplete="email" placeholder="jane@example.com" />
                        </x-field>
                    </div>

                    <x-field label="Subject" for="subject" required :error="$errors->first('subject')">
                        <x-select id="subject" name="subject" required :error="$errors->has('subject')">
                            <option value="" disabled {{ old('subject') ? '' : 'selected' }}>Select a topic...</option>
                            @foreach([
                                'General question',
                                'I need help with my application',
                                'I need help with my account',
                                'Employer: help with a vacancy',
                                'Report a problem',
                                'Media / partnerships',
                            ] as $topic)
                                <option value="{{ $topic }}" {{ old('subject') === $topic ? 'selected' : '' }}>{{ $topic }}</option>
                            @endforeach
                        </x-select>
                    </x-field>

                    <x-field label="Message" for="message" required :error="$errors->first('message')">
                        <x-textarea id="message" name="message" rows="6" required placeholder="Tell us how we can help..." />
                    </x-field>

                    <div class="flex items-center gap-3">
                        <x-button variant="primary" type="submit" class="text-sm">Send message</x-button>
                        <span class="text-xs text-ink-muted">Replies within 2 business days</span>
                    </div>
                </form>
            </div>

            <aside class="lg:col-span-2 space-y-6">
                <div class="surface-card p-6">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-ink-primary mb-4">Direct channels</h3>
                    <ul class="space-y-4 text-sm">
                        <li>
                            <p class="font-semibold text-ink-primary">Email</p>
                            <p class="text-ink-secondary mt-0.5">support@shaghalny.com</p>
                        </li>
                        <li>
                            <p class="font-semibold text-ink-primary">Employer onboarding</p>
                            <p class="text-ink-secondary mt-0.5">employers@shaghalny.com</p>
                        </li>
                        <li>
                            <p class="font-semibold text-ink-primary">Headquarters</p>
                            <p class="text-ink-secondary mt-0.5">Cairo, Egypt &bull; Remote-first team</p>
                        </li>
                    </ul>
                </div>

                <div class="surface-card p-6">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-ink-primary mb-4">Before you write</h3>
                    <p class="text-sm text-ink-secondary leading-relaxed">
                        Most common questions are answered in our FAQ, including how AI scoring works and how employers receive your resume.
                    </p>
                    <a href="{{ route('pages.faq') }}" class="mt-4 inline-flex items-center gap-1.5 text-sm font-medium text-brand hover:underline">
                        Browse the FAQ
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </aside>
        </div>
    </div>
</x-main-layout>
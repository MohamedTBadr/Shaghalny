<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-surface-subtle">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">
    <meta name="theme-color" content="#3157D5">

    <title>{{ $title ?? 'Shaghalny — Modern Job Discovery & Recruitment' }}</title>
    <meta name="description" content="Discover top verified career opportunities, connect with innovative companies, and manage your applications on Shaghalny.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet" />

    <!-- Alpine.js Cloak -->
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('layouts.partials.theme')
</head>

<body class="min-h-full flex flex-col bg-surface-subtle text-ink-primary font-sans antialiased selection:bg-brand selection:text-white">

    <!-- Top Announcement Bar -->
    <div class="bg-brand-900 text-brand-100 text-xs py-2 px-4 text-center font-medium border-b border-brand-800 flex items-center justify-center gap-2">
        <span class="bg-brand-500 text-white text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">AI Powered</span>
        <span>Intelligent resume parsing and automated match scoring is now live for all candidates and recruiters.</span>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-40 bg-surface/95 backdrop-blur-md border-b border-border shadow-subtle transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <!-- Brand Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <x-application-logo class="w-9 h-9 group-hover:scale-105 transition-transform" />
                        <div class="flex flex-col">
                            <span class="text-xl font-extrabold tracking-tight text-ink-primary font-display flex items-center gap-1">
                                Shaghalny
                                <span class="w-1.5 h-1.5 rounded-full bg-brand"></span>
                            </span>
                            <span class="text-[10px] text-ink-muted -mt-1 font-medium tracking-wide uppercase">Recruitment Platform</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Nav Links -->
                <nav class="hidden lg:flex items-center gap-1 text-sm font-medium text-ink-secondary">
                    @foreach([
                        ['label' => 'Explore Jobs', 'route' => 'jobs.index'],
                        ['label' => 'Companies', 'route' => 'companies.index'],
                        ['label' => 'Categories', 'route' => 'categories.index'],
                        ['label' => 'About', 'route' => 'pages.about'],
                    ] as $nav)
                        <a href="{{ route($nav['route']) }}" class="px-3 py-2 rounded-lg hover:text-brand hover:bg-surface-muted transition-colors">{{ $nav['label'] }}</a>
                    @endforeach
                </nav>

                <!-- Right Actions -->
                <div class="flex items-center gap-2">
                    @auth
                        @if(auth()->user()->role === 'job_seeker')
                            <a href="{{ route('dashboard') }}" class="hidden sm:inline-flex btn-secondary text-xs sm:text-sm">
                                Candidate Workspace
                            </a>
                            <a href="{{ route('job-applications.index') }}" class="hidden md:inline-flex btn-subtle text-xs sm:text-sm">
                                My Applications
                            </a>
                        @else
                            <a href="{{ route('backoffice.dashboard') }}" class="hidden sm:inline-flex btn-primary text-xs sm:text-sm">
                                Back-Office Portal
                            </a>
                        @endif

                        <!-- Simple User menu trigger -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" type="button" class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-surface-muted transition-colors">
                                <div class="w-8 h-8 rounded-full bg-brand-subtle text-brand font-bold text-xs flex items-center justify-center border border-brand/20">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="hidden sm:inline-block text-xs font-semibold text-ink-primary">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-ink-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>

                            <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-surface border border-border rounded-xl shadow-dropdown py-1.5 z-50 text-xs font-medium">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-ink-secondary hover:bg-surface-subtle hover:text-ink-primary">Profile Settings</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-accent-danger hover:bg-accent-danger-subtle">Log Out</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-ink-secondary hover:text-brand px-3 py-2 rounded-lg transition-colors">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary text-xs sm:text-sm">
                            Create Account
                        </a>
                    @endauth

                    <!-- Theme toggle -->
                    <x-theme-toggle />

                    <!-- Mobile menu toggle -->
                    <button @click="mobileOpen = !mobileOpen" type="button" class="lg:hidden p-2 rounded-lg text-ink-secondary hover:bg-surface-muted hover:text-ink-primary transition-colors" aria-label="Menu" x-data>
                        <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile nav panel -->
        <div x-data="{ mobileOpen: false }" x-show="mobileOpen" x-cloak class="lg:hidden border-t border-border bg-surface px-4 py-4 space-y-1">
            @foreach([
                ['label' => 'Explore Jobs', 'route' => 'jobs.index'],
                ['label' => 'Companies', 'route' => 'companies.index'],
                ['label' => 'Categories', 'route' => 'categories.index'],
                ['label' => 'About', 'route' => 'pages.about'],
                ['label' => 'FAQ', 'route' => 'pages.faq'],
                ['label' => 'Contact', 'route' => 'pages.contact'],
            ] as $nav)
                <a href="{{ route($nav['route']) }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-ink-secondary hover:text-brand hover:bg-surface-muted transition-colors">
                    {{ $nav['label'] }}
                </a>
            @endforeach

            @auth
                <div class="pt-2 border-t border-border flex flex-col gap-2 mt-2">
                    <a href="{{ auth()->user()->role === 'job_seeker' ? route('dashboard') : route('backoffice.dashboard') }}" class="btn-primary text-sm justify-center">
                        {{ auth()->user()->role === 'job_seeker' ? 'Candidate Workspace' : 'Back-Office Portal' }}
                    </a>
                    <a href="{{ route('profile.edit') }}" class="btn-secondary text-sm justify-center">Profile Settings</a>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full btn-danger-outline text-sm justify-center">Log Out</button>
                    </form>
                </div>
            @else
                <div class="pt-2 border-t border-border flex flex-col gap-2 mt-2">
                    <a href="{{ route('login') }}" class="btn-secondary text-sm justify-center">Sign In</a>
                    <a href="{{ route('register') }}" class="btn-primary text-sm justify-center">Create Account</a>
                </div>
            @endauth
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Premium Editorial Footer -->
    <footer class="bg-surface border-t border-border mt-20 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-10 pb-12 border-b border-border">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <x-application-logo class="w-8 h-8" />
                        <span class="text-lg font-bold tracking-tight text-ink-primary font-display">Shaghalny</span>
                    </div>
                    <p class="text-sm text-ink-secondary max-w-sm leading-relaxed mb-6">
                        The next-generation recruitment network connecting high-growth enterprises with world-class engineering, design, and operational talent.
                    </p>
                    <div class="flex items-center gap-3 text-xs text-ink-muted">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-accent-success-subtle text-accent-success-strong border border-accent-success/25 font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Platform Operational
                        </span>
                        <span>SOC2 Compliant</span>
                    </div>
                </div>

                <div>
                    <h5 class="text-xs font-bold uppercase tracking-wider text-ink-primary mb-4 font-display">Job Seekers</h5>
                    <ul class="space-y-2.5 text-sm text-ink-secondary">
                        <li><a href="{{ route('jobs.index') }}" class="hover:text-brand transition-colors">Browse Vacancies</a></li>
                        <li><a href="{{ route('categories.index') }}" class="hover:text-brand transition-colors">Job Categories</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-brand transition-colors">Create Candidate Profile</a></li>
                        <li><a href="{{ route('pages.faq') }}" class="hover:text-brand transition-colors">How AI Resume Matching Works</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-xs font-bold uppercase tracking-wider text-ink-primary mb-4 font-display">Employers</h5>
                    <ul class="space-y-2.5 text-sm text-ink-secondary">
                        <li><a href="{{ route('register') }}" class="hover:text-brand transition-colors">Post a Vacancy</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-brand transition-colors">Applicant Tracking System</a></li>
                        <li><a href="{{ route('companies.index') }}" class="hover:text-brand transition-colors">Employer Directory</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="hover:text-brand transition-colors">Talk to Sales</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-xs font-bold uppercase tracking-wider text-ink-primary mb-4 font-display">Platform</h5>
                    <ul class="space-y-2.5 text-sm text-ink-secondary">
                        <li><a href="{{ route('pages.about') }}" class="hover:text-brand transition-colors">About Shaghalny</a></li>
                        <li><a href="{{ route('pages.faq') }}" class="hover:text-brand transition-colors">FAQ</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="hover:text-brand transition-colors">Contact Us</a></li>
                        <li><a href="{{ route('pages.privacy') }}" class="hover:text-brand transition-colors">Privacy Policy</a></li>
                        <li><a href="{{ route('pages.terms') }}" class="hover:text-brand transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-ink-muted gap-4">
                <p>&copy; {{ date('Y') }} Shaghalny Platform Inc. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <span>Cairo &bull; Dubai &bull; Riyadh &bull; Remote</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
 

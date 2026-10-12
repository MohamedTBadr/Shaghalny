<nav x-data="{ open: false }" class="bg-surface border-b border-border shadow-subtle sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-6">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
                        <x-application-logo class="w-8 h-8 group-hover:scale-105 transition-transform" />
                        <span class="text-lg font-extrabold text-ink-primary font-display tracking-tight">Shaghalny</span>
                        <span class="hidden sm:inline text-[10px] uppercase font-bold text-brand bg-brand-subtle px-2 py-0.5 rounded-full border border-brand/20">Candidate</span>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('dashboard') ? 'bg-brand text-accent-contrast shadow-subtle' : 'text-ink-secondary hover:text-ink-primary hover:bg-surface-subtle' }}">
                        Overview
                    </a>

                    <a href="{{ route('jobs.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs(['jobs.index', 'job-vacancies.*']) ? 'bg-brand text-accent-contrast shadow-subtle' : 'text-ink-secondary hover:text-ink-primary hover:bg-surface-subtle' }}">
                        Explore Jobs
                    </a>

                    <a href="{{ route('job-applications.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('job-applications.*') ? 'bg-brand text-accent-contrast shadow-subtle' : 'text-ink-secondary hover:text-ink-primary hover:bg-surface-subtle' }}">
                        Applications
                    </a>

                    <a href="{{ route('saved-jobs.index') }}" class="px-3 py-2 rounded-lg text-sm font-semibold transition-colors {{ request()->routeIs('saved-jobs.*') ? 'bg-brand text-accent-contrast shadow-subtle' : 'text-ink-secondary hover:text-ink-primary hover:bg-surface-subtle' }}">
                        Saved Jobs
                        @if(auth()->user()->savedJobs()->count() > 0)
                            <span class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-bold {{ request()->routeIs('saved-jobs.*') ? 'bg-accent-contrast/20 text-accent-contrast' : 'bg-brand text-accent-contrast' }}">
                                {{ auth()->user()->savedJobs()->count() }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-ink-secondary hover:text-brand hover:bg-surface-subtle transition-colors">
                        Public Board &nearr;
                    </a>

                    @if(in_array(auth()->user()->role, ['admin', 'company_owner']))
                        <a href="{{ route('backoffice.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-semibold text-brand hover:bg-brand-subtle transition-colors">
                            Back-Office &rarr;
                        </a>
                    @endif
                </div>
            </div>

            <!-- Desktop User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:gap-2">
                <x-theme-toggle />
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2.5 px-3 py-2 border border-border text-xs font-semibold rounded-xl text-ink-primary bg-surface hover:bg-surface-subtle focus:outline-none focus:ring-2 focus:ring-brand/30 transition-all shadow-subtle">
                            <div class="w-7 h-7 rounded-full bg-brand-subtle text-brand font-bold text-sm flex items-center justify-center border border-brand/20">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 text-ink-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-border">
                            <p class="text-xs text-ink-muted">Signed in as</p>
                            <p class="text-xs font-bold text-ink-primary truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <x-dropdown-link :href="route('saved-jobs.index')">
                            <span class="text-xs text-ink-secondary">{{ __('Saved Jobs') }}</span>
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('resumes.index')">
                            <span class="text-xs text-ink-secondary">{{ __('My Resumes') }}</span>
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('candidate-profile.index')">
                            <span class="text-xs text-ink-secondary">{{ __('Candidate Profile') }}</span>
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('profile.edit')">
                            <span class="text-xs text-ink-secondary">{{ __('Account Settings') }}</span>
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                <span class="text-xs text-accent-danger">{{ __('Log Out') }}</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Button -->
            <div class="-mr-2 flex items-center lg:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-lg text-ink-secondary hover:text-ink-primary hover:bg-surface-subtle focus:outline-none transition-colors">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden lg:hidden border-t border-border bg-surface">
        <div class="px-4 pt-3 pb-2 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('dashboard') ? 'bg-brand text-accent-contrast' : 'text-ink-secondary' }}">
                Overview
            </a>

            <a href="{{ route('jobs.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs(['jobs.index', 'job-vacancies.*']) ? 'bg-brand text-accent-contrast' : 'text-ink-secondary' }}">
                Explore Jobs
            </a>

            <a href="{{ route('job-applications.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('job-applications.*') ? 'bg-brand text-accent-contrast' : 'text-ink-secondary' }}">
                Applications
            </a>

            <a href="{{ route('saved-jobs.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('saved-jobs.*') ? 'bg-brand text-accent-contrast' : 'text-ink-secondary' }}">
                Saved Jobs
            </a>

            <a href="{{ route('resumes.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('resumes.*') ? 'bg-brand text-accent-contrast' : 'text-ink-secondary' }}">
                Resume Manager
            </a>

            <a href="{{ route('candidate-profile.index') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('candidate-profile.*') ? 'bg-brand text-accent-contrast' : 'text-ink-secondary' }}">
                Candidate Profile
            </a>

            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-ink-secondary">
                Public Board
            </a>

            <button type="button" onclick="window.toggleTheme && window.toggleTheme()" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold text-ink-secondary hover:text-ink-primary hover:bg-surface-subtle transition-colors">
                <svg class="w-4 h-4 shrink-0 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
                <svg class="w-4 h-4 shrink-0 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Toggle Theme
            </button>

            @if(in_array(auth()->user()->role, ['admin', 'company_owner']))
                <a href="{{ route('backoffice.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-brand">
                    Back-Office Portal
                </a>
            @endif
        </div>

        <!-- Responsive User Info -->
        <div class="pt-3 pb-3 border-t border-border px-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-brand-subtle text-brand font-bold text-sm flex items-center justify-center border border-brand/20">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="text-sm font-bold text-ink-primary">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-ink-muted">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="block text-xs text-ink-secondary py-1.5 hover:text-brand">Account Settings</a>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="text-xs text-accent-danger font-semibold">Log Out</button>
            </form>
        </div>
    </div>
</nav>

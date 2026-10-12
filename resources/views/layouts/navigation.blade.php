<nav class="bg-sidebar h-full flex flex-col shrink-0 border-r border-white/5">

    {{-- Brand header --}}
    <div class="px-5 py-5 border-b border-white/10">
        <a href="{{ route('backoffice.dashboard') }}" class="flex items-center gap-2.5 group">
            <x-application-logo class="w-8 h-8" />
            <div>
                <span class="text-base font-extrabold text-white font-display tracking-tight">Shaghalny</span>
                <div class="text-[10px] uppercase font-bold tracking-wider text-white/40 mt-0.5">
                    @if(auth()->user()->role === 'admin') Admin Console @else Employer Portal @endif
                </div>
            </div>
        </a>
    </div>

    {{-- User identity --}}
    <div class="px-4 py-3 border-b border-white/10 flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-brand flex items-center justify-center text-white font-bold text-sm border border-brand/30 shrink-0">
            {{ substr(Auth::user()->name, 0, 1) }}
        </div>
        <div class="min-w-0">
            <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name }}</p>
            <p class="text-[10px] text-white/40 truncate">{{ Auth::user()->email }}</p>
        </div>
    </div>

    {{-- Navigation --}}
    <div class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

        @php
            $items = [];

            // Dashboard — always shown
            $items[] = [
                'label'  => 'Dashboard',
                'route'  => 'backoffice.dashboard',
                'icon'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
                'match'  => 'backoffice.dashboard',
            ];

            if(auth()->user()->role === 'admin') {
                $items[] = ['label' => 'Companies',   'route' => 'company.index',      'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',             'match' => 'company.*'];
                $items[] = ['label' => 'Categories',  'route' => 'job-category.index', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>', 'match' => 'job-category.*'];
                $items[] = ['label' => 'Users',       'route' => 'user.index',         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>', 'match' => 'user.*'];
            }

            if(auth()->user()->role === 'company_owner') {
                $items[] = ['label' => 'My Company',  'route' => 'myCompany.show',     'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',            'match' => 'myCompany.*'];
            }

            $items[] = ['label' => 'Job Vacancies', 'route' => 'job-vacancy.index',   'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',  'match' => 'job-vacancy.*'];
            $items[] = ['label' => 'Applications',  'route' => 'job-application.index','icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>', 'match' => 'job-application.*'];
        @endphp

        @foreach($items as $item)
            @php $isActive = request()->routeIs($item['match'] ?? $item['route']); @endphp
            <a
                href="{{ route($item['route']) }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ $isActive ? 'bg-white/10 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}"
                id="nav-{{ strtolower(str_replace([' ', '.'], ['-', '-'], $item['label'])) }}"
            >
                <svg class="w-4 h-4 shrink-0 {{ $isActive ? 'text-brand' : 'text-white/40' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! $item['icon'] !!}
                </svg>
                <span>{{ $item['label'] }}</span>
                @if($isActive)
                    <div class="ml-auto w-1.5 h-1.5 rounded-full bg-brand"></div>
                @endif
            </a>
        @endforeach
    </div>

    {{-- Footer links --}}
    <div class="px-3 py-3 border-t border-white/10 space-y-0.5">
        <button type="button" onclick="window.toggleTheme && window.toggleTheme()" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-white/50 hover:text-white hover:bg-white/5 transition-colors" id="nav-theme">
            <svg class="w-4 h-4 shrink-0 text-white/30 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
            <svg class="w-4 h-4 shrink-0 text-white/30 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            Theme
        </button>
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-white/50 hover:text-white hover:bg-white/5 transition-colors" id="nav-profile">
            <svg class="w-4 h-4 shrink-0 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Profile
        </a>
        <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-white/50 hover:text-white hover:bg-white/5 transition-colors" id="nav-public-board">
            <svg class="w-4 h-4 shrink-0 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            Public Board
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-400/70 hover:text-red-300 hover:bg-white/5 transition-colors" id="nav-logout">
                <svg class="w-4 h-4 shrink-0 text-red-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Log Out
            </button>
        </form>
    </div>
</nav>

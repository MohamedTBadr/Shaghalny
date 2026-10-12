<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">
    <meta name="theme-color" content="#0F131D">

    <title>{{ config('app.name', 'Shaghalny') }} — Back Office</title>
    <meta name="description" content="Shaghalny employer and admin portal for managing job vacancies and applications.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet" />

    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('layouts.partials.theme')
</head>

<body class="font-sans antialiased bg-surface text-ink-primary">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen">

        <!-- Mobile top bar -->
        <header class="lg:hidden sticky top-0 z-30 bg-sidebar border-b border-white/10">
            <div class="h-14 px-4 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                    <x-application-logo class="w-8 h-8" />
                    <div>
                        <span class="text-sm font-extrabold text-white font-display tracking-tight">Shaghalny</span>
                        <div class="text-[9px] uppercase font-bold tracking-wider text-white/40">
                            @if(auth()->user()->role === 'admin') Admin Console @else Employer Portal @endif
                        </div>
                    </div>
                </a>
                <div class="flex items-center gap-1">
                    <x-theme-toggle variant="sidebar" />
                    <button @click="sidebarOpen = true" type="button"
                            class="inline-flex items-center justify-center p-2 rounded-lg text-white/70 hover:text-white hover:bg-white/10 transition-colors"
                            aria-label="Open navigation">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </header>

        <!-- Desktop static sidebar -->
        <div class="hidden lg:flex fixed inset-y-0 left-0 w-[260px] z-20">
            @include('layouts.navigation')
        </div>

        <!-- Mobile drawer -->
        <div x-cloak x-show="sidebarOpen" class="lg:hidden fixed inset-0 z-50" role="dialog" aria-modal="true">
            <div class="absolute inset-0 bg-sidebar/60 backdrop-blur-sm transition-opacity"
                 @click="sidebarOpen = false" x-show="sidebarOpen"
                 x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

            <div class="absolute inset-y-0 left-0 w-[280px] max-w-[85vw] shadow-elevated"
                 x-show="sidebarOpen"
                 x-transition:enter="transition ease-out duration-200 transform"
                 x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-150 transform"
                 x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
                <button @click="sidebarOpen = false" type="button"
                        class="absolute top-4 right-4 z-10 inline-flex items-center justify-center p-1.5 rounded-lg text-white/60 hover:text-white hover:bg-white/10 transition-colors"
                        aria-label="Close navigation">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                @include('layouts.navigation')
            </div>
        </div>

        <!-- Main content -->
        <div class="lg:pl-[260px] flex flex-col min-h-screen">
            @isset($header)
                <header class="bg-surface border-b border-border px-4 sm:px-6 py-4 sticky top-0 z-10">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1 p-4 sm:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>

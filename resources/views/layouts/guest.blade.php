<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
        <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">
        <meta name="theme-color" content="#3157D5">

        <title>{{ config('app.name', 'Shaghalny') }} — Account</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet" />

        <style>
            [x-cloak] { display: none !important; }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @include('layouts.partials.theme')
    </head>
    <body class="min-h-full bg-surface-subtle text-ink-primary font-sans antialiased selection:bg-brand selection:text-accent-contrast">
        <div class="min-h-screen grid lg:grid-cols-2">

            {{-- Brand / editorial panel --}}
            <aside class="hidden lg:flex flex-col justify-between bg-sidebar text-white p-12 relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-80 h-80 rounded-full bg-brand/20 blur-3xl"></div>
                <div class="absolute -bottom-32 -left-16 w-96 h-96 rounded-full bg-brand/10 blur-3xl"></div>

                <a href="{{ route('home') }}" class="relative flex items-center gap-3">
                    <x-application-logo class="w-10 h-10" />
                    <div>
                        <span class="text-xl font-extrabold tracking-tight font-display">Shaghalny</span>
                        <div class="text-[10px] uppercase font-bold tracking-wider text-white/40 -mt-0.5">Recruitment Platform</div>
                    </div>
                </a>

                <div class="relative max-w-md">
                    <h2 class="text-3xl font-bold font-display leading-tight tracking-tight mb-4">
                        Intelligent hiring, <span class="text-brand-200">from first résumé to signed offer.</span>
                    </h2>
                    <p class="text-sm text-white/60 leading-relaxed mb-8">
                        AI-assisted candidate matching, application tracking, and a curated employer network — all in one workspace.
                    </p>

                    <ul class="space-y-4">
                        @foreach([
                            ['title' => 'AI match scoring', 'text' => 'Every application scored against the role requirements.'],
                            ['title' => 'Verified employers', 'text' => 'A curated directory of companies actively hiring.'],
                            ['title' => 'One workspace', 'text' => 'Résumés, saved jobs, and status tracking in one place.'],
                        ] as $feature)
                            <li class="flex items-start gap-3">
                                <span class="mt-0.5 flex items-center justify-center w-6 h-6 rounded-lg bg-brand/20 text-brand-200 shrink-0">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                <div>
                                    <p class="text-sm font-semibold text-white">{{ $feature['title'] }}</p>
                                    <p class="text-xs text-white/50">{{ $feature['text'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <p class="relative text-xs text-white/40">&copy; {{ date('Y') }} Shaghalny Platform Inc.</p>
            </aside>

            {{-- Form panel --}}
            <main class="flex flex-col min-h-screen">
                <header class="flex items-center justify-between p-5 lg:p-8">
                    <a href="{{ route('home') }}" class="lg:hidden flex items-center gap-2.5">
                        <x-application-logo class="w-9 h-9" />
                        <span class="text-lg font-extrabold text-ink-primary font-display tracking-tight">Shaghalny</span>
                    </a>
                    <x-theme-toggle class="ml-auto" />
                </header>

                <div class="flex-1 flex items-center justify-center px-5 pb-12">
                    <div class="w-full max-w-md">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>

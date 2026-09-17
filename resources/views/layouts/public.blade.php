<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $settings->site_name ?? 'Sportika')</title>
    <meta name="description" content="@yield('meta_description', $settings->tagline ?? 'Player representation, scouting and sports news.')">
    <meta name="theme-color" content="#0f2557">

    <link rel="icon" type="image/png" href="{{ asset('images/wolf-favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/wolf-favicon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col" x-data="{}">

    {{-- Skip to content (a11y) --}}
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[100] focus:rounded-lg focus:bg-accent-500 focus:px-4 focus:py-2 focus:text-sm focus:font-bold focus:text-white">
        Skip to main content
    </a>

    <x-navbar :settings="$settings ?? null" />

    <main id="main-content" class="flex-1">
        @yield('content')
    </main>

    <x-footer :settings="$settings ?? null" />

    {{-- Back-to-top button --}}
    <div x-data="{ show: false }" x-init="window.addEventListener('scroll', () => { show = window.scrollY > 400 })">
        <button
            x-show="show"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak
            x-on:click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="fixed bottom-6 right-6 z-40 grid size-11 place-items-center rounded-full bg-accent-500 text-white shadow-lg shadow-accent-500/30 transition hover:bg-accent-400 active:scale-95"
            aria-label="Back to top"
        >
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" /></svg>
        </button>
    </div>

</body>
</html>

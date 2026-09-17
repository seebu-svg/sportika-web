@php
    $navSettings = $settings ?? \App\Models\SiteSetting::current();
@endphp

<header
    x-data="{ open: false }"
    class="sticky top-0 z-50 border-b border-white/10 bg-pitch-950/80 backdrop-blur-md"
>
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5">
            <span class="grid size-9 place-items-center rounded-lg bg-accent-400 font-display text-xl text-pitch-950">
                S
            </span>
            <span class="font-display text-2xl tracking-widest text-white">
                {{ strtoupper($navSettings->site_name) }}
            </span>
        </a>

        {{-- Desktop navigation --}}
        <div class="hidden items-center gap-1 md:flex">
            <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">Home</x-nav-link>
            <x-nav-link href="{{ route('about') }}" :active="request()->routeIs('about')">About</x-nav-link>
            <x-nav-link href="{{ route('players.index') }}" :active="request()->routeIs('players.*')">Players</x-nav-link>
            <x-nav-link href="{{ route('posts.index') }}" :active="request()->routeIs('posts.*')">News</x-nav-link>
            <x-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">Contact</x-nav-link>
        </div>

        <div class="hidden md:block">
            <a
                href="{{ route('contact') }}"
                class="rounded-full bg-accent-400 px-5 py-2.5 text-sm font-bold text-pitch-950 transition hover:bg-accent-300"
            >
                Get in touch
            </a>
        </div>

        {{-- Mobile toggle --}}
        <button
            x-on:click="open = ! open"
            class="rounded-md p-2 text-slate-300 hover:bg-white/5 md:hidden"
            aria-label="Toggle navigation"
        >
            <svg x-show="! open" class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <svg x-show="open" x-cloak class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </nav>

    {{-- Mobile navigation --}}
    <div
        x-show="open"
        x-cloak
        x-transition.opacity
        class="border-t border-white/10 px-4 pb-4 md:hidden"
    >
        <div class="flex flex-col gap-1 pt-3">
            <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">Home</x-nav-link>
            <x-nav-link href="{{ route('about') }}" :active="request()->routeIs('about')">About</x-nav-link>
            <x-nav-link href="{{ route('players.index') }}" :active="request()->routeIs('players.*')">Players</x-nav-link>
            <x-nav-link href="{{ route('posts.index') }}" :active="request()->routeIs('posts.*')">News</x-nav-link>
            <x-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">Contact</x-nav-link>
            <a
                href="{{ route('contact') }}"
                class="mt-2 rounded-full bg-accent-400 px-5 py-2.5 text-center text-sm font-bold text-pitch-950"
            >
                Get in touch
            </a>
        </div>
    </div>
</header>

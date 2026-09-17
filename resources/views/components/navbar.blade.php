@php
    $navSettings = $settings ?? \App\Models\SiteSetting::current();

    $isAboutActive = request()->routeIs('about', 'team');
    $isPlayersActive = request()->routeIs('players.*');
@endphp

<header
    x-data="{ open: false, aboutOpen: false, playersOpen: false }"
    class="sticky top-0 z-50 border-b border-gray-100 bg-white/95 backdrop-blur-md shadow-sm"
>
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5">
            <img src="{{ asset('images/wolf-logo.png') }}" alt="{{ $navSettings->site_name }}" class="size-10 rounded-lg object-contain">
            <span class="font-display text-2xl tracking-widest text-black">
                {{ strtoupper($navSettings->site_name) }}
            </span>
        </a>

        {{-- Desktop navigation --}}
        <div class="hidden items-center gap-0.5 lg:flex">
            {{-- About Us dropdown --}}
            <div class="relative" x-on:click.away="aboutOpen = false">
                <button
                    x-on:click="aboutOpen = ! aboutOpen"
                    @class([
                        'flex items-center gap-1 rounded-full px-3 py-2 text-sm font-medium transition',
                        'bg-blue-50/80 text-accent-500' => $isAboutActive,
                        'text-gray-500 hover:text-black' => ! $isAboutActive,
                    ])
                >
                    About Us
                    <svg class="size-3.5 transition" :class="{ 'rotate-180': aboutOpen }" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div
                    x-show="aboutOpen"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-1"
                    x-cloak
                    class="absolute left-0 top-full z-50 mt-1 w-44 overflow-hidden rounded-xl border border-gray-100 bg-white shadow-lg shadow-gray-200/50"
                >
                    <a href="{{ route('about') }}" class="block px-4 py-2.5 text-sm text-gray-600 transition hover:bg-blue-50/50 hover:text-accent-500">Our Story</a>
                    <a href="{{ route('team') }}" class="block px-4 py-2.5 text-sm text-gray-600 transition hover:bg-blue-50/50 hover:text-accent-500">Our Team</a>
                </div>
            </div>

            {{-- Players dropdown --}}
            <div class="relative" x-on:click.away="playersOpen = false">
                <button
                    x-on:click="playersOpen = ! playersOpen"
                    @class([
                        'flex items-center gap-1 rounded-full px-3 py-2 text-sm font-medium transition',
                        'bg-blue-50/80 text-accent-500' => $isPlayersActive,
                        'text-gray-500 hover:text-black' => ! $isPlayersActive,
                    ])
                >
                    Players
                    <svg class="size-3.5 transition" :class="{ 'rotate-180': playersOpen }" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div
                    x-show="playersOpen"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-1"
                    x-cloak
                    class="absolute left-0 top-full z-50 mt-1 w-48 overflow-hidden rounded-xl border border-gray-100 bg-white shadow-lg shadow-gray-200/50"
                >
                    <a href="{{ route('players.index') }}" class="block px-4 py-2.5 text-sm text-gray-600 transition hover:bg-blue-50/50 hover:text-accent-500">Players Directory</a>
                </div>
            </div>

            <x-nav-link href="{{ route('tournaments.index') }}" :active="request()->routeIs('tournaments.*')">Tournaments</x-nav-link>
            <x-nav-link href="{{ route('gallery') }}" :active="request()->routeIs('gallery')">Gallery</x-nav-link>
            <x-nav-link href="{{ route('sponsors') }}" :active="request()->routeIs('sponsors')">Sponsors</x-nav-link>
            <x-nav-link href="{{ route('podcast') }}" :active="request()->routeIs('podcast.*')">Podcast</x-nav-link>
            <x-nav-link href="{{ route('posts.index') }}" :active="request()->routeIs('posts.*')">News</x-nav-link>
            <x-nav-link href="{{ route('blogs.index') }}" :active="request()->routeIs('blogs.*')">Blogs</x-nav-link>
            <x-nav-link href="{{ route('membership.player') }}" :active="request()->routeIs('membership.*')">Join</x-nav-link>
            <x-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">Contact Us</x-nav-link>
        </div>

        {{-- CTA button --}}
        <div class="hidden md:block">
            <a
                href="{{ route('membership.player') }}"
                class="rounded-full bg-accent-500 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-accent-600"
            >
                Join / Membership
            </a>
        </div>

        {{-- Mobile toggle --}}
        <button
            x-on:click="open = ! open"
            class="rounded-md p-2 text-gray-500 hover:bg-gray-50 lg:hidden"
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
        class="border-t border-gray-100 px-4 pb-4 lg:hidden"
    >
        <div class="flex flex-col gap-1 pt-3">
            {{-- About Us --}}
            <p class="mt-2 px-4 text-[10px] font-bold uppercase tracking-[0.25em] text-slate-400">About Us</p>
            <x-nav-link href="{{ route('about') }}" :active="request()->routeIs('about')">Our Story</x-nav-link>
            <x-nav-link href="{{ route('team') }}" :active="request()->routeIs('team')">Our Team</x-nav-link>

            {{-- Players --}}
            <p class="mt-2 px-4 text-[10px] font-bold uppercase tracking-[0.25em] text-slate-400">Players</p>
            <x-nav-link href="{{ route('players.index') }}" :active="request()->routeIs('players.*')">Players Directory</x-nav-link>

            {{-- Explore --}}
            <p class="mt-2 px-4 text-[10px] font-bold uppercase tracking-[0.25em] text-slate-400">Explore</p>
            <x-nav-link href="{{ route('tournaments.index') }}" :active="request()->routeIs('tournaments.*')">Tournaments</x-nav-link>
            <x-nav-link href="{{ route('gallery') }}" :active="request()->routeIs('gallery')">Champions Gallery</x-nav-link>
            <x-nav-link href="{{ route('sponsors') }}" :active="request()->routeIs('sponsors')">Sponsors / Partners</x-nav-link>

            {{-- Media --}}
            <p class="mt-2 px-4 text-[10px] font-bold uppercase tracking-[0.25em] text-slate-400">Media</p>
            <x-nav-link href="{{ route('podcast') }}" :active="request()->routeIs('podcast.*')">Podcast</x-nav-link>
            <x-nav-link href="{{ route('posts.index') }}" :active="request()->routeIs('posts.*')">News</x-nav-link>
            <x-nav-link href="{{ route('blogs.index') }}" :active="request()->routeIs('blogs.*')">Blogs</x-nav-link>

            {{-- Membership & Contact --}}
            <p class="mt-2 px-4 text-[10px] font-bold uppercase tracking-[0.25em] text-slate-400">Membership</p>
            <x-nav-link href="{{ route('membership.player') }}" :active="request()->routeIs('membership.player')">Join as Player</x-nav-link>
            <x-nav-link href="{{ route('membership.brand') }}" :active="request()->routeIs('membership.brand')">Join as Brand</x-nav-link>

            <x-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">Contact Us</x-nav-link>

            {{-- CTA buttons --}}
            <div class="mt-3 flex flex-col gap-2">
                <a
                    href="{{ route('membership.player') }}"
                    class="rounded-full bg-accent-500 px-5 py-2.5 text-center text-sm font-bold text-white transition hover:bg-accent-600"
                >
                    Join / Membership
                </a>
            </div>
        </div>
    </div>
</header>

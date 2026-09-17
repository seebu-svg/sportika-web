@php
    $navSettings = $settings ?? \App\Models\SiteSetting::current();

    $aboutRoutes = ['about', 'team'];
    $contentRoutes = ['tournaments.*', 'gallery', 'sponsors'];
    $mediaRoutes = ['podcast.*', 'blogs.*', 'posts.*'];
    $isAboutActive = request()->routeIs($aboutRoutes);
    $isContentActive = request()->routeIs($contentRoutes);
    $isMediaActive = request()->routeIs($mediaRoutes);
@endphp

<header
    x-data="{ open: false, aboutOpen: false, contentOpen: false, mediaOpen: false }"
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
        <div class="hidden items-center gap-1 lg:flex">
            <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">Home</x-nav-link>

            {{-- About dropdown (About Us + Team) --}}
            <div class="relative" x-on:click.away="aboutOpen = false">
                <button
                    x-on:click="aboutOpen = ! aboutOpen"
                    @class([
                        'flex items-center gap-1 rounded-full px-4 py-2 text-sm font-medium transition',
                        'bg-white/5 text-white' => $isAboutActive,
                        'text-slate-300 hover:text-white' => ! $isAboutActive,
                    ])
                >
                    About
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
                    class="absolute left-0 top-full z-50 mt-1 w-48 overflow-hidden rounded-xl border border-white/10 bg-pitch-800 shadow-xl shadow-black/30"
                >
                    <a href="{{ route('about') }}" class="block px-4 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">About Us</a>
                    <a href="{{ route('team') }}" class="block px-4 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">Team</a>
                </div>
            </div>

            <x-nav-link href="{{ route('players.index') }}" :active="request()->routeIs('players.*')">Players</x-nav-link>

            {{-- Tournaments, Gallery, Sponsors --}}
            <div class="relative" x-on:click.away="contentOpen = false">
                <button
                    x-on:click="contentOpen = ! contentOpen"
                    @class([
                        'flex items-center gap-1 rounded-full px-4 py-2 text-sm font-medium transition',
                        'bg-white/5 text-white' => $isContentActive,
                        'text-slate-300 hover:text-white' => ! $isContentActive,
                    ])
                >
                    More
                    <svg class="size-3.5 transition" :class="{ 'rotate-180': contentOpen }" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div
                    x-show="contentOpen"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-1"
                    x-cloak
                    class="absolute left-0 top-full z-50 mt-1 w-52 overflow-hidden rounded-xl border border-white/10 bg-pitch-800 shadow-xl shadow-black/30"
                >
                    <a href="{{ route('tournaments.index') }}" class="block px-4 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">Tournaments</a>
                    <a href="{{ route('gallery') }}" class="block px-4 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">Champions Gallery</a>
                    <a href="{{ route('sponsors') }}" class="block px-4 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">Sponsors & Partners</a>
                </div>
            </div>

            {{-- News, Blogs, Podcast --}}
            <div class="relative" x-on:click.away="mediaOpen = false">
                <button
                    x-on:click="mediaOpen = ! mediaOpen"
                    @class([
                        'flex items-center gap-1 rounded-full px-4 py-2 text-sm font-medium transition',
                        'bg-white/5 text-white' => $isMediaActive,
                        'text-slate-300 hover:text-white' => ! $isMediaActive,
                    ])
                >
                    Media
                    <svg class="size-3.5 transition" :class="{ 'rotate-180': mediaOpen }" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div
                    x-show="mediaOpen"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-1"
                    x-cloak
                    class="absolute left-0 top-full z-50 mt-1 w-48 overflow-hidden rounded-xl border border-white/10 bg-pitch-800 shadow-xl shadow-black/30"
                >
                    <a href="{{ route('posts.index') }}" class="block px-4 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">News</a>
                    <a href="{{ route('blogs.index') }}" class="block px-4 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">Blogs</a>
                    <a href="{{ route('podcast') }}" class="block px-4 py-2.5 text-sm text-slate-300 transition hover:bg-white/5 hover:text-white">Podcast</a>
                </div>
            </div>

            <x-nav-link href="{{ route('faq') }}" :active="request()->routeIs('faq')">FAQs</x-nav-link>
            <x-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">Contact</x-nav-link>
        </div>

        <div class="hidden gap-2 md:flex">
            <a
                href="{{ route('membership.player') }}"
                class="rounded-full border border-accent-400/40 px-4 py-2.5 text-sm font-bold text-accent-300 transition hover:bg-accent-400/10"
            >
                Join as Player
            </a>
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
            class="rounded-md p-2 text-slate-300 hover:bg-white/5 lg:hidden"
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
        class="border-t border-white/10 px-4 pb-4 lg:hidden"
    >
        <div class="flex flex-col gap-1 pt-3">
            <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">Home</x-nav-link>

            {{-- About section --}}
            <p class="mt-2 px-4 text-[10px] font-bold uppercase tracking-[0.25em] text-slate-500">About</p>
            <x-nav-link href="{{ route('about') }}" :active="request()->routeIs('about')">About Us</x-nav-link>
            <x-nav-link href="{{ route('team') }}" :active="request()->routeIs('team')">Team</x-nav-link>

            <x-nav-link href="{{ route('players.index') }}" :active="request()->routeIs('players.*')">Players</x-nav-link>

            {{-- Content section --}}
            <p class="mt-2 px-4 text-[10px] font-bold uppercase tracking-[0.25em] text-slate-500">Explore</p>
            <x-nav-link href="{{ route('tournaments.index') }}" :active="request()->routeIs('tournaments.*')">Tournaments</x-nav-link>
            <x-nav-link href="{{ route('gallery') }}" :active="request()->routeIs('gallery')">Champions Gallery</x-nav-link>
            <x-nav-link href="{{ route('sponsors') }}" :active="request()->routeIs('sponsors')">Sponsors & Partners</x-nav-link>

            {{-- Membership --}}
            <p class="mt-2 px-4 text-[10px] font-bold uppercase tracking-[0.25em] text-slate-500">Membership</p>
            <x-nav-link href="{{ route('membership.player') }}" :active="request()->routeIs('membership.player')">Join as Player</x-nav-link>
            <x-nav-link href="{{ route('membership.brand') }}" :active="request()->routeIs('membership.brand')">Join as Brand</x-nav-link>

            {{-- Media section --}}
            <p class="mt-2 px-4 text-[10px] font-bold uppercase tracking-[0.25em] text-slate-500">Media</p>
            <x-nav-link href="{{ route('podcast') }}" :active="request()->routeIs('podcast.*')">Podcast</x-nav-link>
            <x-nav-link href="{{ route('posts.index') }}" :active="request()->routeIs('posts.*')">News</x-nav-link>
            <x-nav-link href="{{ route('blogs.index') }}" :active="request()->routeIs('blogs.*')">Blogs</x-nav-link>

            {{-- Support --}}
            <p class="mt-2 px-4 text-[10px] font-bold uppercase tracking-[0.25em] text-slate-500">Support</p>
            <x-nav-link href="{{ route('faq') }}" :active="request()->routeIs('faq')">FAQs</x-nav-link>
            <x-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">Contact Us</x-nav-link>

            <div class="mt-3 flex flex-col gap-2">
                <a
                    href="{{ route('membership.player') }}"
                    class="rounded-full border border-accent-400/40 px-5 py-2.5 text-center text-sm font-bold text-accent-300 transition hover:bg-accent-400/10"
                >
                    Join as Player
                </a>
                <a
                    href="{{ route('contact') }}"
                    class="rounded-full bg-accent-400 px-5 py-2.5 text-center text-sm font-bold text-pitch-950"
                >
                    Get in touch
                </a>
            </div>
        </div>
    </div>
</header>

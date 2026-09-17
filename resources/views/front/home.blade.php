@extends('layouts.public', ['settings' => $settings])

@section('title', $settings->site_name.' — '.$settings->tagline)

@section('content')
    {{-- ============================== 1. HERO ============================== --}}
    <section class="relative flex min-h-[92vh] items-center overflow-hidden bg-accent-600">
        {{-- Hero banner background --}}
        <div class="absolute inset-0">
            <img src="{{ asset('images/hero-banner.png') }}" alt="" class="size-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-accent-600/90 via-accent-600/70 to-accent-600/40"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-accent-600/60 via-transparent to-transparent"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.25em] text-blue-100">
                    <span class="inline-block size-2 rounded-full bg-white animate-pulse"></span>
                    Player Management Agency
                </p>
                <h1 class="font-display text-5xl uppercase leading-[0.92] tracking-wide text-white sm:text-7xl lg:text-8xl">
                    {{ $settings->hero_title ?? 'Where Talent Meets Opportunity' }}
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-relaxed text-blue-100 sm:text-xl">
                    {{ $settings->hero_subtitle ?? 'Discover our squad of exceptional athletes, follow the latest news, and get in touch with our team.' }}
                </p>
                <div class="mt-10 flex flex-wrap gap-4">
                    <a href="{{ route('players.index') }}" class="rounded-full bg-white px-8 py-4 text-sm font-bold uppercase tracking-wider text-accent-500 transition hover:bg-blue-50">
                        Explore Players
                    </a>
                    <a href="{{ route('membership.player') }}" class="rounded-full border border-white/30 px-8 py-4 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-white/10">
                        Join the Platform
                    </a>
                </div>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2">
            <div class="flex flex-col items-center gap-2 text-blue-200">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em]">Scroll</span>
                <div class="h-8 w-px bg-gradient-to-b from-white/50 to-transparent"></div>
            </div>
        </div>
    </section>

    {{-- ========================= 2. BRAND INTRODUCTION ========================= --}}
    <section class="border-b border-gray-200 bg-white">
        <div class="mx-auto grid max-w-7xl items-center gap-14 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:px-8">
            <div>
                <x-section-heading
                    eyebrow="Who we are"
                    title="{{ $settings->about_title ?? 'Built for the Beautiful Game' }}"
                />
                <div class="mt-5 space-y-4 text-base leading-relaxed text-gray-700">
                    {!! Str::limit(strip_tags($settings->about_body ?? '<p>Sportika is a modern player management agency dedicated to developing, promoting and protecting the careers of outstanding footballers around the world.</p>'), 320) !!}
                </div>
                <a
                    href="{{ route('about') }}"
                    class="mt-8 inline-block rounded-full bg-accent-500 px-6 py-3 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-accent-600"
                >
                    Our Story &rarr;
                </a>
            </div>

            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('images/wolf-logo.png') }}" alt="Sportika" class="mb-8 w-48 opacity-90 drop-shadow-lg sm:w-56">
                <div class="grid w-full grid-cols-2 gap-4">
                    <div class="rounded-2xl border border-gray-200 bg-white p-7 shadow-sm">
                        <p class="font-display text-5xl text-accent-500">{{ $stats['players'] }}</p>
                        <p class="mt-1 text-sm text-gray-500">Players represented</p>
                    </div>
                    <div class="rounded-2xl border border-gray-200 bg-white p-7 mt-6 shadow-sm">
                        <p class="font-display text-5xl text-accent-500">{{ $stats['countries'] }}</p>
                        <p class="mt-1 text-sm text-gray-500">Countries</p>
                    </div>
                    <div class="rounded-2xl border border-gray-200 bg-white p-7 shadow-sm">
                        <p class="font-display text-5xl text-accent-500">{{ $stats['tournaments'] }}</p>
                        <p class="mt-1 text-sm text-gray-500">Tournaments</p>
                    </div>
                    <div class="rounded-2xl border border-gray-200 bg-white p-7 mt-6 shadow-sm">
                        <p class="font-display text-5xl text-accent-500">{{ $stats['years'] }}+</p>
                    <p class="mt-1 text-sm text-gray-500">Years of experience</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================== 3. NEWS PREVIEW ============================== --}}
    @if ($latestNews->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <x-section-heading eyebrow="Latest updates" title="News" />
                <a href="{{ route('posts.index') }}" class="mb-10 text-sm font-bold uppercase tracking-wider text-accent-500 transition hover:text-accent-400">
                    View All →
                </a>
            </div>
            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($latestNews as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- ============================== 4. BLOGS PREVIEW ============================== --}}
    @if ($latestBlogs->isNotEmpty())
        <section class="border-y border-gray-200 bg-white">
            <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <x-section-heading eyebrow="Insights & opinion" title="From the Blog" />
                    <a href="{{ route('blogs.index') }}" class="mb-10 text-sm font-bold uppercase tracking-wider text-accent-500 transition hover:text-accent-400">
                        View All →
                    </a>
                </div>
                <div class="grid gap-6 md:grid-cols-3">
                    @foreach ($latestBlogs as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ========================= 5. FEATURED TOURNAMENTS ========================= --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <x-section-heading
                eyebrow="Competitions"
                title="Featured Tournaments"
                subtitle="Upcoming and recent tournaments featuring Sportika players."
            />
            <a href="{{ route('tournaments.index') }}" class="mb-10 text-sm font-bold uppercase tracking-wider text-accent-500 transition hover:text-accent-400">
                View All →
            </a>
        </div>
        <div class="grid gap-6 md:grid-cols-3">
            @foreach ([
                ['name' => 'Summer Cup 2026', 'date' => 'Oct 12 – Nov 3, 2026', 'location' => 'London, UK', 'status' => 'Upcoming'],
                ['name' => 'International Champions Trophy', 'date' => 'Sep 20 – Oct 8, 2026', 'location' => 'Madrid, Spain', 'status' => 'Upcoming'],
                ['name' => 'Pre-Season Invitational', 'date' => 'Aug 15 – Aug 28, 2026', 'location' => 'Munich, Germany', 'status' => 'Completed'],
            ] as $tournament)
                <a href="{{ route('tournaments.index') }}" class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 transition duration-300 hover:-translate-y-1 hover:border-accent-400">
                    <div class="bg-diagonal absolute inset-0 opacity-30"></div>
                    <div class="relative">
                        <span class="inline-block rounded-full bg-accent-500/15 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-accent-500">
                            {{ $tournament['status'] }}
                        </span>
                        <h3 class="mt-4 font-display text-xl uppercase tracking-wide text-black">{{ $tournament['name'] }}</h3>
                        <div class="mt-4 space-y-2 text-sm text-gray-500">
                            <p class="flex items-center gap-2">
                                <svg class="size-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                                {{ $tournament['date'] }}
                            </p>
                            <p class="flex items-center gap-2">
                                <svg class="size-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
                                {{ $tournament['location'] }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ========================= 6. HIGHLIGHT VIDEOS / REEL ========================= --}}
    <section class="border-y border-gray-200 bg-accent-600">
        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Watch"
                title="Highlights & Reels"
                subtitle="Previous match highlights, skills compilations and behind-the-scenes footage."
                :align="'center'"
                :inverted="true"
            />
            <div class="grid gap-6 md:grid-cols-3">
                @foreach (['Match Highlights — Matchday 12', 'Skills Compilation — Season Review', 'Behind the Scenes — Training Camp'] as $video)
                    <div class="group relative aspect-video overflow-hidden rounded-2xl border border-gray-200 bg-white">
                        <div class="bg-diagonal absolute inset-0"></div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <div class="grid size-16 place-items-center rounded-full bg-accent-500/20 text-accent-500 transition group-hover:scale-110 group-hover:bg-accent-500/30">
                                <svg class="size-7 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
                            </div>
                            <p class="mt-4 text-sm font-medium text-gray-700">{{ $video }}</p>
                            <p class="mt-1 text-xs text-gray-400">Coming soon</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ========================= 7. FEATURED PLAYERS ========================= --}}
    @if ($featuredPlayers->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <x-section-heading eyebrow="The squad" title="Featured Players" />
                <a href="{{ route('players.index') }}" class="mb-10 text-sm font-bold uppercase tracking-wider text-accent-500 transition hover:text-accent-400">
                    View All →
                </a>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($featuredPlayers as $player)
                    <x-player-card :player="$player" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- ========================= 8. CHAMPIONS GALLERY PREVIEW ========================= --}}
    <section class="border-y border-gray-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <x-section-heading eyebrow="Moments of glory" title="Champions Gallery" />
                <a href="{{ route('gallery') }}" class="mb-10 text-sm font-bold uppercase tracking-wider text-accent-500 transition hover:text-accent-400">
                    View All →
                </a>
            </div>
            <div class="grid gap-4 grid-cols-2 md:grid-cols-4">
                @foreach (['Trophy Lift — Summer Cup 2025', 'Goal of the Season', 'Champions Celebration', 'MVP Award Ceremony'] as $i => $caption)
                    <div class="group relative aspect-square overflow-hidden rounded-2xl border border-gray-200 bg-white">
                        <div class="bg-diagonal absolute inset-0"></div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center p-4 text-center">
                            <svg class="size-8 text-accent-500/40" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.45 5.73 3.12a11.998 11.998 0 0 1 0-15.14L2.25 6.55m15.5 8.9-5.73 3.12a11.998 11.998 0 0 0 0-15.14l5.73 3.12M6.75 12h.008v.008H6.75V12Z" /></svg>
                            <p class="mt-3 text-xs font-medium text-gray-400">{{ $caption }}</p>
                        </div>
                        <div class="absolute inset-0 bg-accent-500/0 transition group-hover:bg-accent-500/5"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================== 9. STATS COUNTER ============================== --}}
    <section class="relative overflow-hidden">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="absolute -top-20 left-1/2 size-80 -translate-x-1/2 rounded-full bg-accent-500/5 blur-3xl"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
                @foreach ([
                    ['value' => $stats['players'], 'label' => 'Players Represented', 'icon' => 'M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z'],
                    ['value' => $stats['countries'], 'label' => 'Countries', 'icon' => 'M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.743 4.356M12 3a8.997 8.997 0 0 0-7.743 4.356m15.486 0A10.96 10.96 0 0 1 12 12.747m0 0A10.96 10.96 0 0 1 4.254 7.356m7.746 5.391a5.988 5.988 0 0 1-3.712-2.572m7.424 2.572a5.988 5.988 0 0 0 3.712-2.572'],
                    ['value' => $stats['tournaments'], 'label' => 'Tournaments', 'icon' => 'M16.5 18.75h-9a9 9 0 0 1 0-18h9M16.5 18.75V6.75m0 12h-9m9-12a2.25 2.25 0 0 1 2.25 2.25v4.5a2.25 2.25 0 0 1-2.25 2.25m-9-9a2.25 2.25 0 0 0-2.25 2.25v4.5a2.25 2.25 0 0 0 2.25 2.25'],
                    ['value' => $stats['years'] . '+', 'label' => 'Years Experience', 'icon' => 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
                ] as $stat)
                    <div class="text-center">
                        <div class="mx-auto mb-4 grid size-14 place-items-center rounded-2xl border border-gray-200 bg-white">
                            <svg class="size-6 text-accent-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" />
                            </svg>
                        </div>
                        <p class="font-display text-5xl text-accent-500 sm:text-6xl">{{ $stat['value'] }}</p>
                        <p class="mt-2 text-sm uppercase tracking-wider text-gray-500">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ========================= 10. SPONSORS / PARTNERS STRIP ========================= --}}
    <section class="border-y border-gray-200 bg-accent-600">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <p class="mb-10 text-center text-xs font-bold uppercase tracking-[0.3em] text-blue-200">Trusted by leading brands</p>
            <div class="flex flex-wrap items-center justify-center gap-x-12 gap-y-6">
                @foreach (['Nike', 'Adidas', 'Puma', 'Under Armour', 'New Balance', 'Umbro'] as $sponsor)
                    <div class="flex h-12 items-center rounded-xl border border-white/10 bg-white/10 px-8 text-lg font-display font-bold tracking-widest text-white/80 transition hover:bg-white/20 hover:text-white">
                        {{ strtoupper($sponsor) }}
                    </div>
                @endforeach
            </div>
            <p class="mt-8 text-center">
                <a href="{{ route('sponsors') }}" class="text-sm font-bold uppercase tracking-wider text-white transition hover:text-blue-100">
                    View all partners &rarr;
                </a>
            </p>
        </div>
    </section>

    {{-- ============================== 11. CTA ============================== --}}
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-3xl border border-accent-200 bg-gradient-to-br from-accent-500 to-accent-600 px-8 py-16 text-center sm:px-16">
                <div class="bg-diagonal absolute inset-0"></div>
                <div class="absolute -top-20 right-0 size-60 rounded-full bg-accent-400/20 blur-3xl"></div>
                <div class="relative">
                    <h2 class="font-display text-4xl uppercase tracking-wide text-white sm:text-5xl">
                        Ready to play at the next level?
                    </h2>
                    <p class="mx-auto mt-4 max-w-xl text-lg text-blue-100">
                        Whether you are a player seeking representation or a brand looking to connect with talent — our door is open.
                    </p>
                    <div class="mt-10 flex flex-wrap justify-center gap-4">
                        <a
                            href="{{ route('players.index') }}"
                            class="rounded-full bg-white px-8 py-4 text-sm font-bold uppercase tracking-wider text-accent-500 transition hover:bg-blue-50"
                        >
                            Explore Players
                        </a>
                        <a
                            href="{{ route('membership.player') }}"
                            class="rounded-full border border-white/30 px-8 py-4 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-white/10"
                        >
                            Join as Player
                        </a>
                        <a
                            href="{{ route('membership.brand') }}"
                            class="rounded-full border border-white/30 px-8 py-4 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-white/10"
                        >
                            Join as Brand
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

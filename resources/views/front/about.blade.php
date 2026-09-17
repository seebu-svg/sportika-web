@extends('layouts.public', ['settings' => $settings])

@section('title', 'About Us — '.$settings->site_name)

@section('content')
    {{-- ============================== HERO ============================= --}}
    <section class="relative overflow-hidden bg-accent-600">
        <div class="absolute inset-0">
            <img src="{{ asset('images/hero-banner.png') }}" alt="" class="size-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-accent-600/90 via-accent-600/75 to-accent-600/50"></div>
        </div>
        <div class="relative mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Who we are"
                title="{{ $settings->about_title ?? 'About '.($settings->site_name) }}"
                subtitle="Building careers, creating champions, and shaping the future of sports management."
            :inverted="true"
            />
        </div>
    </section>

    {{-- ========================== OUR STORY ============================ --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-2">
            <div>
                <img src="{{ asset('images/wolf-logo.png') }}" alt="Sportika" class="mb-8 w-40 opacity-85 drop-shadow-lg">
                <p class="mb-2 text-xs font-bold uppercase tracking-[0.25em] text-accent-500">Our Story</p>
                <h2 class="font-display text-4xl uppercase tracking-wide text-black sm:text-5xl">
                    From Vision to Victory
                </h2>
                <div class="mt-6 space-y-4 text-base leading-relaxed text-gray-700">
                    @if (filled($settings->about_body))
                        {!! $settings->about_body !!}
                    @else
                        <p>Sportika was founded with a singular vision: to bridge the gap between raw athletic talent and the opportunities it deserves. What began as a small team of passionate sports professionals has grown into a full-service player management agency representing athletes across multiple disciplines.</p>
                        <p>We believe every athlete deserves a team behind them — not just for contract negotiations, but for career development, brand building, and life after sport. Our holistic approach to player management sets us apart in an industry that too often focuses only on the next deal.</p>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="rounded-2xl border border-gray-200 bg-white p-7">
                    <p class="font-display text-5xl text-accent-500">{{ $playerCount }}</p>
                    <p class="mt-1 text-sm text-gray-400">Players represented</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-7 mt-6">
                    <p class="font-display text-5xl text-accent-500">{{ $postCount }}</p>
                    <p class="mt-1 text-sm text-gray-400">News articles published</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-7">
                    <p class="font-display text-5xl text-accent-500">24</p>
                    <p class="mt-1 text-sm text-gray-400">Tournaments organized</p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-7 mt-6">
                    <p class="font-display text-5xl text-accent-500">15+</p>
                    <p class="mt-1 text-sm text-gray-400">Years of experience</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================== MISSION & VISION ======================== --}}
    <section class="border-y border-gray-200 bg-accent-600/50">
        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="grid gap-8 md:grid-cols-2">
                <div class="rounded-2xl border border-gray-200 bg-white p-8">
                    <div class="mb-4 grid size-12 place-items-center rounded-xl bg-accent-500/15 text-accent-500">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" /></svg>
                    </div>
                    <h3 class="font-display text-2xl uppercase tracking-wide text-black">Our Mission</h3>
                    <p class="mt-4 text-gray-500 leading-relaxed">
                        To discover, develop and represent exceptional athletic talent — providing world-class management, strategic career guidance and brand partnership opportunities that allow our players to focus on what they do best: perform at the highest level.
                    </p>
                </div>
                <div class="rounded-2xl border border-gray-200 bg-white p-8">
                    <div class="mb-4 grid size-12 place-items-center rounded-xl bg-accent-500/15 text-accent-500">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                    </div>
                    <h3 class="font-display text-2xl uppercase tracking-wide text-black">Our Vision</h3>
                    <p class="mt-4 text-gray-500 leading-relaxed">
                        To be the most trusted and innovative player management platform in the region — recognized for integrity, results, and the caliber of athletes we represent. We envision a future where every talented player, regardless of background, has access to professional representation.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================= MILESTONES ============================ --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <x-section-heading eyebrow="Our Journey" title="Key Milestones" :align="'center'" />
        <div class="relative mx-auto max-w-3xl">
            <div class="absolute left-4 top-0 bottom-0 w-px bg-accent-500/20 md:left-1/2"></div>
            @foreach ([
                ['year' => '2010', 'title' => 'Founded', 'text' => 'Sportika was established with a mission to transform player representation.'],
                ['year' => '2014', 'title' => 'First 50 Players', 'text' => 'Reached our first milestone of 50 registered players across multiple sports.'],
                ['year' => '2018', 'title' => 'International Expansion', 'text' => 'Began representing players in international tournaments and leagues.'],
                ['year' => '2022', 'title' => 'Digital Platform Launch', 'text' => 'Launched our digital platform for player profiles, scouting, and brand partnerships.'],
                ['year' => '2026', 'title' => '100+ Players Strong', 'text' => 'Now representing over 100 athletes with a dedicated team of professionals.'],
            ] as $i => $milestone)
                <div class="relative mb-10 pl-12 md:pl-0 @if($i % 2 === 0) md:pr-[52%] md:text-right @else md:pl-[52%] @endif">
                    <div class="absolute left-2 top-1 size-4 rounded-full border-2 border-blue-400 bg-white md:left-1/2 md:-translate-x-1/2"></div>
                    <div class="rounded-2xl border border-gray-200 bg-white p-5">
                        <span class="font-display text-2xl text-accent-500">{{ $milestone['year'] }}</span>
                        <h4 class="mt-1 text-lg font-semibold text-black">{{ $milestone['title'] }}</h4>
                        <p class="mt-2 text-sm text-gray-400">{{ $milestone['text'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ======================== MEET THE TEAM ========================== --}}
    @if ($teamMembers->isNotEmpty())
        <section class="border-t border-gray-200 bg-accent-600/50">
            <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
                <x-section-heading eyebrow="The people behind Sportika" title="Our Team" :align="'center'" :inverted="true" />
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($teamMembers as $member)
                        <a href="{{ route('team.show', $member->slug) }}" class="group rounded-2xl border border-gray-200 bg-white p-6 text-center transition hover:-translate-y-1 hover:border-accent-400">
                            <div class="mx-auto mb-4 size-24 overflow-hidden rounded-full border-2 border-accent-400/20 bg-gray-700">
                                <img src="{{ $member->photo_url ?? asset('images/player-fallback.svg') }}" alt="{{ $member->name }}" class="size-full object-cover">
                            </div>
                            <h4 class="font-display text-xl tracking-wide text-black">{{ $member->name }}</h4>
                            <p class="mt-1 text-sm text-accent-500">{{ $member->designation }}</p>
                        </a>
                    @endforeach
                </div>
                <div class="mt-10 text-center">
                    <a href="{{ route('team') }}" class="rounded-full border border-accent-300 px-6 py-3 text-sm font-bold uppercase tracking-wider text-accent-400 transition hover:bg-accent-500/10">
                        View full team →
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- =========================== CTA ================================ --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl border border-accent-400/20 bg-gradient-to-br from-accent-600 to-accent-600 px-8 py-16 text-center sm:px-16">
            <div class="bg-diagonal absolute inset-0"></div>
            <div class="relative">
                <h2 class="font-display text-4xl uppercase tracking-wide text-white sm:text-5xl">Work with us</h2>
                <p class="mx-auto mt-4 max-w-xl text-lg text-blue-200">
                    Whether you are a player, brand, or organizer — we would love to hear from you.
                </p>
                <div class="mt-10 flex flex-wrap justify-center gap-4">
                    <a href="{{ route('contact') }}" class="rounded-full bg-white px-8 py-4 text-sm font-bold uppercase tracking-wider text-accent-600 transition hover:bg-blue-50">
                        Contact Us
                    </a>
                    <a href="{{ route('membership.player') }}" class="rounded-full border border-white/30 px-8 py-4 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-white/10">
                        Join as Player
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('layouts.public', ['settings' => $settings])

@section('title', $settings->site_name.' — '.$settings->tagline)

@section('content')
    {{-- ============================== Hero ============================== --}}
    <section class="relative overflow-hidden bg-pitch-900">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="absolute -top-32 right-0 size-96 rounded-full bg-accent-400/10 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-24 sm:px-6 sm:py-32 lg:px-8">
            <div class="max-w-3xl">
                <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-accent-400/30 bg-accent-400/10 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.25em] text-accent-300">
                    ⚽ Player Management Agency
                </p>
                <h1 class="font-display text-5xl uppercase leading-[0.95] tracking-wide text-white sm:text-7xl">
                    {{ $settings->hero_title ?? 'Where Talent Meets Opportunity' }}
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-relaxed text-slate-400">
                    {{ $settings->hero_subtitle ?? 'Discover our squad of exceptional athletes, follow the latest news, and get in touch with our team.' }}
                </p>
                <div class="mt-9 flex flex-wrap gap-4">
                    <a
                        href="{{ route('players.index') }}"
                        class="rounded-full bg-accent-400 px-7 py-3.5 text-sm font-bold uppercase tracking-wider text-pitch-950 transition hover:bg-accent-300"
                    >
                        Explore players
                    </a>
                    <a
                        href="{{ route('contact') }}"
                        class="rounded-full border border-white/20 px-7 py-3.5 text-sm font-bold uppercase tracking-wider text-white transition hover:border-accent-400/60 hover:text-accent-300"
                    >
                        Contact us
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================= Featured players ======================== --}}
    @if ($featuredPlayers->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <x-section-heading eyebrow="The squad" title="Featured players" />
                <a href="{{ route('players.index') }}" class="mb-10 text-sm font-bold uppercase tracking-wider text-accent-400 hover:text-accent-300">
                    View full directory →
                </a>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($featuredPlayers as $player)
                    <x-player-card :player="$player" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- ============================ About teaser ========================= --}}
    <section class="border-y border-white/10 bg-pitch-900">
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:px-8">
            <div>
                <x-section-heading eyebrow="About us" title="{{ $settings->about_title ?? 'Built for the beautiful game' }}" />
                <div class="rich-content">
                    {!! Str::limit(strip_tags($settings->about_body ?? '<p>Our mission is simple: to develop, promote and protect the careers of outstanding footballers around the world.</p>'), 260) !!}
                </div>
                <a
                    href="{{ route('about') }}"
                    class="mt-7 inline-block rounded-full border border-accent-400/40 px-6 py-3 text-sm font-bold uppercase tracking-wider text-accent-300 transition hover:bg-accent-400/10"
                >
                    Learn more
                </a>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="rounded-2xl border border-white/10 bg-pitch-800 p-7">
                    <p class="font-display text-5xl text-accent-400">{{ \App\Models\Player::published()->count() }}</p>
                    <p class="mt-1 text-sm text-slate-400">Players represented</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-pitch-800 p-7 mt-6">
                    <p class="font-display text-5xl text-accent-400">{{ \App\Models\Post::published()->count() }}</p>
                    <p class="mt-1 text-sm text-slate-400">Articles published</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-pitch-800 p-7">
                    <p class="font-display text-5xl text-accent-400">15+</p>
                    <p class="mt-1 text-sm text-slate-400">Years of experience</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-pitch-800 p-7 mt-6">
                    <p class="font-display text-5xl text-accent-400">100%</p>
                    <p class="mt-1 text-sm text-slate-400">Commitment</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================ Latest news ========================== --}}
    @if ($latestPosts->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <x-section-heading eyebrow="Newsroom" title="Latest news" />
                <a href="{{ route('posts.index') }}" class="mb-10 text-sm font-bold uppercase tracking-wider text-accent-400 hover:text-accent-300">
                    All articles →
                </a>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($latestPosts as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- =============================== CTA =============================== --}}
    <section class="bg-pitch-900">
        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-3xl border border-accent-400/20 bg-gradient-to-br from-pitch-800 to-pitch-900 px-8 py-14 text-center sm:px-16">
                <div class="bg-diagonal absolute inset-0"></div>
                <div class="relative">
                    <h2 class="font-display text-4xl uppercase tracking-wide text-white sm:text-5xl">
                        Ready to play at the next level?
                    </h2>
                    <p class="mx-auto mt-4 max-w-xl text-slate-400">
                        Whether you are a player seeking representation or a club looking for talent — our door is open.
                    </p>
                    <a
                        href="{{ route('contact') }}"
                        class="mt-8 inline-block rounded-full bg-accent-400 px-8 py-4 text-sm font-bold uppercase tracking-wider text-pitch-950 transition hover:bg-accent-300"
                    >
                        Get in touch
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

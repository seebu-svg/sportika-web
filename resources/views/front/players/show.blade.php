@extends('layouts.public')

@section('title', $player->name.' — Player Portfolio')
@section('meta_description', Str::limit(strip_tags($player->short_description ?? $player->bio), 160))

@section('content')
    {{-- ============================== Hero =============================== --}}
    <section class="relative overflow-hidden bg-pitch-900">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="absolute -top-40 right-0 size-[32rem] rounded-full bg-accent-400/10 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <nav class="mb-6 text-sm text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-accent-300">Home</a>
                <span class="mx-2 text-slate-600">/</span>
                <a href="{{ route('players.index') }}" class="hover:text-accent-300">Players</a>
                <span class="mx-2 text-slate-600">/</span>
                <span class="text-slate-300">{{ $player->name }}</span>
            </nav>

            <div class="grid items-center gap-10 lg:grid-cols-5">
                <div class="lg:col-span-2">
                    <div class="relative mx-auto aspect-[3/4] max-w-sm overflow-hidden rounded-3xl border border-white/10 bg-pitch-800">
                        <img
                            src="{{ $player->photo_url ?? asset('images/player-fallback.svg') }}"
                            alt="{{ $player->name }}"
                            class="size-full object-cover"
                        >
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-pitch-950 to-transparent p-6">
                            @if ($player->jersey_number)
                                <span class="font-display text-7xl leading-none text-accent-400">
                                    {{ str_pad((string) $player->jersey_number, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <p class="mb-3 inline-flex items-center gap-2 rounded-full bg-accent-400 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.25em] text-pitch-950">
                        {{ $player->position }}
                    </p>
                    <h1 class="font-display text-5xl uppercase tracking-wide text-white sm:text-7xl">
                        {{ $player->name }}
                    </h1>

                    <div class="mt-5 flex flex-wrap gap-x-6 gap-y-2 text-sm text-slate-400">
                        @if ($player->current_club)
                            <span><strong class="text-white">Club:</strong> {{ $player->current_club }}</span>
                        @endif
                        @if ($player->nationality)
                            <span><strong class="text-white">Nationality:</strong> {{ $player->nationality }}</span>
                        @endif
                        @if ($player->age)
                            <span><strong class="text-white">Age:</strong> {{ $player->age }}</span>
                        @endif
                    </div>

                    @if ($player->short_description)
                        <p class="mt-6 max-w-2xl text-lg leading-relaxed text-slate-300">
                            {{ $player->short_description }}
                        </p>
                    @endif

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a
                            href="{{ route('contact') }}"
                            class="rounded-full bg-accent-400 px-6 py-3 text-sm font-bold uppercase tracking-wider text-pitch-950 transition hover:bg-accent-300"
                        >
                            Enquire about {{ Str::before($player->name, ' ') }}
                        </a>
                        <a
                            href="{{ route('players.index') }}"
                            class="rounded-full border border-white/20 px-6 py-3 text-sm font-bold uppercase tracking-wider text-white transition hover:border-accent-400/60 hover:text-accent-300"
                        >
                            Back to directory
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================ Vitals & stats ======================= --}}
    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @php
                $vitals = array_filter([
                    ['label' => 'Date of birth', 'value' => $player->date_of_birth?->format('d M Y')],
                    ['label' => 'Height', 'value' => $player->height_cm ? $player->height_cm.' cm' : null],
                    ['label' => 'Weight', 'value' => $player->weight_kg ? $player->weight_kg.' kg' : null],
                    ['label' => 'Preferred foot', 'value' => $player->preferred_foot],
                ]);
            @endphp
            @foreach ($vitals as $vital)
                <div class="rounded-2xl border border-white/10 bg-pitch-800 p-5">
                    <p class="text-xs uppercase tracking-wider text-slate-500">{{ $vital['label'] }}</p>
                    <p class="mt-1 font-display text-2xl text-white">{{ $vital['value'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <x-stat-card label="Appearances" :value="$player->appearances" />
            <x-stat-card label="Goals" :value="$player->goals" />
            <x-stat-card label="Assists" :value="$player->assists" />
            <x-stat-card label="Clean sheets" :value="$player->clean_sheets" />
        </div>
    </section>

    {{-- ================================ Bio ============================== --}}
    @if (filled($player->bio))
        <section class="border-y border-white/10 bg-pitch-900">
            <div class="mx-auto max-w-4xl px-4 py-14 sm:px-6 lg:px-8">
                <x-section-heading eyebrow="Profile" title="Biography" />
                <div class="rich-content">
                    {!! $player->bio !!}
                </div>
            </div>
        </section>
    @endif

    {{-- ============================== Honours ============================ --}}
    @if (! empty($player->honours))
        <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <x-section-heading eyebrow="Trophies" title="Honours & awards" />
            <ul class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($player->honours as $award => $season)
                    <li class="flex items-start gap-3 rounded-2xl border border-white/10 bg-pitch-800 p-5">
                        <span class="grid size-10 shrink-0 place-items-center rounded-full bg-accent-400/15 text-accent-400">
                            <svg class="size-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2 9.2 8.6 2 9.3l5.5 4.8L5.8 22 12 18.3 18.2 22l-1.7-7.9L22 9.3l-7.2-.7z"/></svg>
                        </span>
                        <div>
                            <p class="font-semibold text-white">{{ $award }}</p>
                            <p class="text-sm text-slate-400">{{ $season }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    {{-- ============================== Socials ============================ --}}
    @if (! empty($player->social_links))
        <section class="mx-auto max-w-7xl px-4 pb-14 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-white/10 bg-pitch-800 p-6">
                <h3 class="font-display text-xl tracking-wider text-white">Follow {{ $player->name }}</h3>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($player->social_links as $platform => $url)
                        <a
                            href="{{ $url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="rounded-full border border-white/10 px-4 py-2 text-sm text-slate-300 transition hover:border-accent-400/50 hover:text-accent-300"
                        >
                            {{ $platform }}
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- =========================== Related players ======================= --}}
    @if ($relatedPlayers->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
            <x-section-heading eyebrow="More players" title="Similar talent" align="center" />
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($relatedPlayers as $related)
                    <x-player-card :player="$related" />
                @endforeach
            </div>
        </section>
    @endif
@endsection

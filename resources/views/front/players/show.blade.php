@extends('layouts.public')

@section('title', $player->name.' — Player Profile')
@section('meta_description', Str::limit(strip_tags($player->short_description ?? $player->bio), 160))

@php
    $badge = $player->status_badge ?? 'unverified';
    $badgeColors = match($badge) {
        'verified' => 'bg-accent-500 text-white',
        'featured' => 'bg-amber-400 text-black',
        default => 'bg-gray-500 text-white',
    };
@endphp

@section('content')
    {{-- ============================== HERO =============================== --}}
    <section class="relative overflow-hidden bg-accent-600">
        {{-- Cover image --}}
        @if ($player->cover_image_url)
            <div class="absolute inset-0">
                <img src="{{ $player->cover_image_url }}" alt="" class="size-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-accent-600/70 via-accent-600/20 to-accent-600"></div>
            </div>
        @else
            <div class="bg-diagonal absolute inset-0"></div>
            <div class="absolute -top-40 right-0 size-[32rem] rounded-full bg-accent-500/10 blur-3xl"></div>
        @endif

        <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <nav class="mb-6 text-sm text-gray-400">
                <a href="{{ route('home') }}" class="hover:text-accent-400">Home</a>
                <span class="mx-2 text-gray-700">/</span>
                <a href="{{ route('players.index') }}" class="hover:text-accent-400">Players</a>
                <span class="mx-2 text-gray-700">/</span>
                <span class="text-gray-700">{{ $player->name }}</span>
            </nav>

            <div class="grid items-center gap-10 lg:grid-cols-5">
                <div class="lg:col-span-2">
                    <div class="relative mx-auto aspect-[3/4] max-w-sm overflow-hidden rounded-3xl border border-gray-200 bg-white">
                        <img
                            src="{{ $player->photo_url ?? asset('images/player-fallback.svg') }}"
                            alt="{{ $player->name }}"
                            class="size-full object-cover"
                        >
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-accent-600/70 to-transparent p-6">
                            @if ($player->jersey_number)
                                <span class="font-display text-7xl leading-none text-accent-500">
                                    {{ str_pad((string) $player->jersey_number, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="inline-flex rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-[0.25em] {{ $badgeColors }}">
                            {{ ucfirst($badge) }}
                        </span>
                        @if ($player->sport)
                            <span class="inline-flex rounded-full border border-white/20 px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-white">
                                {{ $player->sport }}
                            </span>
                        @endif
                        @if ($player->level)
                            <span class="inline-flex rounded-full border border-gray-200 px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-gray-400">
                                {{ $player->level }}
                            </span>
                        @endif
                    </div>

                    <h1 class="mt-4 font-display text-5xl uppercase tracking-wide text-black sm:text-7xl">
                        {{ $player->name }}
                    </h1>

                    <div class="mt-5 flex flex-wrap gap-x-6 gap-y-2 text-sm text-gray-400">
                        @if ($player->current_club)
                            <span><strong class="text-black">Club:</strong> {{ $player->current_club }}</span>
                        @endif
                        @if ($player->city)
                            <span><strong class="text-black">City:</strong> {{ $player->city }}</span>
                        @elseif ($player->nationality)
                            <span><strong class="text-black">Nationality:</strong> {{ $player->nationality }}</span>
                        @endif
                        @if ($player->age)
                            <span><strong class="text-black">Age:</strong> {{ $player->age }}</span>
                        @endif
                    </div>

                    @if ($player->short_description)
                        <p class="mt-6 max-w-2xl text-lg leading-relaxed text-gray-700">
                            {{ $player->short_description }}
                        </p>
                    @endif

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('contact') }}" class="rounded-full bg-accent-500 px-6 py-3 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-accent-400">
                            Inquire about {{ Str::before($player->name, ' ') }}
                        </a>
                        <a href="{{ route('membership.player') }}" class="rounded-full border border-white/30 px-6 py-3 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-white/10">
                            Make Your Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================ VITALS & STATS ======================= --}}
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
                <div class="card-shadow rounded-2xl border border-gray-200 bg-white p-5">
                    <p class="text-xs uppercase tracking-wider text-gray-400">{{ $vital['label'] }}</p>
                    <p class="mt-1 font-display text-2xl text-black">{{ $vital['value'] }}</p>
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

    {{-- ================================ BIO ============================== --}}
    @if (filled($player->bio))
        <section class="border-y border-gray-200 bg-accent-600">
            <div class="mx-auto max-w-4xl px-4 py-14 sm:px-6 lg:px-8">
                <x-section-heading eyebrow="Profile" title="Biography" :inverted="true" />
                <div class="rich-content">
                    {!! $player->bio !!}
                </div>
            </div>
        </section>
    @endif

    {{-- ============================ ACHIEVEMENTS ========================= --}}
    @if (! empty($player->achievements) || ! empty($player->honours))
        <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <x-section-heading eyebrow="Trophies & milestones" title="Achievements" />
            <ul class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @if (! empty($player->achievements))
                    @foreach ($player->achievements as $achievement)
                        <li class="card-shadow flex items-start gap-3 rounded-2xl border border-gray-200 bg-white p-5">
                            <span class="grid size-10 shrink-0 place-items-center rounded-full bg-accent-500/15 text-accent-500">
                                <svg class="size-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2 9.2 8.6 2 9.3l5.5 4.8L5.8 22 12 18.3 18.2 22l-1.7-7.9L22 9.3l-7.2-.7z"/></svg>
                            </span>
                            <div>
                                <p class="font-semibold text-black">{{ $achievement['title'] ?? 'Achievement' }}</p>
                                @if (! empty($achievement['year']))
                                    <p class="text-xs text-accent-500">{{ $achievement['year'] }}</p>
                                @endif
                                @if (! empty($achievement['description']))
                                    <p class="mt-1 text-sm text-gray-400">{{ $achievement['description'] }}</p>
                                @endif
                            </div>
                        </li>
                    @endforeach
                @endif
                @if (! empty($player->honours))
                    @foreach ($player->honours as $award => $season)
                        <li class="card-shadow flex items-start gap-3 rounded-2xl border border-gray-200 bg-white p-5">
                            <span class="grid size-10 shrink-0 place-items-center rounded-full bg-accent-500/15 text-accent-500">
                                <svg class="size-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2 9.2 8.6 2 9.3l5.5 4.8L5.8 22 12 18.3 18.2 22l-1.7-7.9L22 9.3l-7.2-.7z"/></svg>
                            </span>
                            <div>
                                <p class="font-semibold text-black">{{ $award }}</p>
                                <p class="text-sm text-gray-400">{{ $season }}</p>
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>
        </section>
    @endif

    {{-- ============================ MEDIA & NEWS ========================= --}}
    @if (! empty($player->media) || ! empty($player->press_mentions))
        <section class="border-y border-gray-200 bg-pitch-100">
            <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
                <x-section-heading eyebrow="In the spotlight" title="Media & News" />

                @if (! empty($player->media))
                    <div class="mb-8">
                        <h4 class="mb-4 text-sm font-bold uppercase tracking-wider text-gray-400">Photos & Videos</h4>
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($player->media as $item)
                                @if (str_contains($item['url'] ?? '', 'youtube') || str_contains($item['url'] ?? '', 'instagram'))
                                    <a href="{{ $item['url'] ?? '#' }}" target="_blank" rel="noopener" class="group relative aspect-video overflow-hidden rounded-2xl border border-gray-200 bg-white">
                                        <div class="bg-diagonal absolute inset-0"></div>
                                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                                            <div class="grid size-12 place-items-center rounded-full bg-accent-500/20 text-accent-500 transition group-hover:scale-110">
                                                <svg class="size-5 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
                                            </div>
                                            <p class="mt-3 text-xs text-gray-400">{{ $item['type'] ?? 'Video' }}</p>
                                        </div>
                                    </a>
                                @else
                                    <div class="relative aspect-video overflow-hidden rounded-2xl border border-gray-200 bg-white">
                                        <img src="{{ $item['url'] ?? '' }}" alt="{{ $item['caption'] ?? '' }}" class="size-full object-cover">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (! empty($player->press_mentions))
                    <div>
                        <h4 class="mb-4 text-sm font-bold uppercase tracking-wider text-gray-400">Press & Mentions</h4>
                        <div class="space-y-3">
                            @foreach ($player->press_mentions as $mention)
                                <a href="{{ $mention['link'] ?? '#' }}" target="_blank" rel="noopener" class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-4 transition hover:border-accent-400">
                                    <span class="grid size-10 shrink-0 place-items-center rounded-full bg-accent-500/15 text-accent-500">
                                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" /></svg>
                                    </span>
                                    <div>
                                        <p class="text-sm font-medium text-black">{{ $mention['publication'] ?? 'Press mention' }}</p>
                                        @if (! empty($mention['date']))
                                            <p class="text-xs text-gray-400">{{ $mention['date'] }}</p>
                                        @endif
                                    </div>
                                    <span class="ml-auto text-xs font-bold text-accent-500">Read →</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- ============================= SOCIALS ============================= --}}
    @if (! empty($player->social_links))
        <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="card-shadow rounded-2xl border border-gray-200 bg-white p-6">
                <h3 class="font-display text-xl tracking-wider text-black">Follow {{ $player->name }}</h3>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($player->social_links as $platform => $url)
                        <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="rounded-full border border-gray-200 px-4 py-2 text-sm text-gray-700 transition hover:border-accent-400 hover:text-accent-400">
                            {{ $platform }}
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ========================== SHARE & CTA ============================ --}}
    <section class="mx-auto max-w-7xl px-4 pb-14 sm:px-6 lg:px-8">
        <div class="rounded-2xl border border-accent-400/20 bg-white p-6">
            <div class="flex flex-wrap items-center justify-between gap-6">
                <div>
                    <h3 class="font-display text-xl tracking-wider text-black">Share this profile</h3>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <a href="https://wa.me/?text={{ urlencode($player->name.' — Player Profile '.route('players.show', $player->slug)) }}" target="_blank" rel="noopener" class="rounded-full border border-gray-200 px-4 py-2 text-sm text-gray-700 transition hover:border-green-500/50 hover:text-green-400">
                            WhatsApp
                        </a>
                        <a href="https://www.instagram.com/" target="_blank" rel="noopener" class="rounded-full border border-gray-200 px-4 py-2 text-sm text-gray-700 transition hover:border-pink-500/50 hover:text-pink-400">
                            Instagram Story
                        </a>
                        <button onclick="navigator.clipboard.writeText('{{ route('players.show', $player->slug) }}'); this.textContent='Copied!';" class="rounded-full border border-gray-200 px-4 py-2 text-sm text-gray-700 transition hover:border-accent-400 hover:text-accent-400">
                            Copy Link
                        </button>
                    </div>
                </div>
                <a href="{{ route('membership.player') }}" class="rounded-full bg-accent-500 px-6 py-3 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-accent-400">
                    Make Your Profile
                </a>
            </div>
        </div>
    </section>

    {{-- =========================== RELATED =============================== --}}
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

@extends('layouts.public', ['settings' => $settings])

@section('title', 'Podcast — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-blue-700">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="absolute -top-40 right-0 size-[32rem] rounded-full bg-blue-600/8 blur-3xl"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Listen In"
                title="The Sportika Podcast"
                subtitle="Conversations with players, coaches and industry insiders."
            />
            <div class="mt-8 text-center">
                <a href="{{ route('podcast.apply') }}" class="rounded-full bg-blue-600 px-6 py-3 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-blue-500">
                    Apply for the Podcast
                </a>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        @if ($episodes->isEmpty())
            <div class="rounded-2xl border border-dashed border-white/15 bg-blue-700 px-6 py-20 text-center">
                <p class="font-display text-3xl tracking-wide text-white">Episodes coming soon</p>
                <p class="mt-2 text-slate-400">Episode listings with show notes, audio players and archives are on the way. Subscribe soon on your favourite platform.</p>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($episodes as $episode)
                    <div class="group overflow-hidden rounded-2xl border border-slate-200 bg-white transition hover:-translate-y-1 hover:border-blue-300">
                        <div class="relative aspect-video overflow-hidden">
                            @if ($episode->thumbnail_url)
                                <img src="{{ $episode->thumbnail_url }}" alt="{{ $episode->title }}" class="size-full object-cover transition duration-500 group-hover:scale-105">
                            @else
                                <div class="bg-diagonal absolute inset-0"></div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="grid size-14 place-items-center rounded-full bg-blue-600/20 text-blue-600">
                                        <svg class="size-6 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <p class="text-xs text-slate-400">{{ $episode->published_at?->format('d M Y') ?? 'Coming soon' }}</p>
                            <h3 class="mt-2 text-lg font-semibold text-pitch-950 transition group-hover:text-blue-500">{{ $episode->title }}</h3>
                            @if ($episode->guest_name)
                                <p class="mt-1 text-sm text-blue-600">
                                    with
                                    @if ($episode->guestPlayer)
                                        <a href="{{ route('players.show', $episode->guestPlayer->slug) }}" class="underline hover:text-blue-500">{{ $episode->guest_name }}</a>
                                    @else
                                        {{ $episode->guest_name }}
                                    @endif
                                </p>
                            @endif
                            @if ($episode->description)
                                <p class="mt-2 line-clamp-2 text-sm text-slate-400">{{ $episode->description }}</p>
                            @endif
                            <div class="mt-4 flex flex-wrap gap-2">
                                @if ($episode->youtube_url)<a href="{{ $episode->youtube_url }}" target="_blank" class="rounded-full border border-slate-200 px-3 py-1 text-xs text-slate-600 hover:border-red-500/50 hover:text-red-400">YouTube</a>@endif
                                @if ($episode->spotify_url)<a href="{{ $episode->spotify_url }}" target="_blank" class="rounded-full border border-slate-200 px-3 py-1 text-xs text-slate-600 hover:border-green-500/50 hover:text-green-400">Spotify</a>@endif
                                @if ($episode->apple_url)<a href="{{ $episode->apple_url }}" target="_blank" class="rounded-full border border-slate-200 px-3 py-1 text-xs text-slate-600 hover:border-purple-500/50 hover:text-purple-400">Apple</a>@endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection

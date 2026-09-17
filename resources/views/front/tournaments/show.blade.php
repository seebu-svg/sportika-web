@extends('layouts.public', ['settings' => $settings])

@section('title', $tournament->name.' — Tournament')

@section('content')
    <section class="relative overflow-hidden bg-pitch-900">
        @if ($tournament->cover_url)
            <div class="absolute inset-0">
                <img src="{{ $tournament->cover_url }}" alt="{{ $tournament->name }}" class="size-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-pitch-950/60 via-pitch-950/80 to-pitch-900"></div>
            </div>
        @else
            <div class="bg-diagonal absolute inset-0"></div>
        @endif
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <nav class="mb-6 text-sm text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-accent-300">Home</a>
                <span class="mx-2 text-slate-600">/</span>
                <a href="{{ route('tournaments.index') }}" class="hover:text-accent-300">Tournaments</a>
                <span class="mx-2 text-slate-600">/</span>
                <span class="text-slate-300">{{ Str::limit($tournament->name, 40) }}</span>
            </nav>
            @php $statusColors = match($tournament->status) { 'ongoing' => 'bg-green-500/15 text-green-400', 'completed' => 'bg-slate-500/15 text-slate-400', default => 'bg-accent-400/15 text-accent-400' }; @endphp
            <span class="inline-block rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wider {{ $statusColors }}">{{ ucfirst($tournament->status) }}</span>
            <h1 class="mt-4 font-display text-5xl uppercase tracking-wide text-white sm:text-6xl">{{ $tournament->name }}</h1>
            <div class="mt-4 flex flex-wrap gap-x-6 gap-y-2 text-sm text-slate-400">
                @if ($tournament->sport)<span><strong class="text-white">Sport:</strong> {{ $tournament->sport }}</span>@endif
                @if ($tournament->city)<span><strong class="text-white">City:</strong> {{ $tournament->city }}</span>@endif
                @if ($tournament->start_date)<span><strong class="text-white">Date:</strong> {{ $tournament->start_date->format('d M Y') }}{{ $tournament->end_date ? ' – '.$tournament->end_date->format('d M Y') : '' }}</span>@endif
            </div>
        </div>
    </section>

    {{-- Overview --}}
    @if (filled($tournament->description))
        <section class="mx-auto max-w-4xl px-4 py-14 sm:px-6 lg:px-8">
            <x-section-heading eyebrow="Overview" title="About this tournament" />
            <div class="rich-content">{!! $tournament->description !!}</div>
        </section>
    @endif

    {{-- Fixtures --}}
    @if (! empty($tournament->fixtures))
        <section class="border-y border-white/10 bg-pitch-900/50">
            <div class="mx-auto max-w-4xl px-4 py-14 sm:px-6 lg:px-8">
                <x-section-heading eyebrow="Schedule" title="Fixtures & Schedule" />
                <div class="space-y-3">
                    @foreach ($tournament->fixtures as $fixture)
                        <div class="flex items-center justify-between rounded-2xl border border-white/10 bg-pitch-800 p-4">
                            <div>
                                <p class="text-sm font-medium text-white">{{ $fixture['match'] ?? $fixture['title'] ?? 'Match' }}</p>
                                @if (! empty($fixture['date']))<p class="text-xs text-slate-500">{{ $fixture['date'] }}</p>@endif
                            </div>
                            @if (! empty($fixture['venue']))<span class="text-xs text-slate-400">{{ $fixture['venue'] }}</span>@endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Results --}}
    @if (! empty($tournament->results))
        <section class="mx-auto max-w-4xl px-4 py-14 sm:px-6 lg:px-8">
            <x-section-heading eyebrow="Results" title="Final Results" />
            <div class="space-y-3">
                @foreach ($tournament->results as $result)
                    <div class="rounded-2xl border border-white/10 bg-pitch-800 p-4">
                        <p class="text-sm font-medium text-white">{{ $result['match'] ?? $result['title'] ?? '' }}</p>
                        <p class="mt-1 text-sm text-accent-400">{{ $result['score'] ?? $result['result'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Participating players --}}
    @if ($players->isNotEmpty())
        <section class="border-y border-white/10 bg-pitch-900/50">
            <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
                <x-section-heading eyebrow="The competitors" title="Participating Players" />
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($players as $player)
                        <x-player-card :player="$player" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Gallery --}}
    @if (! empty($tournament->gallery))
        <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <x-section-heading eyebrow="Moments" title="Tournament Gallery" />
            <div class="grid gap-4 grid-cols-2 md:grid-cols-4">
                @foreach ($tournament->gallery as $image)
                    <div class="aspect-square overflow-hidden rounded-2xl border border-white/10 bg-pitch-800">
                        <img src="{{ is_string($image) ? $image : ($image['url'] ?? '') }}" alt="" class="size-full object-cover">
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <section class="mx-auto max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <a href="{{ route('tournaments.index') }}" class="rounded-full border border-white/20 px-6 py-3 text-sm font-bold uppercase tracking-wider text-white transition hover:border-accent-400/60 hover:text-accent-300">&larr; All tournaments</a>
    </section>
@endsection

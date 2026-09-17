@extends('layouts.public', ['settings' => $settings])

@section('title', $tournament->name.' — Tournament')

@section('content')
    <section class="relative overflow-hidden bg-accent-600">
        @if ($tournament->cover_url)
            <div class="absolute inset-0">
                <img src="{{ $tournament->cover_url }}" alt="{{ $tournament->name }}" class="size-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-accent-600/70 via-accent-600/20 to-accent-600"></div>
            </div>
        @else
            <div class="bg-diagonal absolute inset-0"></div>
        @endif
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <nav class="mb-6 text-sm text-gray-400">
                <a href="{{ route('home') }}" class="hover:text-accent-400">Home</a>
                <span class="mx-2 text-gray-700">/</span>
                <a href="{{ route('tournaments.index') }}" class="hover:text-accent-400">Tournaments</a>
                <span class="mx-2 text-gray-700">/</span>
                <span class="text-gray-700">{{ Str::limit($tournament->name, 40) }}</span>
            </nav>
            @php $statusColors = match($tournament->status) { 'ongoing' => 'bg-green-500/15 text-green-400', 'completed' => 'bg-gray-500/15 text-gray-400', default => 'bg-accent-500/15 text-accent-500' }; @endphp
            <span class="inline-block rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wider {{ $statusColors }}">{{ ucfirst($tournament->status) }}</span>
            <h1 class="mt-4 font-display text-5xl uppercase tracking-wide text-white sm:text-6xl">{{ $tournament->name }}</h1>
            <div class="mt-4 flex flex-wrap gap-x-6 gap-y-2 text-sm text-gray-400">
                @if ($tournament->sport)<span><strong class="text-black">Sport:</strong> {{ $tournament->sport }}</span>@endif
                @if ($tournament->city)<span><strong class="text-black">City:</strong> {{ $tournament->city }}</span>@endif
                @if ($tournament->start_date)<span><strong class="text-black">Date:</strong> {{ $tournament->start_date->format('d M Y') }}{{ $tournament->end_date ? ' – '.$tournament->end_date->format('d M Y') : '' }}</span>@endif
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
        <section class="border-y border-gray-200 bg-accent-600/50">
            <div class="mx-auto max-w-4xl px-4 py-14 sm:px-6 lg:px-8">
                <x-section-heading eyebrow="Schedule" title="Fixtures & Schedule" :inverted="true" />
                <div class="space-y-3">
                    @foreach ($tournament->fixtures as $fixture)
                        <div class="flex items-center justify-between rounded-2xl border border-gray-200 bg-white p-4">
                            <div>
                                <p class="text-sm font-medium text-black">{{ $fixture['match'] ?? $fixture['title'] ?? 'Match' }}</p>
                                @if (! empty($fixture['date']))<p class="text-xs text-gray-400">{{ $fixture['date'] }}</p>@endif
                            </div>
                            @if (! empty($fixture['venue']))<span class="text-xs text-gray-400">{{ $fixture['venue'] }}</span>@endif
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
                    <div class="rounded-2xl border border-gray-200 bg-white p-4">
                        <p class="text-sm font-medium text-black">{{ $result['match'] ?? $result['title'] ?? '' }}</p>
                        <p class="mt-1 text-sm text-accent-500">{{ $result['score'] ?? $result['result'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Participating players --}}
    @if ($players->isNotEmpty())
        <section class="border-y border-gray-200 bg-accent-600/50">
            <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
                <x-section-heading eyebrow="The competitors" title="Participating Players" :inverted="true" />
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
                    <div class="aspect-square overflow-hidden rounded-2xl border border-gray-200 bg-white">
                        <img src="{{ is_string($image) ? $image : ($image['url'] ?? '') }}" alt="" class="size-full object-cover">
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <section class="mx-auto max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <a href="{{ route('tournaments.index') }}" class="rounded-full border border-white/20 px-6 py-3 text-sm font-bold uppercase tracking-wider text-black transition hover:border-accent-400 hover:text-accent-400">&larr; All tournaments</a>
    </section>
@endsection

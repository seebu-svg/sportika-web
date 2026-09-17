@extends('layouts.public')

@section('title', 'Players Directory')

@section('content')
    <section class="relative overflow-hidden bg-blue-700">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="The squad"
                title="Players Directory"
                subtitle="Browse our represented athletes — search, filter and discover talent."
            />

            {{-- Filters --}}
            <form method="GET" action="{{ route('players.index') }}" class="grid gap-3 rounded-2xl border border-slate-200 bg-white p-4 sm:grid-cols-2 lg:grid-cols-5">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search name, sport, club…"
                    class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-pitch-950 placeholder-slate-500 outline-none focus:border-blue-400"
                >
                <select name="city" class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-pitch-950 outline-none focus:border-blue-400">
                    <option value="">All cities</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city }}" @selected(request('city') === $city)>{{ $city }}</option>
                    @endforeach
                </select>
                <select name="level" class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-pitch-950 outline-none focus:border-blue-400">
                    <option value="">All levels</option>
                    @foreach ($levels as $level)
                        <option value="{{ $level }}" @selected(request('level') === $level)>{{ $level }}</option>
                    @endforeach
                </select>
                <select name="sort" class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-pitch-950 outline-none focus:border-blue-400">
                    <option value="featured" @selected(request('sort', 'featured') === 'featured')>Featured First</option>
                    <option value="newest" @selected(request('sort') === 'newest')>Newest</option>
                    <option value="alpha" @selected(request('sort') === 'alpha')>Alphabetical (A–Z)</option>
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-blue-500">
                        Filter
                    </button>
                    <a href="{{ route('players.index') }}" class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-bold uppercase tracking-wider text-slate-600 transition hover:border-blue-300 hover:text-blue-500">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        @if ($players->isEmpty())
            <div class="rounded-2xl border border-dashed border-white/15 bg-blue-700 px-6 py-20 text-center">
                <p class="font-display text-3xl tracking-wide text-white">No players found</p>
                <p class="mt-2 text-slate-400">Try adjusting the filters, or check back soon — new signings are announced regularly.</p>
            </div>
        @else
            <p class="mb-6 text-sm text-slate-400">{{ $players->total() }} player(s) found</p>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($players as $player)
                    <x-player-card :player="$player" />
                @endforeach
            </div>

            {{ $players->links('partials.pagination') }}
        @endif
    </section>
@endsection

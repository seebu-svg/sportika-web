@extends('layouts.public')

@section('title', 'Players Directory')

@section('content')
    <section class="relative overflow-hidden bg-pitch-900">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="The squad"
                title="Players Directory"
                subtitle="Browse our represented athletes and open their full portfolio."
            />

            {{-- Filters --}}
            <form method="GET" action="{{ route('players.index') }}" class="grid gap-3 rounded-2xl border border-white/10 bg-pitch-800 p-4 sm:grid-cols-2 lg:grid-cols-4">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search name or club…"
                    class="rounded-lg border border-white/10 bg-pitch-900 px-4 py-2.5 text-sm text-white placeholder-slate-500 outline-none focus:border-accent-400/60"
                >
                <select
                    name="position"
                    class="rounded-lg border border-white/10 bg-pitch-900 px-4 py-2.5 text-sm text-white outline-none focus:border-accent-400/60"
                >
                    <option value="">All positions</option>
                    @foreach ($positions as $position)
                        <option value="{{ $position }}" @selected(request('position') === $position)>{{ $position }}</option>
                    @endforeach
                </select>
                <select
                    name="nationality"
                    class="rounded-lg border border-white/10 bg-pitch-900 px-4 py-2.5 text-sm text-white outline-none focus:border-accent-400/60"
                >
                    <option value="">All nationalities</option>
                    @foreach ($nationalities as $nationality)
                        <option value="{{ $nationality }}" @selected(request('nationality') === $nationality)>{{ $nationality }}</option>
                    @endforeach
                </select>
                <div class="flex gap-2">
                    <button
                        type="submit"
                        class="flex-1 rounded-lg bg-accent-400 px-4 py-2.5 text-sm font-bold uppercase tracking-wider text-pitch-950 transition hover:bg-accent-300"
                    >
                        Filter
                    </button>
                    <a
                        href="{{ route('players.index') }}"
                        class="rounded-lg border border-white/10 px-4 py-2.5 text-sm font-bold uppercase tracking-wider text-slate-300 transition hover:border-accent-400/50 hover:text-accent-300"
                    >
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        @if ($players->isEmpty())
            <div class="rounded-2xl border border-dashed border-white/15 bg-pitch-900 px-6 py-20 text-center">
                <p class="font-display text-3xl tracking-wide text-white">No players found</p>
                <p class="mt-2 text-slate-400">Try adjusting the filters, or check back soon — new signings are announced regularly.</p>
            </div>
        @else
            <p class="mb-6 text-sm text-slate-500">{{ $players->total() }} player(s) found</p>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($players as $player)
                    <x-player-card :player="$player" />
                @endforeach
            </div>

            {{ $players->links('partials.pagination') }}
        @endif
    </section>
@endsection

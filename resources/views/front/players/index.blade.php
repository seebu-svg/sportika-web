@extends('layouts.public')

@section('title', 'Players Directory')

@section('content')
    <section class="relative overflow-hidden bg-accent-600">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="The squad"
                title="Players Directory"
                subtitle="Browse our represented athletes — search, filter and discover talent."
            :inverted="true"
            />

            {{-- Filters --}}
            <form method="GET" action="{{ route('players.index') }}" class="grid gap-3 rounded-2xl border border-gray-200 bg-white p-4 sm:grid-cols-2 lg:grid-cols-5">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search name, sport, club…"
                    class="rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400"
                >
                <select name="city" class="rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-accent-400">
                    <option value="">All cities</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city }}" @selected(request('city') === $city)>{{ $city }}</option>
                    @endforeach
                </select>
                <select name="level" class="rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-accent-400">
                    <option value="">All levels</option>
                    @foreach ($levels as $level)
                        <option value="{{ $level }}" @selected(request('level') === $level)>{{ $level }}</option>
                    @endforeach
                </select>
                <select name="sort" class="rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-accent-400">
                    <option value="featured" @selected(request('sort', 'featured') === 'featured')>Featured First</option>
                    <option value="newest" @selected(request('sort') === 'newest')>Newest</option>
                    <option value="alpha" @selected(request('sort') === 'alpha')>Alphabetical (A–Z)</option>
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 rounded-lg bg-accent-500 px-4 py-2.5 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-accent-400">
                        Filter
                    </button>
                    <a href="{{ route('players.index') }}" class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-bold uppercase tracking-wider text-gray-700 transition hover:border-accent-400 hover:text-accent-400">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8" x-data="revealOnScroll">
        @if ($players->isEmpty())
            <div class="card-shadow rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-20 text-center">
                <div class="mx-auto mb-5 grid size-16 place-items-center rounded-full bg-accent-500/10 text-accent-500">
                    <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                </div>
                <p class="font-display text-3xl tracking-wide text-black">No Players Found</p>
                <p class="mt-2 text-gray-500">Try adjusting the filters, or check back soon — new signings are announced regularly.</p>
            </div>
        @else
            <p class="mb-6 text-sm text-gray-400">{{ $players->total() }} player(s) found</p>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4" x-reveal>
                @foreach ($players as $player)
                    <x-player-card :player="$player" />
                @endforeach
            </div>

            {{ $players->links('partials.pagination') }}
        @endif
    </section>
@endsection

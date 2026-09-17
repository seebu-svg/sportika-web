@extends('layouts.public', ['settings' => $settings])

@section('title', 'Tournaments — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-accent-600">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Competitions & Events"
                title="Tournaments"
                subtitle="Browse upcoming and past tournaments featuring Sportika players."
            :inverted="true"
            />

            <form method="GET" action="{{ route('tournaments.index') }}" class="grid gap-3 rounded-2xl border border-gray-200 bg-white p-4 sm:grid-cols-2 lg:grid-cols-4">
                <select name="sport" class="rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-accent-400">
                    <option value="">All sports</option>
                    @foreach ($sports as $sport)
                        <option value="{{ $sport }}" @selected(request('sport') === $sport)>{{ $sport }}</option>
                    @endforeach
                </select>
                <select name="city" class="rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-accent-400">
                    <option value="">All cities</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city }}" @selected(request('city') === $city)>{{ $city }}</option>
                    @endforeach
                </select>
                <select name="status" class="rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-accent-400">
                    <option value="">All statuses</option>
                    @foreach (['upcoming' => 'Upcoming', 'ongoing' => 'Ongoing', 'completed' => 'Completed'] as $val => $label)
                        <option value="{{ $val }}" @selected(request('status') === $val)>{{ $label }}</option>
                    @endforeach
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 rounded-lg bg-accent-500 px-4 py-2.5 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-accent-400">Filter</button>
                    <a href="{{ route('tournaments.index') }}" class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-bold uppercase tracking-wider text-gray-700 transition hover:border-accent-400 hover:text-accent-400">Reset</a>
                </div>
            </form>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8" x-data="revealOnScroll">
        @if ($tournaments->isEmpty())
            <div class="card-shadow rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-20 text-center">
                <div class="mx-auto mb-5 grid size-16 place-items-center rounded-full bg-accent-500/10 text-accent-500">
                    <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9a9 9 0 0 1 0-18h9M16.5 18.75V6.75m0 12h-9m9-12a2.25 2.25 0 0 1 2.25 2.25v4.5a2.25 2.25 0 0 1-2.25 2.25m-9-9a2.25 2.25 0 0 0-2.25 2.25v4.5a2.25 2.25 0 0 0 2.25 2.25" /></svg>
                </div>
                <p class="font-display text-3xl tracking-wide text-black">No Tournaments Yet</p>
                <p class="mt-2 text-gray-500">Tournament listings are being prepared. Check back soon for upcoming competitions.</p>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3" x-reveal>
                @foreach ($tournaments as $tournament)
                    <a href="{{ route('tournaments.show', $tournament->slug) }}" class="card-shadow group relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 transition duration-300 hover:-translate-y-1 hover:border-accent-400">
                        <div class="bg-diagonal absolute inset-0 opacity-30"></div>
                        <div class="relative">
                            @php
                                $statusColors = match($tournament->status) {
                                    'ongoing' => 'bg-green-500/15 text-green-400',
                                    'completed' => 'bg-gray-500/15 text-gray-400',
                                    default => 'bg-accent-500/15 text-accent-500',
                                };
                            @endphp
                            <span class="inline-block rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-wider {{ $statusColors }}">
                                {{ ucfirst($tournament->status) }}
                            </span>
                            @if ($tournament->sport)
                                <span class="ml-2 text-[11px] font-bold uppercase tracking-wider text-gray-400">{{ $tournament->sport }}</span>
                            @endif
                            <h3 class="mt-4 font-display text-xl uppercase tracking-wide text-black">{{ $tournament->name }}</h3>
                            <div class="mt-4 space-y-2 text-sm text-gray-400">
                                @if ($tournament->start_date)
                                    <p class="flex items-center gap-2">
                                        <svg class="size-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                                        {{ $tournament->start_date->format('d M Y') }}{{ $tournament->end_date ? ' – '.$tournament->end_date->format('d M Y') : '' }}
                                    </p>
                                @endif
                                @if ($tournament->city)
                                    <p class="flex items-center gap-2">
                                        <svg class="size-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
                                        {{ $tournament->city }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            {{ $tournaments->links('partials.pagination') }}
        @endif
    </section>
@endsection

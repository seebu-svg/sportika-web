@extends('layouts.public', ['settings' => $settings])

@section('title', 'Tournaments — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-blue-700">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Competitions & Events"
                title="Tournaments"
                subtitle="Browse upcoming and past tournaments featuring Sportika players."
            />

            <form method="GET" action="{{ route('tournaments.index') }}" class="grid gap-3 rounded-2xl border border-slate-200 bg-white p-4 sm:grid-cols-2 lg:grid-cols-4">
                <select name="sport" class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-pitch-950 outline-none focus:border-blue-400">
                    <option value="">All sports</option>
                    @foreach ($sports as $sport)
                        <option value="{{ $sport }}" @selected(request('sport') === $sport)>{{ $sport }}</option>
                    @endforeach
                </select>
                <select name="city" class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-pitch-950 outline-none focus:border-blue-400">
                    <option value="">All cities</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city }}" @selected(request('city') === $city)>{{ $city }}</option>
                    @endforeach
                </select>
                <select name="status" class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-pitch-950 outline-none focus:border-blue-400">
                    <option value="">All statuses</option>
                    @foreach (['upcoming' => 'Upcoming', 'ongoing' => 'Ongoing', 'completed' => 'Completed'] as $val => $label)
                        <option value="{{ $val }}" @selected(request('status') === $val)>{{ $label }}</option>
                    @endforeach
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-blue-500">Filter</button>
                    <a href="{{ route('tournaments.index') }}" class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-bold uppercase tracking-wider text-slate-600 transition hover:border-blue-300 hover:text-blue-500">Reset</a>
                </div>
            </form>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        @if ($tournaments->isEmpty())
            <div class="rounded-2xl border border-dashed border-white/15 bg-blue-700 px-6 py-20 text-center">
                <p class="font-display text-3xl tracking-wide text-white">No tournaments yet</p>
                <p class="mt-2 text-slate-400">Tournament listings are being prepared. Check back soon for upcoming competitions.</p>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($tournaments as $tournament)
                    <a href="{{ route('tournaments.show', $tournament->slug) }}" class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 transition duration-300 hover:-translate-y-1 hover:border-blue-300">
                        <div class="bg-diagonal absolute inset-0 opacity-30"></div>
                        <div class="relative">
                            @php
                                $statusColors = match($tournament->status) {
                                    'ongoing' => 'bg-green-500/15 text-green-400',
                                    'completed' => 'bg-slate-500/15 text-slate-400',
                                    default => 'bg-blue-600/15 text-blue-600',
                                };
                            @endphp
                            <span class="inline-block rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-wider {{ $statusColors }}">
                                {{ ucfirst($tournament->status) }}
                            </span>
                            @if ($tournament->sport)
                                <span class="ml-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">{{ $tournament->sport }}</span>
                            @endif
                            <h3 class="mt-4 font-display text-xl uppercase tracking-wide text-white">{{ $tournament->name }}</h3>
                            <div class="mt-4 space-y-2 text-sm text-slate-400">
                                @if ($tournament->start_date)
                                    <p class="flex items-center gap-2">
                                        <svg class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                                        {{ $tournament->start_date->format('d M Y') }}{{ $tournament->end_date ? ' – '.$tournament->end_date->format('d M Y') : '' }}
                                    </p>
                                @endif
                                @if ($tournament->city)
                                    <p class="flex items-center gap-2">
                                        <svg class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
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

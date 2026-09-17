@extends('layouts.public', ['settings' => $settings])

@section('title', 'Our Team — '.$settings->site_name)

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-blue-700">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="absolute -top-40 right-0 size-[32rem] rounded-full bg-blue-600/8 blur-3xl"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="The people behind Sportika"
                title="Meet Our Team"
                subtitle="Agents, scouts, legal advisors and support staff dedicated to your career."
            />
        </div>
    </section>

    {{-- Team grid --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        @if ($members->isEmpty())
            <div class="rounded-2xl border border-dashed border-white/15 bg-blue-700 px-6 py-20 text-center">
                <p class="font-display text-3xl tracking-wide text-white">Team profiles coming soon</p>
                <p class="mt-2 text-slate-400">We are preparing detailed bios for every member of the Sportika staff. Check back shortly.</p>
                <a href="{{ route('about') }}" class="mt-6 inline-block rounded-full border border-blue-300 px-6 py-3 text-sm font-bold uppercase tracking-wider text-blue-500 transition hover:bg-blue-600/10">
                    Learn about us →
                </a>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($members as $member)
                    <a href="{{ route('team.show', $member->slug) }}" class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white transition duration-300 hover:-translate-y-1 hover:border-blue-300">
                        <div class="relative aspect-[3/4] overflow-hidden">
                            <img
                                src="{{ $member->photo_url ?? asset('images/player-fallback.svg') }}"
                                alt="{{ $member->name }}"
                                loading="lazy"
                                class="size-full object-cover transition duration-500 group-hover:scale-105"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-900/70 via-blue-900/20/40 to-transparent"></div>
                            <div class="absolute inset-x-0 bottom-0 p-5">
                                <h3 class="font-display text-2xl uppercase tracking-wide text-white">{{ $member->name }}</h3>
                                <p class="mt-1 text-sm font-medium text-blue-600">{{ $member->designation }}</p>
                            </div>
                        </div>
                        <div class="px-5 py-4">
                            @if ($member->bio)
                                <p class="line-clamp-2 text-sm text-slate-400">{{ Str::limit(strip_tags($member->bio), 100) }}</p>
                            @else
                                <p class="text-sm text-slate-400">View profile →</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
@endsection

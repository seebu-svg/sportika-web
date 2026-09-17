@extends('layouts.public', ['settings' => $settings])

@section('title', 'Our Team — '.$settings->site_name)

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-accent-600">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="absolute -top-40 right-0 size-[32rem] rounded-full bg-accent-500/8 blur-3xl"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="The people behind Sportika"
                title="Meet Our Team"
                subtitle="Agents, scouts, legal advisors and support staff dedicated to your career."
            :inverted="true"
            />
        </div>
    </section>

    {{-- Team grid --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8" x-data="revealOnScroll">
        @if ($members->isEmpty())
            <div class="card-shadow rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-20 text-center">
                <div class="mx-auto mb-5 grid size-16 place-items-center rounded-full bg-accent-500/10 text-accent-500">
                    <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
                </div>
                <p class="font-display text-3xl tracking-wide text-black">Team Profiles Coming Soon</p>
                <p class="mt-2 text-gray-500">We are preparing detailed bios for every member of the Sportika staff. Check back shortly.</p>
                <a href="{{ route('about') }}" class="btn-tactile mt-6 inline-block rounded-full bg-accent-500 px-6 py-3 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-accent-400">
                    Learn about us →
                </a>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4" x-reveal>
                @foreach ($members as $member)
                    <a href="{{ route('team.show', $member->slug) }}" class="card-shadow group relative overflow-hidden rounded-2xl border border-gray-200 bg-white transition duration-300 hover:-translate-y-1 hover:border-accent-400">
                        <div class="relative aspect-[3/4] overflow-hidden">
                            <img
                                src="{{ $member->photo_url ?? asset('images/player-fallback.svg') }}"
                                alt="{{ $member->name }}"
                                loading="lazy"
                                class="size-full object-cover transition duration-500 group-hover:scale-105"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-accent-600/70 via-accent-600/20/40 to-transparent"></div>
                            <div class="absolute inset-x-0 bottom-0 p-5">
                                <h3 class="font-display text-2xl uppercase tracking-wide text-white">{{ $member->name }}</h3>
                                <p class="mt-1 text-sm font-medium text-accent-500">{{ $member->designation }}</p>
                            </div>
                        </div>
                        <div class="px-5 py-4">
                            @if ($member->bio)
                                <p class="line-clamp-2 text-sm text-gray-400">{{ Str::limit(strip_tags($member->bio), 100) }}</p>
                            @else
                                <p class="text-sm text-gray-400">View profile →</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
@endsection

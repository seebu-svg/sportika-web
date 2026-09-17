@extends('layouts.public', ['settings' => $settings])

@section('title', 'Podcast — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-pitch-900">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Listen In"
                title="The Sportika Podcast"
                subtitle="Conversations with players, coaches and industry insiders."
            />
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="mb-8 text-center">
            <a href="{{ route('podcast.apply') }}" class="rounded-full bg-accent-400 px-6 py-2.5 text-sm font-bold uppercase tracking-wider text-pitch-950 transition hover:bg-accent-300">
                Apply for the Podcast
            </a>
        </div>
        <x-coming-soon description="Episode listings with show notes, audio players and archives are on the way. Subscribe soon on your favourite platform." />
    </section>
@endsection

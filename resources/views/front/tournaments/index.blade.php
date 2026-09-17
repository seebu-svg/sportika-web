@extends('layouts.public', ['settings' => $settings])

@section('title', 'Tournaments — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-pitch-900">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Competitions & Events"
                title="Tournaments"
                subtitle="Browse upcoming and past tournaments featuring Sportika players."
            />
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <x-coming-soon description="Tournament listings with schedules, results, and highlights are on the way. Stay tuned!" />
    </section>
@endsection

@extends('layouts.public', ['settings' => $settings])

@section('title', 'Join as a Player — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-pitch-900">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Membership"
                title="Join as a Player"
                subtitle="Register to be represented by Sportika and take your career to the next level."
            />
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <x-coming-soon description="The player registration form is being prepared. Soon you will be able to submit your details, highlight reel and career stats for review by our scouting team." />
    </section>
@endsection

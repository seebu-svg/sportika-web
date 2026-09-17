@extends('layouts.public', ['settings' => $settings])

@section('title', 'Our Team — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-pitch-900">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="The people behind Sportika"
                title="Meet Our Team"
                subtitle="Agents, scouts, legal advisors and support staff dedicated to your career."
            />
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <x-coming-soon description="Our team page is being built. You will soon find bios, photos and contact details for every member of the Sportika staff." />
    </section>
@endsection

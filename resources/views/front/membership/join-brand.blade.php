@extends('layouts.public', ['settings' => $settings])

@section('title', 'Join as a Brand — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-pitch-900">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Partnership"
                title="Join as a Brand"
                subtitle="Partner with Sportika to connect with rising talent and engaged audiences."
            />
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <x-coming-soon description="Brand partnership registration is coming soon. Soon you will be able to explore sponsorship packages, co-branding opportunities and athlete endorsement deals." />
    </section>
@endsection

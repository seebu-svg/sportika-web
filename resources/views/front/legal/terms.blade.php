@extends('layouts.public', ['settings' => $settings])

@section('title', 'Terms of Service — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-pitch-900">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Legal"
                title="Terms of Service"
            />
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <x-coming-soon description="Our terms of service are being finalised. They will define the rules and guidelines for using the Sportika website and services." />
    </section>
@endsection

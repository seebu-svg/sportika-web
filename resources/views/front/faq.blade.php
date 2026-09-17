@extends('layouts.public', ['settings' => $settings])

@section('title', 'FAQs — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-pitch-900">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Got Questions?"
                title="Frequently Asked Questions"
                subtitle="Find answers to the most common questions about Sportika."
            />
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <x-coming-soon description="Our FAQ section is being built. Soon you will find answers about player representation, membership, partnerships, and more." />
    </section>
@endsection

@extends('layouts.public', ['settings' => $settings])

@section('title', 'Sponsors & Partners — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-pitch-900">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Our Partners"
                title="Sponsors & Partners"
                subtitle="The brands and organisations that power our mission."
            />
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <x-coming-soon description="Meet the sponsors, brand partners and supporters who make our work possible. Logos and partnership details coming soon." />
    </section>
@endsection

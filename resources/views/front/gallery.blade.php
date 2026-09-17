@extends('layouts.public', ['settings' => $settings])

@section('title', 'Champions Gallery — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-pitch-900">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Moments of Glory"
                title="Champions Gallery"
                subtitle="Trophy lifts, winning goals and celebration moments from our players."
            />
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <x-coming-soon description="A visual showcase of championship moments, trophy celebrations and career highlights from Sportika athletes. Photos and videos coming soon." />
    </section>
@endsection

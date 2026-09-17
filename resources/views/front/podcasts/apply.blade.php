@extends('layouts.public', ['settings' => $settings])

@section('title', 'Apply for Podcast — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-pitch-900">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Be a Guest"
                title="Apply for the Podcast"
                subtitle="Share your story, insights and expertise on the Sportika Podcast."
            />
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <x-coming-soon description="The podcast guest application form is being prepared. Soon you will be able to submit your topic ideas, background and availability for our production team to review." />
    </section>
@endsection

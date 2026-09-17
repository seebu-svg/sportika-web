@extends('layouts.public', ['settings' => $settings])

@section('title', 'Blogs — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-pitch-900">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Insights & Opinion"
                title="Blogs"
                subtitle="In-depth articles, interviews, opinion pieces and analysis from the Sportika team."
            />
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <x-coming-soon description="Long-form blog content with interviews, opinion pieces and industry insights is being prepared. Check back soon." />
    </section>
@endsection

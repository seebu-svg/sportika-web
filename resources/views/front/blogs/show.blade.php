@extends('layouts.public', ['settings' => $settings])

@section('title', 'Blog Post')

@section('content')
    <section class="relative overflow-hidden bg-pitch-900">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Blog"
                title="Article"
            />
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <x-coming-soon description="This blog article will be published soon. Check back later to read the full content." />
    </section>
@endsection

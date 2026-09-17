@extends('layouts.public')

@section('title', $post->meta_title ?? $post->title)
@section('meta_description', $post->meta_description ?? Str::limit(strip_tags($post->excerpt), 160))

@section('content')
    <article class="bg-pitch-900">
        {{-- Hero --}}
        <section class="relative overflow-hidden">
            @if ($post->cover_url)
                <div class="absolute inset-0">
                    <img src="{{ $post->cover_url }}" alt="{{ $post->title }}" class="size-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-b from-pitch-950/60 via-pitch-950/80 to-pitch-950"></div>
                </div>
            @else
                <div class="bg-diagonal absolute inset-0"></div>
            @endif

            <div class="relative mx-auto max-w-4xl px-4 py-20 sm:px-6 lg:px-8">
                <nav class="mb-6 text-sm text-slate-400">
                    <a href="{{ route('home') }}" class="hover:text-accent-300">Home</a>
                    <span class="mx-2 text-slate-600">/</span>
                    <a href="{{ route('posts.index') }}" class="hover:text-accent-300">News</a>
                    <span class="mx-2 text-slate-600">/</span>
                    <span class="text-slate-300">{{ Str::limit($post->title, 40) }}</span>
                </nav>

                @if ($post->category)
                    <span class="inline-flex rounded-full bg-accent-400 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.25em] text-pitch-950">
                        {{ $post->category->name }}
                    </span>
                @endif

                <h1 class="mt-5 font-display text-4xl uppercase tracking-wide text-white sm:text-6xl">
                    {{ $post->title }}
                </h1>

                <div class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-slate-400">
                    <span>{{ $post->published_at?->translatedFormat('d M Y') }}</span>
                    <span>&middot;</span>
                    <span>{{ $post->reading_time }} min read</span>
                    @if ($post->author)
                        <span>&middot;</span>
                        <span>By <strong class="text-white">{{ $post->author->name }}</strong></span>
                    @endif
                </div>

                @if ($post->excerpt)
                    <p class="mt-6 max-w-3xl text-lg leading-relaxed text-slate-300">
                        {{ $post->excerpt }}
                    </p>
                @endif
            </div>
        </section>

        {{-- Body --}}
        <section class="mx-auto max-w-4xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="rich-content">
                {!! $post->content !!}
            </div>

            {{-- Share / back --}}
            <div class="mt-14 flex flex-wrap items-center justify-between gap-4 border-t border-white/10 pt-8">
                <a
                    href="{{ route('posts.index') }}"
                    class="rounded-full border border-white/20 px-5 py-2.5 text-sm font-bold uppercase tracking-wider text-white transition hover:border-accent-400/60 hover:text-accent-300"
                >
                    &larr; All news
                </a>
                <a
                    href="{{ route('contact') }}"
                    class="rounded-full bg-accent-400 px-5 py-2.5 text-sm font-bold uppercase tracking-wider text-pitch-950 transition hover:bg-accent-300"
                >
                    Contact us
                </a>
            </div>
        </section>
    </article>

    {{-- Related --}}
    @if ($relatedPosts->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
            <x-section-heading eyebrow="Keep reading" title="Related articles" align="center" />
            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($relatedPosts as $related)
                    <x-post-card :post="$related" />
                @endforeach
            </div>
        </section>
    @endif
@endsection

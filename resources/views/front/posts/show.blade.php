@extends('layouts.public')

@section('title', $post->meta_title ?? $post->title)
@section('meta_description', $post->meta_description ?? Str::limit(strip_tags($post->excerpt), 160))

@section('content')
    <article class="bg-blue-700">
        {{-- Hero --}}
        <section class="relative overflow-hidden">
            @if ($post->cover_url)
                <div class="absolute inset-0">
                    <img src="{{ $post->cover_url }}" alt="{{ $post->title }}" class="size-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-b from-blue-900/70/60 via-blue-900/20/80 to-blue-900"></div>
                </div>
            @else
                <div class="bg-diagonal absolute inset-0"></div>
            @endif

            <div class="relative mx-auto max-w-4xl px-4 py-20 sm:px-6 lg:px-8">
                <nav class="mb-6 text-sm text-slate-400">
                    <a href="{{ route('home') }}" class="hover:text-blue-500">Home</a>
                    <span class="mx-2 text-slate-600">/</span>
                    <a href="{{ route('posts.index') }}" class="hover:text-blue-500">News</a>
                    <span class="mx-2 text-slate-600">/</span>
                    <span class="text-slate-600">{{ Str::limit($post->title, 40) }}</span>
                </nav>

                @if ($post->category)
                    <span class="inline-flex rounded-full bg-blue-600 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.25em] text-pitch-950">
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
                        <span>By <strong class="text-pitch-950">{{ $post->author->name }}</strong></span>
                    @endif
                </div>

                @if ($post->excerpt)
                    <p class="mt-6 max-w-3xl text-lg leading-relaxed text-slate-600">
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

            {{-- Tags --}}
            @if ($post->category)
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Tags:</span>
                    <a href="{{ route('posts.index', ['category' => $post->category->slug]) }}" class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-slate-600 transition hover:bg-blue-600/15 hover:text-blue-500">
                        {{ $post->category->name }}
                    </a>
                </div>
            @endif

            {{-- Share buttons --}}
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Share:</span>
                <button
                    onclick="navigator.clipboard.writeText('{{ route('posts.show', $post->slug) }}').then(function(){ alert('Link copied!') })"
                    class="rounded-full border border-slate-200 px-4 py-2 text-xs font-medium text-slate-600 transition hover:border-blue-300 hover:text-blue-500"
                >
                    Copy Link
                </button>
                <a
                    href="https://wa.me/?text={{ urlencode($post->title . ' ' . route('posts.show', $post->slug)) }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="rounded-full border border-slate-200 px-4 py-2 text-xs font-medium text-slate-600 transition hover:border-green-500/50 hover:text-green-400"
                >
                    WhatsApp
                </a>
                <a
                    href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(route('posts.show', $post->slug)) }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="rounded-full border border-slate-200 px-4 py-2 text-xs font-medium text-slate-600 transition hover:border-sky-500/50 hover:text-sky-400"
                >
                    X (Twitter)
                </a>
            </div>

            {{-- Back --}}
            <div class="flex flex-wrap items-center justify-between gap-4 border-t border-slate-200 pt-8">
                <a
                    href="{{ route('posts.index') }}"
                    class="rounded-full border border-white/20 px-5 py-2.5 text-sm font-bold uppercase tracking-wider text-pitch-950 transition hover:border-blue-400 hover:text-blue-500"
                >
                    &larr; All news
                </a>
                <a
                    href="{{ route('contact') }}"
                    class="rounded-full bg-blue-600 px-5 py-2.5 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-blue-500"
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

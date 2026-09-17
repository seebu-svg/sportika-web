@extends('layouts.public', ['settings' => $settings])

@section('title', $post->meta_title ?? $post->title)
@section('meta_description', $post->meta_description ?? Str::limit(strip_tags($post->excerpt), 160))

@section('content')
    <article class="bg-accent-600">
        {{-- Hero --}}
        <section class="relative overflow-hidden">
            @if ($post->cover_url)
                <div class="absolute inset-0">
                    <img src="{{ $post->cover_url }}" alt="{{ $post->title }}" class="size-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-b from-accent-600/70 via-accent-600/20 to-accent-600"></div>
                </div>
            @else
                <div class="bg-diagonal absolute inset-0"></div>
            @endif
            <div class="relative mx-auto max-w-4xl px-4 py-20 sm:px-6 lg:px-8">
                <nav class="mb-6 text-sm text-gray-400">
                    <a href="{{ route('home') }}" class="hover:text-accent-400">Home</a>
                    <span class="mx-2 text-gray-700">/</span>
                    <a href="{{ route('blogs.index') }}" class="hover:text-accent-400">Blogs</a>
                    <span class="mx-2 text-gray-700">/</span>
                    <span class="text-gray-700">{{ Str::limit($post->title, 40) }}</span>
                </nav>
                @if ($post->category)
                    <span class="inline-flex rounded-full bg-accent-500 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.25em] text-black">{{ $post->category->name }}</span>
                @endif
                <h1 class="mt-5 font-display text-4xl uppercase tracking-wide text-white sm:text-6xl">{{ $post->title }}</h1>
                <div class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-gray-400">
                    <span>{{ $post->published_at?->translatedFormat('d M Y') }}</span>
                    <span>&middot;</span>
                    <span>{{ $post->reading_time }} min read</span>
                    @if ($post->author)
                        <span>&middot;</span>
                        <span>By <strong class="text-black">{{ $post->author->name }}</strong></span>
                    @endif
                </div>
                @if ($post->excerpt)
                    <p class="mt-6 max-w-3xl text-lg leading-relaxed text-gray-700">{{ $post->excerpt }}</p>
                @endif
            </div>
        </section>

        {{-- Body --}}
        <section class="mx-auto max-w-4xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="rich-content">{!! $post->content !!}</div>

            {{-- Share --}}
            <div class="mt-10 flex flex-wrap gap-2">
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Share:</span>
                <a href="https://wa.me/?text={{ urlencode($post->title.' '.route('blogs.show', $post->slug)) }}" target="_blank" class="rounded-full border border-gray-200 px-3 py-1 text-xs text-gray-700 hover:border-green-500/50 hover:text-green-400">WhatsApp</a>
                <button onclick="navigator.clipboard.writeText('{{ route('blogs.show', $post->slug) }}'); this.textContent='Copied!';" class="rounded-full border border-gray-200 px-3 py-1 text-xs text-gray-700 hover:border-accent-400 hover:text-accent-400">Copy Link</button>
            </div>

            <div class="mt-14 flex flex-wrap items-center justify-between gap-4 border-t border-gray-200 pt-8">
                <a href="{{ route('blogs.index') }}" class="rounded-full border border-white/20 px-5 py-2.5 text-sm font-bold uppercase tracking-wider text-black transition hover:border-accent-400 hover:text-accent-400">&larr; All blogs</a>
                <a href="{{ route('contact') }}" class="rounded-full bg-accent-500 px-5 py-2.5 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-accent-400">Contact us</a>
            </div>
        </section>
    </article>

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

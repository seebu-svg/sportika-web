@extends('layouts.public')

@section('title', 'News & Blogs')

@section('content')
    <section class="relative overflow-hidden bg-accent-600">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Newsroom"
                title="News & Blogs"
                subtitle="Transfer updates, match reports, training insights and interviews."
            :inverted="true"
            />

            {{-- Search + categories --}}
            <form method="GET" action="{{ route('posts.index') }}" class="flex flex-col gap-4">
                <div class="flex gap-2">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search articles…"
                        class="flex-1 rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400"
                    >
                    <button
                        type="submit"
                        class="rounded-lg bg-accent-500 px-6 py-2.5 text-sm font-bold uppercase tracking-wider text-black transition hover:bg-accent-400"
                    >
                        Search
                    </button>
                </div>

                <div class="flex flex-wrap gap-2">
                    <a
                        href="{{ route('posts.index', array_filter(['search' => request('search')])) }}"
                        @class([
                            'rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wider transition',
                            request()->filled('category')
                                ? 'border border-gray-200 text-gray-700 hover:border-accent-400 hover:text-accent-400'
                                : 'bg-accent-500 text-black',
                        ])
                    >
                        All
                    </a>
                    @foreach ($categories as $category)
                        <a
                            href="{{ route('posts.index', array_filter(['category' => $category->slug, 'search' => request('search')])) }}"
                            @class([
                                'rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wider transition',
                                request('category') === $category->slug
                                    ? 'bg-accent-500 text-black'
                                    : 'border border-gray-200 text-gray-700 hover:border-accent-400 hover:text-accent-400',
                            ])
                        >
                            {{ $category->name }}
                            <span class="ml-1 text-[10px] opacity-70">({{ $category->published_posts_count ?? 0 }})</span>
                        </a>
                    @endforeach
                </div>
            </form>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8" x-data="revealOnScroll">
        {{-- Featured post --}}
        @if ($featured)
            <a href="{{ route('posts.show', $featured->slug) }}" class="group mb-10 grid overflow-hidden rounded-3xl border border-gray-200 bg-white transition hover:border-accent-400 md:grid-cols-2">
                <div class="aspect-video overflow-hidden md:aspect-auto">
                    <img
                        src="{{ $featured->cover_url ?? asset('images/post-fallback.svg') }}"
                        alt="{{ $featured->title }}"
                        class="size-full object-cover transition duration-500 group-hover:scale-105"
                    >
                </div>
                <div class="flex flex-col justify-center p-8 lg:p-12">
                    <p class="text-xs font-bold uppercase tracking-[0.25em] text-accent-500">Featured story</p>
                    @if ($featured->category)
                        <span class="mt-3 inline-flex w-fit rounded-full border border-gray-200 px-3 py-1 text-[11px] uppercase tracking-wider text-gray-700">
                            {{ $featured->category->name }}
                        </span>
                    @endif
                    <h2 class="mt-4 font-display text-3xl uppercase tracking-wide text-black transition group-hover:text-accent-400 sm:text-4xl">
                        {{ $featured->title }}
                    </h2>
                    <p class="mt-4 line-clamp-3 text-gray-400">{{ $featured->excerpt }}</p>
                    <p class="mt-6 text-sm text-gray-400">
                        {{ $featured->published_at?->translatedFormat('d M Y') }}
                        &middot; {{ $featured->reading_time }} min read
                    </p>
                </div>
            </a>
        @endif

        @if ($posts->isEmpty())
            <div class="card-shadow rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-20 text-center">
                <div class="mx-auto mb-5 grid size-16 place-items-center rounded-full bg-accent-500/10 text-accent-500">
                    <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" /></svg>
                </div>
                <p class="font-display text-3xl tracking-wide text-black">No Articles Yet</p>
                <p class="mt-2 text-gray-500">Check back soon — the newsroom is warming up.</p>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-3" x-reveal>
                @foreach ($posts as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>

            {{ $posts->links('partials.pagination') }}
        @endif
    </section>
@endsection

@extends('layouts.public')

@section('title', 'News & Blogs')

@section('content')
    <section class="relative overflow-hidden bg-pitch-900">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Newsroom"
                title="News & Blogs"
                subtitle="Transfer updates, match reports, training insights and interviews."
            />

            {{-- Search + categories --}}
            <form method="GET" action="{{ route('posts.index') }}" class="flex flex-col gap-4">
                <div class="flex gap-2">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search articles…"
                        class="flex-1 rounded-lg border border-white/10 bg-pitch-800 px-4 py-2.5 text-sm text-white placeholder-slate-500 outline-none focus:border-accent-400/60"
                    >
                    <button
                        type="submit"
                        class="rounded-lg bg-accent-400 px-6 py-2.5 text-sm font-bold uppercase tracking-wider text-pitch-950 transition hover:bg-accent-300"
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
                                ? 'border border-white/10 text-slate-300 hover:border-accent-400/50 hover:text-accent-300'
                                : 'bg-accent-400 text-pitch-950',
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
                                    ? 'bg-accent-400 text-pitch-950'
                                    : 'border border-white/10 text-slate-300 hover:border-accent-400/50 hover:text-accent-300',
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

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        {{-- Featured post --}}
        @if ($featured)
            <a href="{{ route('posts.show', $featured->slug) }}" class="group mb-10 grid overflow-hidden rounded-3xl border border-white/10 bg-pitch-800 transition hover:border-accent-400/40 md:grid-cols-2">
                <div class="aspect-video overflow-hidden md:aspect-auto">
                    <img
                        src="{{ $featured->cover_url ?? asset('images/post-fallback.svg') }}"
                        alt="{{ $featured->title }}"
                        class="size-full object-cover transition duration-500 group-hover:scale-105"
                    >
                </div>
                <div class="flex flex-col justify-center p-8 lg:p-12">
                    <p class="text-xs font-bold uppercase tracking-[0.25em] text-accent-400">Featured story</p>
                    @if ($featured->category)
                        <span class="mt-3 inline-flex w-fit rounded-full border border-white/10 px-3 py-1 text-[11px] uppercase tracking-wider text-slate-300">
                            {{ $featured->category->name }}
                        </span>
                    @endif
                    <h2 class="mt-4 font-display text-3xl uppercase tracking-wide text-white transition group-hover:text-accent-300 sm:text-4xl">
                        {{ $featured->title }}
                    </h2>
                    <p class="mt-4 line-clamp-3 text-slate-400">{{ $featured->excerpt }}</p>
                    <p class="mt-6 text-sm text-slate-500">
                        {{ $featured->published_at?->translatedFormat('d M Y') }}
                        &middot; {{ $featured->reading_time }} min read
                    </p>
                </div>
            </a>
        @endif

        @if ($posts->isEmpty())
            <div class="rounded-2xl border border-dashed border-white/15 bg-pitch-900 px-6 py-20 text-center">
                <p class="font-display text-3xl tracking-wide text-white">No articles yet</p>
                <p class="mt-2 text-slate-400">Check back soon — the newsroom is warming up.</p>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($posts as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>

            {{ $posts->links('partials.pagination') }}
        @endif
    </section>
@endsection

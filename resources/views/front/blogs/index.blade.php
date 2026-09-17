@extends('layouts.public', ['settings' => $settings])

@section('title', 'Blogs — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-blue-700">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Insights & Opinion"
                title="Blogs"
                subtitle="In-depth articles, interviews, opinion pieces and analysis from the Sportika team."
            />
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-4">
            {{-- Main content --}}
            <div class="lg:col-span-3">
                {{-- Search --}}
                <form method="GET" action="{{ route('blogs.index') }}" class="mb-8 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search blog posts…" class="flex-1 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-pitch-950 placeholder-slate-500 outline-none focus:border-blue-400">
                    <button type="submit" class="rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-bold uppercase tracking-wider text-pitch-950 transition hover:bg-blue-500">Search</button>
                </form>

                @if ($posts->isEmpty())
                    <div class="rounded-2xl border border-dashed border-white/15 bg-blue-700 px-6 py-20 text-center">
                        <p class="font-display text-3xl tracking-wide text-white">No blog posts yet</p>
                        <p class="mt-2 text-slate-400">Long-form content with interviews, opinion pieces and industry insights is being prepared.</p>
                    </div>
                @else
                    <div class="grid gap-6 md:grid-cols-2">
                        @foreach ($posts as $post)
                            <article class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white transition duration-300 hover:-translate-y-1 hover:border-blue-300">
                                <a href="{{ route('blogs.show', $post->slug) }}" class="relative block aspect-video overflow-hidden">
                                    <img src="{{ $post->cover_url ?? asset('images/post-fallback.svg') }}" alt="{{ $post->title }}" loading="lazy" class="size-full object-cover transition duration-500 group-hover:scale-105">
                                    @if ($post->category)
                                        <span class="absolute left-3 top-3 rounded-full bg-blue-600 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-white">{{ $post->category->name }}</span>
                                    @endif
                                </a>
                                <div class="flex flex-1 flex-col p-5">
                                    <p class="text-xs text-slate-400">
                                        {{ $post->published_at?->translatedFormat('d M Y') ?? now()->translatedFormat('d M Y') }}
                                        &middot; {{ $post->reading_time }} min read
                                        @if ($post->author) &middot; {{ $post->author->name }} @endif
                                    </p>
                                    <h3 class="mt-2 text-lg font-semibold leading-snug text-pitch-950 transition group-hover:text-blue-500">
                                        <a href="{{ route('blogs.show', $post->slug) }}">{{ $post->title }}</a>
                                    </h3>
                                    <p class="mt-2 line-clamp-3 text-sm text-slate-400">{{ $post->excerpt }}</p>
                                    <span class="mt-4 inline-flex items-center gap-1 text-xs font-bold uppercase tracking-wider text-blue-600">Read article <span class="transition group-hover:translate-x-0.5">→</span></span>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    {{ $posts->links('partials.pagination') }}
                @endif
            </div>

            {{-- Sidebar --}}
            <aside class="lg:col-span-1">
                <div class="sticky top-24 rounded-2xl border border-slate-200 bg-white p-5">
                    <h4 class="mb-4 font-display text-lg tracking-wider text-white">Categories</h4>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('blogs.index', array_filter(['search' => request('search')])) }}" class="rounded-full px-3 py-1.5 text-xs font-bold uppercase tracking-wider transition @unless(request('category')) bg-blue-600 text-pitch-950 @else border border-slate-200 text-slate-600 hover:border-blue-300 hover:text-blue-500 @endunless">All</a>
                        @foreach ($categories as $category)
                            <a href="{{ route('blogs.index', array_filter(['category' => $category->slug, 'search' => request('search')])) }}" class="rounded-full px-3 py-1.5 text-xs font-bold uppercase tracking-wider transition @if(request('category') === $category->slug) bg-blue-600 text-pitch-950 @else border border-slate-200 text-slate-600 hover:border-blue-300 hover:text-blue-500 @endif">
                                {{ $category->name }} <span class="ml-1 text-[10px] opacity-70">({{ $category->published_posts_count ?? 0 }})</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection

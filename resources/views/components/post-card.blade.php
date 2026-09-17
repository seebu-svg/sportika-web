@props(['post'])

<article class="card-shadow group flex flex-col overflow-hidden rounded-2xl border border-gray-100 bg-white transition duration-300 hover:-translate-y-1 hover:border-accent-400">
    <a href="{{ route('posts.show', $post->slug) }}" class="relative block aspect-video overflow-hidden">
        <img
            src="{{ $post->cover_url ?? asset('images/post-fallback.svg') }}"
            alt="{{ $post->title }}"
            loading="lazy"
            class="size-full object-cover transition duration-500 group-hover:scale-105"
        >
        @if ($post->category)
            <span class="absolute left-3 top-3 rounded-full bg-accent-500 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-white">
                {{ $post->category->name }}
            </span>
        @endif
    </a>

    <div class="flex flex-1 flex-col p-5">
        <p class="text-xs text-gray-400">
            {{ $post->published_at?->translatedFormat('d M Y') ?? now()->translatedFormat('d M Y') }}
            &middot; {{ $post->reading_time }} min read
        </p>

        <h3 class="mt-2 text-lg font-semibold leading-snug text-black transition group-hover:text-accent-500">
            <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
        </h3>

        <p class="mt-2 line-clamp-3 text-sm text-gray-500">
            {{ $post->excerpt }}
        </p>

        <span class="mt-4 inline-flex items-center gap-1 text-xs font-bold uppercase tracking-wider text-accent-500">
            Read article
            <span class="transition group-hover:translate-x-0.5">&rarr;</span>
        </span>
    </div>
</article>

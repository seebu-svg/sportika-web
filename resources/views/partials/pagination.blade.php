@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="mt-10 flex items-center justify-center gap-1.5">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="rounded-lg px-3.5 py-2 text-sm text-gray-300">&larr;</span>
        @else
            <a
                href="{{ $paginator->previousPageUrl() }}"
                rel="prev"
                class="rounded-lg border border-gray-200 px-3.5 py-2 text-sm text-gray-600 transition hover:border-accent-400 hover:text-accent-500"
            >&larr;</a>
        @endif

        @foreach ($elements as $element)
            {{-- "Three dots" separator --}}
            @if (is_string($element))
                <span class="px-2 text-gray-400">{{ $element }}</span>
            @endif

            {{-- Page number --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="rounded-lg bg-accent-500 px-3.5 py-2 text-sm font-bold text-white" aria-current="page">{{ $page }}</span>
                    @else
                        <a
                            href="{{ $url }}"
                            class="rounded-lg border border-gray-200 px-3.5 py-2 text-sm text-gray-600 transition hover:border-accent-400 hover:text-accent-500"
                        >{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a
                href="{{ $paginator->nextPageUrl() }}"
                rel="next"
                class="rounded-lg border border-gray-200 px-3.5 py-2 text-sm text-gray-600 transition hover:border-accent-400 hover:text-accent-500"
            >&rarr;</a>
        @else
            <span class="rounded-lg px-3.5 py-2 text-sm text-gray-300">&rarr;</span>
        @endif
    </nav>
@endif

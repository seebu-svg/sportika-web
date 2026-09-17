@props(['player'])

@php
    $badge = $player->status_badge ?? 'unverified';
    $badgeColors = match($badge) {
        'verified' => 'bg-emerald-500 text-white',
        'featured' => 'bg-amber-500 text-white',
        default => 'bg-slate-400 text-white',
    };
    $badgeIcons = match($badge) {
        'verified' => '<svg class="size-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 0 0-4.092-1.598l-3.22 2.013a1.5 1.5 0 0 1-1.79-.134l-1.318-1.1a1.5 1.5 0 0 1 1.924-2.302l.644.537 2.854-1.784a3 3 0 0 0 1.598-4.092 1 1 0 1 1 1.79.895 5 5 0 0 1-.15.268l.04-.025a5 5 0 0 1 1.734 6.238 5 5 0 0 1-1.924 1.924l-.025.04a5 5 0 0 1 .268-.15 1 1 0 1 1 .895 1.79Z" clip-rule="evenodd"/></svg>',
        'featured' => '<svg class="size-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/></svg>',
        default => '',
    };
    $badgeLabel = ucfirst($badge);
@endphp

<article class="card-shadow group relative overflow-hidden rounded-2xl border border-gray-100 bg-white transition duration-300 hover:border-accent-400">
    <a href="{{ route('players.show', $player->slug) }}" class="block">
        <div class="relative aspect-[4/5] overflow-hidden bg-gray-50">
            <img
                src="{{ $player->photo_url ?? asset('images/player-fallback.svg') }}"
                alt="{{ $player->name }}"
                loading="lazy"
                class="size-full object-cover transition duration-500 group-hover:scale-105"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

            {{-- Status badge with icon --}}
            <span class="absolute left-3 top-3 inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-wider {{ $badgeColors }}">
                {!! $badgeIcons !!}
                {{ $badgeLabel }}
            </span>

            {{-- Sport tag --}}
            @if ($player->sport)
                <span class="absolute right-3 top-3 rounded-full border border-white/30 bg-white/20 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-white backdrop-blur-sm">
                    {{ $player->sport }}
                </span>
            @endif

            @if ($player->jersey_number)
                <span class="absolute right-3 top-12 font-display text-5xl leading-none text-white/20 transition group-hover:text-accent-300/50">
                    {{ str_pad((string) $player->jersey_number, 2, '0', STR_PAD_LEFT) }}
                </span>
            @endif

            <div class="absolute inset-x-0 bottom-0 p-5">
                <h3 class="font-display text-2xl tracking-wide text-white uppercase">{{ $player->name }}</h3>
                <div class="mt-1 flex items-center gap-2 text-sm text-white/70">
                    @if ($player->city)
                        <span>{{ $player->city }}</span>
                    @elseif ($player->nationality)
                        <span>{{ $player->nationality }}</span>
                    @endif
                    @if ($player->sport && $player->city)
                        <span class="text-white/40">&middot;</span>
                        <span>{{ $player->sport }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between px-5 py-4">
            <div class="flex gap-4 text-xs text-gray-500">
                @if ($player->goals)
                    <span><strong class="text-accent-500">{{ $player->goals }}</strong> goals</span>
                @endif
                @if ($player->assists)
                    <span><strong class="text-accent-500">{{ $player->assists }}</strong> assists</span>
                @endif
                @if (! $player->goals && ! $player->assists)
                    <span class="text-gray-400">&mdash;</span>
                @endif
            </div>
            <span class="text-xs font-bold uppercase tracking-wider text-accent-500 transition group-hover:translate-x-0.5">
                Profile &rarr;
            </span>
        </div>
    </a>
</article>

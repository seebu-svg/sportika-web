@props(['player'])

@php
    $badge = $player->status_badge ?? 'unverified';
    $badgeColors = match($badge) {
        'verified' => 'bg-accent-400 text-pitch-950',
        'featured' => 'bg-amber-400 text-pitch-950',
        default => 'bg-slate-600 text-slate-300',
    };
    $badgeLabel = ucfirst($badge);
@endphp

<article class="group relative overflow-hidden rounded-2xl border border-white/10 bg-pitch-800 transition duration-300 hover:-translate-y-1 hover:border-accent-400/40 hover:shadow-xl hover:shadow-accent-400/5">
    <a href="{{ route('players.show', $player->slug) }}" class="block">
        <div class="relative aspect-[4/5] overflow-hidden">
            <img
                src="{{ $player->photo_url ?? asset('images/player-fallback.svg') }}"
                alt="{{ $player->name }}"
                loading="lazy"
                class="size-full object-cover transition duration-500 group-hover:scale-105"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-pitch-950 via-pitch-950/30 to-transparent"></div>

            {{-- Status badge --}}
            <span class="absolute left-3 top-3 rounded-full px-3 py-1 text-[11px] font-bold uppercase tracking-wider {{ $badgeColors }}">
                {{ $badgeLabel }}
            </span>

            {{-- Sport tag --}}
            @if ($player->sport)
                <span class="absolute right-3 top-3 rounded-full border border-white/20 bg-pitch-950/60 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-white backdrop-blur-sm">
                    {{ $player->sport }}
                </span>
            @endif

            @if ($player->jersey_number)
                <span class="absolute right-3 top-12 font-display text-5xl leading-none text-white/25 transition group-hover:text-accent-400/70">
                    {{ str_pad((string) $player->jersey_number, 2, '0', STR_PAD_LEFT) }}
                </span>
            @endif

            <div class="absolute inset-x-0 bottom-0 p-5">
                <h3 class="font-display text-2xl tracking-wide text-white uppercase">{{ $player->name }}</h3>
                <div class="mt-1 flex items-center gap-2 text-sm text-slate-400">
                    @if ($player->city)
                        <span>{{ $player->city }}</span>
                    @elseif ($player->nationality)
                        <span>{{ $player->nationality }}</span>
                    @endif
                    @if ($player->sport && $player->city)
                        <span class="text-slate-600">·</span>
                        <span>{{ $player->sport }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between px-5 py-4">
            <div class="flex gap-4 text-xs text-slate-400">
                @if ($player->goals)
                    <span><strong class="text-accent-400">{{ $player->goals }}</strong> goals</span>
                @endif
                @if ($player->assists)
                    <span><strong class="text-accent-400">{{ $player->assists }}</strong> assists</span>
                @endif
                @if (! $player->goals && ! $player->assists)
                    <span class="text-slate-500">—</span>
                @endif
            </div>
            <span class="text-xs font-bold uppercase tracking-wider text-accent-400 transition group-hover:translate-x-0.5">
                Profile →
            </span>
        </div>
    </a>
</article>

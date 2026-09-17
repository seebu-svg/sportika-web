@props(['player'])

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

            <span class="absolute left-3 top-3 rounded-full bg-accent-400 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-pitch-950">
                {{ $player->position }}
            </span>

            @if ($player->jersey_number)
                <span class="absolute right-3 top-2 font-display text-5xl leading-none text-white/25 transition group-hover:text-accent-400/70">
                    {{ str_pad((string) $player->jersey_number, 2, '0', STR_PAD_LEFT) }}
                </span>
            @endif

            <div class="absolute inset-x-0 bottom-0 p-5">
                <h3 class="font-display text-2xl tracking-wide text-white uppercase">{{ $player->name }}</h3>
                <p class="mt-0.5 text-sm text-slate-400">
                    {{ $player->current_club ?? $player->nationality ?? '—' }}
                </p>
            </div>
        </div>

        <div class="flex items-center justify-between px-5 py-4">
            <div class="flex gap-4 text-xs text-slate-400">
                <span><strong class="text-accent-400">{{ $player->goals }}</strong> goals</span>
                <span><strong class="text-accent-400">{{ $player->assists }}</strong> assists</span>
            </div>
            <span class="text-xs font-bold uppercase tracking-wider text-accent-400 transition group-hover:translate-x-0.5">
                Portfolio →
            </span>
        </div>
    </a>
</article>

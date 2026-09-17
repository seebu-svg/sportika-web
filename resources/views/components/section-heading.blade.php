@props([
    'eyebrow' => null,
    'title' => '',
    'subtitle' => null,
    'align' => 'left',
])

<div @class([
    'mb-10',
    'text-center' => $align === 'center',
])>
    @if ($eyebrow)
        <p class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-[0.25em] text-accent-400 @if($align === 'center') justify-center @endif">
            <span class="inline-block h-px w-6 bg-accent-400/60"></span>
            {{ $eyebrow }}
        </p>
    @endif
    <h2 class="font-display text-4xl uppercase tracking-wide text-white sm:text-5xl">
        {{ $title }}
    </h2>
    @if ($subtitle)
        <p class="mt-3 max-w-2xl text-slate-400 @if($align === 'center') mx-auto @endif">{{ $subtitle }}</p>
    @endif
</div>

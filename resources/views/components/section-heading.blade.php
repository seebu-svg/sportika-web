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
        <p class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-[0.25em] text-blue-600 @if($align === 'center') justify-center @endif">
            <span class="inline-block h-px w-6 bg-blue-600/40"></span>
            {{ $eyebrow }}
        </p>
    @endif
    <h2 class="font-display text-4xl uppercase tracking-wide text-pitch-950 sm:text-5xl">
        {{ $title }}
    </h2>
    @if ($subtitle)
        <p class="mt-3 max-w-2xl text-slate-500 @if($align === 'center') mx-auto @endif">{{ $subtitle }}</p>
    @endif
</div>

@props([
    'eyebrow' => null,
    'title' => '',
    'subtitle' => null,
    'align' => 'left',
    'inverted' => false,
])

<div @class([
    'mb-10',
    'text-center' => $align === 'center',
])>
    @if ($eyebrow)
        <p class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-[0.25em] {{ $inverted ? 'text-blue-300' : 'text-accent-500' }} @if($align === 'center') justify-center @endif">
            <span class="inline-block h-px w-6 {{ $inverted ? 'bg-blue-300/40' : 'bg-accent-500/40' }}"></span>
            {{ $eyebrow }}
        </p>
    @endif
    <h2 class="font-display text-4xl uppercase tracking-wide heading-accent {{ $inverted ? 'text-white' : 'text-black' }} {{ $align === 'center' ? 'text-center' : '' }} sm:text-5xl">
        {{ $title }}
    </h2>
    @if ($subtitle)
        <p class="mt-3 max-w-2xl {{ $inverted ? 'text-blue-200' : 'text-gray-500' }} @if($align === 'center') mx-auto @endif">{{ $subtitle }}</p>
    @endif
</div>

@props([
    'label',
    'value',
])

<div class="rounded-2xl border border-white/10 bg-pitch-800 p-5">
    <p class="text-xs uppercase tracking-wider text-slate-500">{{ $label }}</p>
    <p class="mt-1 font-display text-4xl text-accent-400">{{ $value }}</p>
</div>

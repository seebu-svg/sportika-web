@props([
    'label',
    'value',
])

<div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
    <p class="text-xs uppercase tracking-wider text-slate-400">{{ $label }}</p>
    <p class="mt-1 font-display text-4xl text-blue-600">{{ $value }}</p>
</div>

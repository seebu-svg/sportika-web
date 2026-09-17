@props([
    'label',
    'value',
])

<div class="card-shadow rounded-2xl border border-gray-100 bg-white p-5">
    <p class="text-xs uppercase tracking-wider text-gray-400">{{ $label }}</p>
    <p class="mt-1 font-display text-4xl text-accent-500">{{ $value }}</p>
</div>

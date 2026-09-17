@props(['active' => false])

<a
    {{ $attributes->merge(['class' => 'rounded-full px-4 py-2 text-sm font-medium transition']) }}
    @class([
        'bg-white/5 text-white' => $active,
        'text-slate-300 hover:text-white' => ! $active,
    ])
>
    {{ $slot }}
</a>

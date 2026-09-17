@props(['active' => false])

<a
    {{ $attributes->merge(['class' => 'rounded-full px-4 py-2 text-sm font-medium transition']) }}
    @class([
        'bg-blue-50 text-blue-700' => $active,
        'text-slate-500 hover:text-pitch-950' => ! $active,
    ])
>
    {{ $slot }}
</a>

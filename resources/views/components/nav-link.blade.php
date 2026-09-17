@props(['active' => false])

<a
    {{ $attributes->merge(['class' => 'rounded-full px-4 py-2 text-sm font-medium transition']) }}
    @class([
        'bg-blue-50/80 text-accent-500' => $active,
        'text-gray-500 hover:text-black' => ! $active,
    ])
>
    {{ $slot }}
</a>

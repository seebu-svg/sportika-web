@props(['active' => false])

<a
    {{ $attributes->merge(['class' => 'relative rounded-full px-4 py-2 text-sm font-medium transition']) }}
    @class([
        'bg-blue-50/80 text-accent-500' => $active,
        'text-gray-500 hover:text-black' => ! $active,
    ])
>
    {{ $slot }}
    @if ($active)
        <span class="absolute bottom-0 left-1/2 size-1.5 -translate-x-1/2 rounded-full bg-accent-500"></span>
    @endif
</a>

@extends('layouts.public', ['settings' => $settings])

@section('title', 'Champions Gallery — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-accent-600">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Moments of Glory"
                title="Champions Gallery"
                subtitle="Trophy lifts, winning goals and celebration moments from our players."
            :inverted="true"
            />

            @if ($albums->isNotEmpty())
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('gallery') }}" class="rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wider transition @unless(request('album')) bg-accent-500 text-black @else border border-gray-200 text-gray-700 hover:border-accent-400 hover:text-accent-400 @endunless">All</a>
                    @foreach ($albums as $album)
                        <a href="{{ route('gallery', ['album' => $album]) }}" class="rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wider transition @if(request('album') === $album) bg-accent-500 text-black @else border border-gray-200 text-gray-700 hover:border-accent-400 hover:text-accent-400 @endif">
                            {{ $album }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8" x-data="revealOnScroll">
        @if ($items->isEmpty())
            <div class="card-shadow rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-20 text-center">
                <div class="mx-auto mb-5 grid size-16 place-items-center rounded-full bg-accent-500/10 text-accent-500">
                    <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Zm16.5-13.5h.008v.008h-.008V7.5Zm-1.5 0h.008v.008h-.008V7.5Z" /></svg>
                </div>
                <p class="font-display text-3xl tracking-wide text-black">Gallery Coming Soon</p>
                <p class="mt-2 text-gray-500">A visual showcase of championship moments, trophy celebrations and career highlights from Sportika athletes.</p>
            </div>
        @else
            <div class="grid gap-4 grid-cols-2 md:grid-cols-3 lg:grid-cols-4" x-reveal>
                @foreach ($items as $item)
                    <div class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white @if($item->is_featured) md:col-span-2 md:row-span-2 @endif">
                        @if ($item->type === 'video' && str_contains($item->file_path, 'youtube'))
                            <div class="aspect-video flex items-center justify-center">
                                <div class="absolute inset-0 bg-diagonal"></div>
                                <div class="relative grid size-14 place-items-center rounded-full bg-accent-500/20 text-accent-500 transition group-hover:scale-110">
                                    <svg class="size-6 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
                                </div>
                            </div>
                        @else
                            <div class="aspect-square overflow-hidden">
                                <div class="bg-diagonal absolute inset-0"></div>
                                @if ($item->file_url)
                                    <img src="{{ $item->file_url }}" alt="{{ $item->title ?? '' }}" loading="lazy" class="size-full object-cover transition duration-500 group-hover:scale-105">
                                @endif
                            </div>
                        @endif
                        @if ($item->title || $item->caption)
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-accent-600/70/90 to-transparent p-4">
                                <p class="text-sm font-medium text-black">{{ $item->title }}</p>
                                @if ($item->caption)<p class="text-xs text-gray-400">{{ $item->caption }}</p>@endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            {{ $items->links('partials.pagination') }}
        @endif
    </section>
@endsection

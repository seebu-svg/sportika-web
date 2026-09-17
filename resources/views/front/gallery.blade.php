@extends('layouts.public', ['settings' => $settings])

@section('title', 'Champions Gallery — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-blue-700">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Moments of Glory"
                title="Champions Gallery"
                subtitle="Trophy lifts, winning goals and celebration moments from our players."
            />

            @if ($albums->isNotEmpty())
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('gallery') }}" class="rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wider transition @unless(request('album')) bg-blue-600 text-pitch-950 @else border border-slate-200 text-slate-600 hover:border-blue-300 hover:text-blue-500 @endunless">All</a>
                    @foreach ($albums as $album)
                        <a href="{{ route('gallery', ['album' => $album]) }}" class="rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wider transition @if(request('album') === $album) bg-blue-600 text-pitch-950 @else border border-slate-200 text-slate-600 hover:border-blue-300 hover:text-blue-500 @endif">
                            {{ $album }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        @if ($items->isEmpty())
            <div class="rounded-2xl border border-dashed border-white/15 bg-blue-700 px-6 py-20 text-center">
                <p class="font-display text-3xl tracking-wide text-white">Gallery coming soon</p>
                <p class="mt-2 text-slate-400">A visual showcase of championship moments, trophy celebrations and career highlights from Sportika athletes.</p>
            </div>
        @else
            <div class="grid gap-4 grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($items as $item)
                    <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white @if($item->is_featured) md:col-span-2 md:row-span-2 @endif">
                        @if ($item->type === 'video' && str_contains($item->file_path, 'youtube'))
                            <div class="aspect-video flex items-center justify-center">
                                <div class="absolute inset-0 bg-diagonal"></div>
                                <div class="relative grid size-14 place-items-center rounded-full bg-blue-600/20 text-blue-600 transition group-hover:scale-110">
                                    <svg class="size-6 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
                                </div>
                            </div>
                        @else
                            <div class="aspect-square overflow-hidden">
                                <div class="bg-diagonal absolute inset-0"></div>
                                @if ($item->file_url)
                                    <img src="{{ $item->file_url }}" alt="{{ $item->title ?? '' }}" class="size-full object-cover transition duration-500 group-hover:scale-105">
                                @endif
                            </div>
                        @endif
                        @if ($item->title || $item->caption)
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-blue-900/70/90 to-transparent p-4">
                                <p class="text-sm font-medium text-pitch-950">{{ $item->title }}</p>
                                @if ($item->caption)<p class="text-xs text-slate-400">{{ $item->caption }}</p>@endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            {{ $items->links('partials.pagination') }}
        @endif
    </section>
@endsection

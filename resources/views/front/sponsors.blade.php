@extends('layouts.public', ['settings' => $settings])

@section('title', 'Sponsors & Partners — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-accent-600">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Our Partners"
                title="Sponsors & Partners"
                subtitle="The brands and organisations that power our mission."
            :inverted="true"
            />
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        @if ($sponsors->isEmpty())
            <div class="card-shadow rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-20 text-center">
                <div class="mx-auto mb-5 grid size-16 place-items-center rounded-full bg-accent-500/10 text-accent-500">
                    <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
                </div>
                <p class="font-display text-3xl tracking-wide text-black">Partner Showcase Coming Soon</p>
                <p class="mt-2 text-gray-500">We are curating the list of brands and organisations that make our work possible.</p>
            </div>
        @else
            @php $grouped = $sponsors->groupBy(fn($s) => $s->category ?? 'Partner'); @endphp
            @foreach ($grouped as $category => $items)
                <div class="mb-16">
                    <h3 class="mb-8 font-display text-2xl uppercase tracking-wide text-black">{{ $category }}</h3>
                    <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        @foreach ($items as $sponsor)
                            <div class="card-shadow group relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-6 text-center transition hover:-translate-y-1 hover:border-accent-400">
                                <div class="mx-auto mb-4 flex h-20 items-center justify-center">
                                    @if ($sponsor->logo_url)
                                        <img src="{{ $sponsor->logo_url }}" alt="{{ $sponsor->name }}" loading="lazy" class="max-h-full max-w-full object-contain">
                                    @else
                                        <span class="font-display text-3xl tracking-widest text-gray-700">{{ strtoupper($sponsor->name) }}</span>
                                    @endif
                                </div>
                                <h4 class="font-display text-lg tracking-wide text-black">{{ $sponsor->name }}</h4>
                                @if ($sponsor->description)
                                    <p class="mt-2 text-sm text-gray-400 line-clamp-2">{{ $sponsor->description }}</p>
                                @endif
                                @if ($sponsor->website)
                                    <a href="{{ $sponsor->website }}" target="_blank" rel="noopener" class="mt-3 inline-block text-xs font-bold uppercase tracking-wider text-accent-500 transition hover:text-accent-400">Visit website →</a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </section>

    {{-- CTA --}}
    <section class="border-t border-gray-200 bg-pitch-100">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 text-center">
            <h2 class="font-display text-3xl uppercase tracking-wide text-black sm:text-4xl">Become a Sponsor</h2>
            <p class="mx-auto mt-4 max-w-xl text-blue-200">Partner with Sportika to connect with rising talent and engaged sports audiences.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="{{ route('contact') }}" class="rounded-full bg-white px-8 py-4 text-sm font-bold uppercase tracking-wider text-accent-600 transition hover:bg-blue-50">Contact Us</a>
                <a href="{{ route('membership.brand') }}" class="rounded-full border border-white/30 px-8 py-4 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-white/10">Join as Brand</a>
            </div>
        </div>
    </section>
@endsection

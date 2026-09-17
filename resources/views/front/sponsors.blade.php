@extends('layouts.public', ['settings' => $settings])

@section('title', 'Sponsors & Partners — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-blue-700">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Our Partners"
                title="Sponsors & Partners"
                subtitle="The brands and organisations that power our mission."
            />
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        @if ($sponsors->isEmpty())
            <div class="rounded-2xl border border-dashed border-white/15 bg-blue-700 px-6 py-20 text-center">
                <p class="font-display text-3xl tracking-wide text-white">Partner showcase coming soon</p>
                <p class="mt-2 text-slate-400">We are curating the list of brands and organisations that make our work possible.</p>
            </div>
        @else
            @php $grouped = $sponsors->groupBy(fn($s) => $s->category ?? 'Partner'); @endphp
            @foreach ($grouped as $category => $items)
                <div class="mb-16">
                    <h3 class="mb-8 font-display text-2xl uppercase tracking-wide text-white">{{ $category }}</h3>
                    <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                        @foreach ($items as $sponsor)
                            <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 text-center transition hover:-translate-y-1 hover:border-blue-300">
                                <div class="mx-auto mb-4 flex h-20 items-center justify-center">
                                    @if ($sponsor->logo_url)
                                        <img src="{{ $sponsor->logo_url }}" alt="{{ $sponsor->name }}" class="max-h-full max-w-full object-contain">
                                    @else
                                        <span class="font-display text-3xl tracking-widest text-slate-600">{{ strtoupper($sponsor->name) }}</span>
                                    @endif
                                </div>
                                <h4 class="font-display text-lg tracking-wide text-white">{{ $sponsor->name }}</h4>
                                @if ($sponsor->description)
                                    <p class="mt-2 text-sm text-slate-400 line-clamp-2">{{ $sponsor->description }}</p>
                                @endif
                                @if ($sponsor->website)
                                    <a href="{{ $sponsor->website }}" target="_blank" rel="noopener" class="mt-3 inline-block text-xs font-bold uppercase tracking-wider text-blue-600 transition hover:text-blue-500">Visit website →</a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </section>

    {{-- CTA --}}
    <section class="border-t border-slate-200 bg-blue-700/50">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 text-center">
            <h2 class="font-display text-3xl uppercase tracking-wide text-pitch-950 sm:text-4xl">Become a Sponsor</h2>
            <p class="mx-auto mt-4 max-w-xl text-slate-400">Partner with Sportika to connect with rising talent and engaged sports audiences.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="{{ route('contact') }}" class="rounded-full bg-blue-600 px-8 py-4 text-sm font-bold uppercase tracking-wider text-pitch-950 transition hover:bg-blue-500">Contact Us</a>
                <a href="{{ route('membership.brand') }}" class="rounded-full border border-white/20 px-8 py-4 text-sm font-bold uppercase tracking-wider text-pitch-950 transition hover:border-blue-400 hover:text-blue-500">Join as Brand</a>
            </div>
        </div>
    </section>
@endsection

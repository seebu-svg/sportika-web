@extends('layouts.public', ['settings' => $settings])

@section('title', 'About — '.$settings->site_name)

@section('content')
    {{-- ============================== Header ============================= --}}
    <section class="relative overflow-hidden bg-pitch-900">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Who we are"
                title="{{ $settings->about_title ?? 'About '.($settings->site_name) }}"
            />
            @if (filled($settings->tagline))
                <p class="-mt-4 max-w-2xl text-lg text-slate-400">{{ $settings->tagline }}</p>
            @endif
        </div>
    </section>

    {{-- =============================== Body ============================== --}}
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-3">
            <div class="rich-content lg:col-span-2">
                @if (filled($settings->about_body))
                    {!! $settings->about_body !!}
                @else
                    <p class="text-slate-400">
                        Our story has not been written yet. Add your club's story from the admin panel
                        under <strong class="text-white">Site Settings → About page</strong>.
                    </p>
                @endif
            </div>

            {{-- Fact cards --}}
            <aside class="space-y-4">
                <div class="rounded-2xl border border-white/10 bg-pitch-800 p-6">
                    <p class="font-display text-4xl text-accent-400">{{ $playerCount }}</p>
                    <p class="mt-1 text-sm text-slate-400">Players currently represented</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-pitch-800 p-6">
                    <p class="font-display text-4xl text-accent-400">{{ \App\Models\Post::published()->count() }}</p>
                    <p class="mt-1 text-sm text-slate-400">News articles published</p>
                </div>
                @if ($settings->email || $settings->phone)
                    <div class="rounded-2xl border border-accent-400/30 bg-pitch-800 p-6">
                        <h3 class="font-display text-xl tracking-wider text-white">Work with us</h3>
                        <ul class="mt-3 space-y-2 text-sm text-slate-400">
                            @if ($settings->email)
                                <li><a href="mailto:{{ $settings->email }}" class="hover:text-accent-300">{{ $settings->email }}</a></li>
                            @endif
                            @if ($settings->phone)
                                <li><a href="tel:{{ preg_replace('/[^\d+]/', '', $settings->phone) }}" class="hover:text-accent-300">{{ $settings->phone }}</a></li>
                            @endif
                        </ul>
                        <a
                            href="{{ route('contact') }}"
                            class="mt-4 inline-block rounded-full bg-accent-400 px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-pitch-950 transition hover:bg-accent-300"
                        >
                            Contact the team
                        </a>
                    </div>
                @endif
            </aside>
        </div>
    </section>
@endsection

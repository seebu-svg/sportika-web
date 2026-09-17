@extends('layouts.public', ['settings' => $settings])

@section('title', $member->name.' — '.$settings->site_name.' Team')

@section('content')
    <section class="relative overflow-hidden bg-blue-700">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <nav class="mb-6 text-sm text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-blue-500">Home</a>
                <span class="mx-2 text-slate-600">/</span>
                <a href="{{ route('team') }}" class="hover:text-blue-500">Team</a>
                <span class="mx-2 text-slate-600">/</span>
                <span class="text-slate-600">{{ $member->name }}</span>
            </nav>

            <div class="grid items-start gap-10 lg:grid-cols-3">
                <div class="lg:col-span-1">
                    <div class="mx-auto aspect-[3/4] max-w-sm overflow-hidden rounded-3xl border border-slate-200 bg-white">
                        <img src="{{ $member->photo_url ?? asset('images/player-fallback.svg') }}" alt="{{ $member->name }}" class="size-full object-cover">
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <p class="mb-3 inline-flex items-center gap-2 rounded-full bg-blue-600 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.25em] text-pitch-950">
                        {{ $member->designation }}
                    </p>
                    <h1 class="font-display text-5xl uppercase tracking-wide text-white sm:text-6xl">{{ $member->name }}</h1>

                    @if (filled($member->bio))
                        <div class="rich-content mt-8">
                            {!! $member->bio !!}
                        </div>
                    @endif

                    <div class="mt-8 flex flex-wrap gap-3">
                        @if ($member->email)
                            <a href="mailto:{{ $member->email }}" class="rounded-full border border-white/20 px-5 py-2.5 text-sm font-bold uppercase tracking-wider text-pitch-950 transition hover:border-blue-400 hover:text-blue-500">
                                Email {{ Str::before($member->name, ' ') }}
                            </a>
                        @endif
                        <a href="{{ route('contact') }}" class="rounded-full bg-blue-600 px-5 py-2.5 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-blue-500">
                            Contact us
                        </a>
                    </div>

                    @if (! empty($member->social_links))
                        <div class="mt-8 flex flex-wrap gap-2">
                            @foreach ($member->social_links as $platform => $url)
                                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="rounded-full border border-slate-200 px-4 py-2 text-sm text-slate-600 transition hover:border-blue-300 hover:text-blue-500">
                                    {{ $platform }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

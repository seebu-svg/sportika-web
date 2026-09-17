@php
    $footerSettings = $settings ?? \App\Models\SiteSetting::current();

    $socials = array_filter([
        'Facebook' => $footerSettings->facebook_url,
        'X / Twitter' => $footerSettings->twitter_url,
        'Instagram' => $footerSettings->instagram_url,
        'LinkedIn' => $footerSettings->linkedin_url,
        'YouTube' => $footerSettings->youtube_url,
    ]);
@endphp

<footer class="border-t border-white/10 bg-pitch-900">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-10 md:grid-cols-4">
            {{-- Brand --}}
            <div class="md:col-span-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <span class="grid size-9 place-items-center rounded-lg bg-accent-400 font-display text-xl text-pitch-950">S</span>
                    <span class="font-display text-2xl tracking-widest text-white">{{ strtoupper($footerSettings->site_name) }}</span>
                </a>
                <p class="mt-4 max-w-sm text-sm leading-relaxed text-slate-400">
                    {{ $footerSettings->tagline ?? 'Player representation, scouting and sports news.' }}
                </p>
                @if (! empty($socials))
                    <div class="mt-5 flex flex-wrap gap-2">
                        @foreach ($socials as $platform => $url)
                            <a
                                href="{{ $url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="rounded-full border border-white/10 px-3.5 py-1.5 text-xs font-medium text-slate-300 transition hover:border-accent-400/50 hover:text-accent-300"
                            >
                                {{ $platform }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Quick links --}}
            <div>
                <h3 class="font-display text-lg tracking-wider text-white">Explore</h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a href="{{ route('home') }}" class="text-slate-400 transition hover:text-accent-300">Home</a></li>
                    <li><a href="{{ route('about') }}" class="text-slate-400 transition hover:text-accent-300">About us</a></li>
                    <li><a href="{{ route('players.index') }}" class="text-slate-400 transition hover:text-accent-300">Players directory</a></li>
                    <li><a href="{{ route('posts.index') }}" class="text-slate-400 transition hover:text-accent-300">News & blogs</a></li>
                    <li><a href="{{ route('contact') }}" class="text-slate-400 transition hover:text-accent-300">Contact us</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h3 class="font-display text-lg tracking-wider text-white">Contact</h3>
                <ul class="mt-4 space-y-2.5 text-sm text-slate-400">
                    @if ($footerSettings->email)
                        <li><a href="mailto:{{ $footerSettings->email }}" class="transition hover:text-accent-300">{{ $footerSettings->email }}</a></li>
                    @endif
                    @if ($footerSettings->phone)
                        <li><a href="tel:{{ preg_replace('/[^\d+]/', '', $footerSettings->phone) }}" class="transition hover:text-accent-300">{{ $footerSettings->phone }}</a></li>
                    @endif
                    @if ($footerSettings->address)
                        <li>{{ $footerSettings->address }}</li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-between gap-3 border-t border-white/10 pt-6 text-xs text-slate-500 sm:flex-row">
            <p>&copy; {{ date('Y') }} {{ $footerSettings->site_name }}. All rights reserved.</p>
            <p>Powered by Laravel &amp; Filament</p>
        </div>
    </div>
</footer>

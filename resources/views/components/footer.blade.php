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
        <div class="grid gap-10 md:grid-cols-5">
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

            {{-- Explore --}}
            <div>
                <h3 class="font-display text-lg tracking-wider text-white">Explore</h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a href="{{ route('about') }}" class="text-slate-400 transition hover:text-accent-300">About Us</a></li>
                    <li><a href="{{ route('team') }}" class="text-slate-400 transition hover:text-accent-300">Team</a></li>
                    <li><a href="{{ route('players.index') }}" class="text-slate-400 transition hover:text-accent-300">Players</a></li>
                    <li><a href="{{ route('tournaments.index') }}" class="text-slate-400 transition hover:text-accent-300">Tournaments</a></li>
                    <li><a href="{{ route('gallery') }}" class="text-slate-400 transition hover:text-accent-300">Champions Gallery</a></li>
                    <li><a href="{{ route('sponsors') }}" class="text-slate-400 transition hover:text-accent-300">Sponsors</a></li>
                </ul>
            </div>

            {{-- Media & Membership --}}
            <div>
                <h3 class="font-display text-lg tracking-wider text-white">Media</h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a href="{{ route('posts.index') }}" class="text-slate-400 transition hover:text-accent-300">News</a></li>
                    <li><a href="{{ route('blogs.index') }}" class="text-slate-400 transition hover:text-accent-300">Blogs</a></li>
                    <li><a href="{{ route('podcast') }}" class="text-slate-400 transition hover:text-accent-300">Podcast</a></li>
                    <li><a href="{{ route('membership.player') }}" class="text-slate-400 transition hover:text-accent-300">Join as Player</a></li>
                    <li><a href="{{ route('membership.brand') }}" class="text-slate-400 transition hover:text-accent-300">Join as Brand</a></li>
                    <li><a href="{{ route('faq') }}" class="text-slate-400 transition hover:text-accent-300">FAQs</a></li>
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
                    <li class="pt-1"><a href="{{ route('contact') }}" class="text-accent-400 transition hover:text-accent-300">Contact form &rarr;</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-between gap-3 border-t border-white/10 pt-6 text-xs text-slate-500 sm:flex-row">
            <p>&copy; {{ date('Y') }} {{ $footerSettings->site_name }}. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="{{ route('privacy') }}" class="transition hover:text-slate-300">Privacy Policy</a>
                <a href="{{ route('terms') }}" class="transition hover:text-slate-300">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

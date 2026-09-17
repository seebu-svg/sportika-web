@extends('layouts.public', ['settings' => $settings])

@section('title', 'Contact Us — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-pitch-900">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Get in touch"
                title="Contact Us"
                subtitle="Whether you are a player seeking representation, a club scouting talent, or a journalist with a story — we would love to hear from you."
            />
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-5">
            {{-- ============================== Form ============================== --}}
            <div class="lg:col-span-3">
                @if (session('success'))
                    <div class="mb-6 flex items-start gap-3 rounded-2xl border border-accent-400/30 bg-accent-400/10 p-4 text-sm text-accent-200">
                        <svg class="mt-0.5 size-5 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm4.3 7.7-5 5a1 1 0 0 1-1.4 0l-2-2a1 1 0 1 1 1.4-1.4L10.6 12.6l4.3-4.3a1 1 0 0 1 1.4 1.4Z"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form
                    action="{{ route('contact.store') }}"
                    method="POST"
                    class="space-y-5 rounded-2xl border border-white/10 bg-pitch-800 p-6 sm:p-8"
                >
                    @csrf

                    {{-- Honeypot — hidden from real users, bots will fill it --}}
                    <div style="position:absolute;left:-9999px;top:-9999px" aria-hidden="true">
                        <label for="website">Website</label>
                        <input
                            type="text"
                            id="website"
                            name="website"
                            tabindex="-1"
                            autocomplete="off"
                            value="{{ old('website') }}"
                        >
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="name" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-400">Name</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                class="w-full rounded-lg border border-white/10 bg-pitch-900 px-4 py-2.5 text-sm text-white placeholder-slate-500 outline-none focus:border-accent-400/60 @error('name') border-red-500/60 @enderror"
                            >
                            @error('name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="email" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-400">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                class="w-full rounded-lg border border-white/10 bg-pitch-900 px-4 py-2.5 text-sm text-white placeholder-slate-500 outline-none focus:border-accent-400/60 @error('email') border-red-500/60 @enderror"
                            >
                            @error('email') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="phone" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-400">Phone <span class="text-slate-600">(optional)</span></label>
                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                class="w-full rounded-lg border border-white/10 bg-pitch-900 px-4 py-2.5 text-sm text-white placeholder-slate-500 outline-none focus:border-accent-400/60 @error('phone') border-red-500/60 @enderror"
                            >
                            @error('phone') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="subject" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-400">Subject</label>
                            <input
                                type="text"
                                id="subject"
                                name="subject"
                                value="{{ old('subject') }}"
                                required
                                class="w-full rounded-lg border border-white/10 bg-pitch-900 px-4 py-2.5 text-sm text-white placeholder-slate-500 outline-none focus:border-accent-400/60 @error('subject') border-red-500/60 @enderror"
                            >
                            @error('subject') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="message" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-400">Message</label>
                        <textarea
                            id="message"
                            name="message"
                            rows="6"
                            required
                            class="w-full rounded-lg border border-white/10 bg-pitch-900 px-4 py-2.5 text-sm text-white placeholder-slate-500 outline-none focus:border-accent-400/60 @error('message') border-red-500/60 @enderror"
                        >{{ old('message') }}</textarea>
                        @error('message') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-full bg-accent-400 px-6 py-3.5 text-sm font-bold uppercase tracking-wider text-pitch-950 transition hover:bg-accent-300 sm:w-auto"
                    >
                        Send message
                    </button>
                </form>
            </div>

            {{-- ============================ Sidebar ============================ --}}
            <aside class="space-y-6 lg:col-span-2">
                <div class="rounded-2xl border border-white/10 bg-pitch-800 p-6">
                    <h3 class="font-display text-xl tracking-wider text-white">Reach us directly</h3>
                    <ul class="mt-4 space-y-4 text-sm text-slate-400">
                        @if ($settings->email)
                            <li class="flex items-start gap-3">
                                <span class="grid size-9 shrink-0 place-items-center rounded-full bg-accent-400/15 text-accent-400">
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                                </span>
                                <div>
                                    <p class="text-xs uppercase tracking-wider text-slate-500">Email</p>
                                    <a href="mailto:{{ $settings->email }}" class="text-white hover:text-accent-300">{{ $settings->email }}</a>
                                </div>
                            </li>
                        @endif
                        @if ($settings->phone)
                            <li class="flex items-start gap-3">
                                <span class="grid size-9 shrink-0 place-items-center rounded-full bg-accent-400/15 text-accent-400">
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.597-.237-1.17-.659-1.591l-3.559-3.559a2.25 2.25 0 0 0-3.015.177L12.75 13.5a13.5 13.5 0 0 1-5.25-5.25l1.055-1.055a2.25 2.25 0 0 0 .177-3.015L5.172.621A2.25 2.25 0 0 0 3.581 0H2.25A2.25 2.25 0 0 0 0 2.25v4.5Z" /></svg>
                                </span>
                                <div>
                                    <p class="text-xs uppercase tracking-wider text-slate-500">Phone</p>
                                    <a href="tel:{{ preg_replace('/[^\d+]/', '', $settings->phone) }}" class="text-white hover:text-accent-300">{{ $settings->phone }}</a>
                                </div>
                            </li>
                        @endif
                        @if ($settings->address)
                            <li class="flex items-start gap-3">
                                <span class="grid size-9 shrink-0 place-items-center rounded-full bg-accent-400/15 text-accent-400">
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
                                </span>
                                <div>
                                    <p class="text-xs uppercase tracking-wider text-slate-500">Office</p>
                                    <p class="text-white">{{ $settings->address }}</p>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="rounded-2xl border border-accent-400/30 bg-pitch-800 p-6">
                    <h3 class="font-display text-xl tracking-wider text-white">Response time</h3>
                    <p class="mt-3 text-sm leading-relaxed text-slate-400">
                        We typically respond within <strong class="text-white">24 hours</strong> on business days. Urgent enquiries about active transfers should include <strong class="text-accent-300">"URGENT"</strong> in the subject line.
                    </p>
                </div>

                {{-- Social media links --}}
                <div class="rounded-2xl border border-white/10 bg-pitch-800 p-6">
                    <h3 class="font-display text-xl tracking-wider text-white">Follow us</h3>
                    <p class="mt-2 text-sm text-slate-400">Stay connected on social media for the latest updates, highlights, and behind-the-scenes content.</p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @if ($settings->facebook_url)
                            <a href="{{ $settings->facebook_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 text-sm text-slate-300 transition hover:border-blue-500/50 hover:text-blue-400">
                                <svg class="size-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                Facebook
                            </a>
                        @endif
                        @if ($settings->instagram_url)
                            <a href="{{ $settings->instagram_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 text-sm text-slate-300 transition hover:border-pink-500/50 hover:text-pink-400">
                                <svg class="size-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                Instagram
                            </a>
                        @endif
                        @if ($settings->twitter_url)
                            <a href="{{ $settings->twitter_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 text-sm text-slate-300 transition hover:border-sky-500/50 hover:text-sky-400">
                                <svg class="size-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                X (Twitter)
                            </a>
                        @endif
                        @if ($settings->youtube_url)
                            <a href="{{ $settings->youtube_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 text-sm text-slate-300 transition hover:border-red-500/50 hover:text-red-400">
                                <svg class="size-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                YouTube
                            </a>
                        @endif
                        @if ($settings->linkedin_url)
                            <a href="{{ $settings->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 text-sm text-slate-300 transition hover:border-blue-600/50 hover:text-blue-500">
                                <svg class="size-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                LinkedIn
                            </a>
                        @endif
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection

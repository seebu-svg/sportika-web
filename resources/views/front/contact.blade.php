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
            </aside>
        </div>
    </section>
@endsection

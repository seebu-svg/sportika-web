@extends('layouts.public', ['settings' => $settings])

@section('title', 'Apply for Podcast — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-blue-700">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Be a Guest"
                title="Apply for the Podcast"
                subtitle="Share your story, insights and expertise on the Sportika Podcast."
            />
        </div>
    </section>

    <section class="mx-auto max-w-3xl px-4 py-14 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 flex items-start gap-3 rounded-2xl border border-blue-200 bg-blue-600/10 p-4 text-sm text-blue-700">
                <svg class="mt-0.5 size-5 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm4.3 7.7-5 5a1 1 0 0 1-1.4 0l-2-2a1 1 0 1 1 1.4-1.4L10.6 12.6l4.3-4.3a1 1 0 0 1 1.4 1.4Z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('podcast.apply.store') }}" method="POST" class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 sm:p-8">
            @csrf
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-400">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-pitch-950 placeholder-slate-500 outline-none focus:border-blue-400 @error('name') border-red-500/60 @enderror">
                    @error('name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="email" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-400">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-pitch-950 placeholder-slate-500 outline-none focus:border-blue-400 @error('email') border-red-500/60 @enderror">
                    @error('email') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="phone" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-400">Phone <span class="text-slate-600">(optional)</span></label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-pitch-950 placeholder-slate-500 outline-none focus:border-blue-400">
                </div>
                <div>
                    <label for="sport" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-400">Sport / Category</label>
                    <input type="text" id="sport" name="sport" value="{{ old('sport') }}" placeholder="e.g. Cricket, Football" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-pitch-950 placeholder-slate-500 outline-none focus:border-blue-400">
                </div>
            </div>
            <div>
                <label for="pitch" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-400">Why should we feature you?</label>
                <textarea id="pitch" name="pitch" rows="4" required class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-pitch-950 placeholder-slate-500 outline-none focus:border-blue-400 @error('pitch') border-red-500/60 @enderror">{{ old('pitch') }}</textarea>
                @error('pitch') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="achievements" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-400">Achievements highlight</label>
                <textarea id="achievements" name="achievements" rows="3" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-pitch-950 placeholder-slate-500 outline-none focus:border-blue-400">{{ old('achievements') }}</textarea>
            </div>
            <div>
                <label for="availability" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-400">Availability</label>
                <input type="text" id="availability" name="availability" value="{{ old('availability') }}" placeholder="e.g. Weekday evenings" class="w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-pitch-950 placeholder-slate-500 outline-none focus:border-blue-400">
            </div>
            <button type="submit" class="w-full rounded-full bg-blue-600 px-6 py-3.5 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-blue-500 sm:w-auto">Submit Application</button>
        </form>
    </section>
@endsection

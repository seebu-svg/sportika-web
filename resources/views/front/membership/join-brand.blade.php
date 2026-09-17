@extends('layouts.public', ['settings' => $settings])

@section('title', 'Join as a Brand — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-accent-600">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Partnership"
                title="Join as a Brand"
                subtitle="Partner with Sportika to connect with rising talent and engaged audiences."
            :inverted="true"
            />
        </div>
    </section>

    <section class="mx-auto max-w-3xl px-4 py-14 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 flex items-start gap-3 rounded-2xl border border-accent-200 bg-accent-500/10 p-4 text-sm text-accent-500">
                <svg class="mt-0.5 size-5 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm4.3 7.7-5 5a1 1 0 0 1-1.4 0l-2-2a1 1 0 1 1 1.4-1.4L10.6 12.6l4.3-4.3a1 1 0 0 1 1.4 1.4Z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('membership.brand.store') }}" method="POST" class="space-y-5 rounded-2xl border border-gray-200 bg-white p-6 sm:p-8">
            @csrf
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="brand_name" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Brand / Company Name *</label>
                    <input type="text" id="brand_name" name="brand_name" value="{{ old('brand_name') }}" required class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400 @error('brand_name') border-red-500/60 @enderror">
                    @error('brand_name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="contact_person" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Contact Person Name *</label>
                    <input type="text" id="contact_person" name="contact_person" value="{{ old('contact_person') }}" required class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400 @error('contact_person') border-red-500/60 @enderror">
                    @error('contact_person') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="email" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400 @error('email') border-red-500/60 @enderror">
                    @error('email') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="phone" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Phone</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400">
                </div>
            </div>
            <div>
                <label for="website" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Brand / Company Website</label>
                <input type="url" id="website" name="website" value="{{ old('website') }}" placeholder="https://yourbrand.com" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400">
            </div>
            <div>
                <label for="details" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Brand / Company Details</label>
                <textarea id="details" name="details" rows="3" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400">{{ old('details') }}</textarea>
            </div>
            <div>
                <label for="interest" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Interest *</label>
                <select id="interest" name="interest" required class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-accent-400 @error('interest') border-red-500/60 @enderror">
                    <option value="">Select interest</option>
                    @foreach (['Sponsorship', 'Partnership', 'Advertising'] as $opt)
                        <option value="{{ $opt }}" @selected(old('interest') === $opt)>{{ $opt }}</option>
                    @endforeach
                </select>
                @error('interest') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="message" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Message</label>
                <textarea id="message" name="message" rows="4" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400">{{ old('message') }}</textarea>
            </div>
            <button type="submit" class="w-full rounded-full bg-accent-500 px-6 py-3.5 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-accent-400 sm:w-auto">Submit Inquiry</button>
        </form>
    </section>
@endsection

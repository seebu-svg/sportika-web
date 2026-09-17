@extends('layouts.public', ['settings' => $settings])

@section('title', 'Join as a Player — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-accent-600">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Membership"
                title="Join as a Player"
                subtitle="Register to be represented by Sportika and take your career to the next level."
            :inverted="true"
            />
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 py-14 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 flex items-start gap-3 rounded-2xl border border-accent-200 bg-accent-500/10 p-4 text-sm text-accent-500">
                <svg class="mt-0.5 size-5 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm4.3 7.7-5 5a1 1 0 0 1-1.4 0l-2-2a1 1 0 1 1 1.4-1.4L10.6 12.6l4.3-4.3a1 1 0 0 1 1.4 1.4Z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('membership.player.store') }}" method="POST" class="space-y-8">
            @csrf

            {{-- Section 1: Personal Information --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8">
                <h3 class="mb-6 font-display text-2xl uppercase tracking-wide text-white">Section 1 — Personal Information</h3>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="full_name" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Full Name *</label>
                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400 @error('full_name') border-red-500/60 @enderror">
                        @error('full_name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="phone" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400 @error('phone') border-red-500/60 @enderror">
                        @error('phone') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="cnic" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">CNIC <span class="text-gray-700">(for verification only)</span></label>
                        <input type="text" id="cnic" name="cnic" value="{{ old('cnic') }}" placeholder="XXXXX-XXXXXXX-X" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400">
                    </div>
                    <div>
                        <label for="date_of_birth" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Date of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-accent-400">
                    </div>
                    <div>
                        <label for="height_cm" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Height (cm)</label>
                        <input type="number" id="height_cm" name="height_cm" value="{{ old('height_cm') }}" min="100" max="250" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-accent-400">
                    </div>
                    <div>
                        <label for="city" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">City</label>
                        <input type="text" id="city" name="city" value="{{ old('city') }}" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="address" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Address</label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400">
                    </div>
                    <div>
                        <label for="level" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Level</label>
                        <select id="level" name="level" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-accent-400">
                            <option value="">Select level</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level }}" @selected(old('level') === $level)>{{ $level }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="sport" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Choose Sport *</label>
                        <select id="sport" name="sport" required class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-accent-400 @error('sport') border-red-500/60 @enderror">
                            <option value="">Select sport</option>
                            @foreach ($sports as $s)
                                <option value="{{ $s }}" @selected(old('sport') === $s)>{{ $s }}</option>
                            @endforeach
                        </select>
                        @error('sport') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="club_name" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Club Name <span class="text-gray-700">(optional)</span></label>
                        <input type="text" id="club_name" name="club_name" value="{{ old('club_name') }}" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400">
                    </div>
                    <div>
                        <label for="institution_name" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Institution Name <span class="text-gray-700">(if applicable)</span></label>
                        <input type="text" id="institution_name" name="institution_name" value="{{ old('institution_name') }}" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400">
                    </div>
                    <div>
                        <label for="parent_guardian_contact" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Parent/Guardian Contact <span class="text-gray-700">(for minors)</span></label>
                        <input type="text" id="parent_guardian_contact" name="parent_guardian_contact" value="{{ old('parent_guardian_contact') }}" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400">
                    </div>
                </div>
            </div>

            {{-- Section 2: Achievements --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8" x-data="{ achievements: {{ old('achievements', [['title' => '', 'year' => '', 'level' => '', 'description' => '']]) ? json_encode(old('achievements')) : '[{\"title\":\"\",\"year\":\"\",\"level\":\"\",\"description\":\"\"}]' }} }">
                <h3 class="mb-6 font-display text-2xl uppercase tracking-wide text-white">Section 2 — Achievements</h3>
                <p class="mb-4 text-sm text-gray-400">Enter your achievements one at a time. Click "Add More" to add additional entries.</p>
                <template x-for="(achievement, index) in achievements" :key="index">
                    <div class="mb-4 grid gap-3 rounded-xl border border-white/5 bg-accent-600 p-4 sm:grid-cols-4">
                        <input type="text" :name="'achievements['+index+'][title]'" x-model="achievement.title" placeholder="Title" class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400">
                        <input type="text" :name="'achievements['+index+'][year]'" x-model="achievement.year" placeholder="Year" class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400">
                        <input type="text" :name="'achievements['+index+'][level]'" x-model="achievement.level" placeholder="Level" class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400">
                        <div class="flex gap-2">
                            <input type="text" :name="'achievements['+index+'][description]'" x-model="achievement.description" placeholder="Description" class="flex-1 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400">
                            <button type="button" @click="if(achievements.length > 1) achievements.splice(index, 1)" class="rounded-lg border border-red-500/30 px-3 py-2 text-xs text-red-400 hover:bg-red-500/10">✕</button>
                        </div>
                    </div>
                </template>
                <button type="button" @click="achievements.push({title: '', year: '', level: '', description: ''})" class="rounded-full border border-accent-300 px-5 py-2 text-sm font-bold text-accent-400 transition hover:bg-accent-500/10">+ Add More</button>
            </div>

            {{-- Section 3: Media & About --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8">
                <h3 class="mb-6 font-display text-2xl uppercase tracking-wide text-white">Section 3 — Media & About</h3>
                <div class="space-y-5">
                    <div>
                        <label for="bio" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Tell us about yourself</label>
                        <textarea id="bio" name="bio" rows="4" class="w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400">{{ old('bio') }}</textarea>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Image URLs (up to 3 — photos of you playing)</label>
                        @for ($i = 0; $i < 3; $i++)
                            <input type="url" name="images[{{ $i }}]" value="{{ old("images.$i") }}" placeholder="https://example.com/photo.jpg" class="mb-2 w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400">
                        @endfor
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Video links (up to 3 — YouTube preferred)</label>
                        @for ($i = 0; $i < 3; $i++)
                            <input type="url" name="video_links[{{ $i }}]" value="{{ old("video_links.$i") }}" placeholder="https://youtube.com/watch?v=..." class="mb-2 w-full rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400">
                        @endfor
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-gray-400">Press mentions (optional)</label>
                        <div class="rounded-xl border border-white/5 bg-accent-600 p-4">
                            <input type="text" name="press_mentions[0][publication]" value="{{ old('press_mentions.0.publication') }}" placeholder="Publication / Channel name" class="mb-2 w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400">
                            <input type="url" name="press_mentions[0][link]" value="{{ old('press_mentions.0.link') }}" placeholder="Link to article" class="mb-2 w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-black placeholder-gray-400 outline-none focus:border-accent-400">
                            <input type="date" name="press_mentions[0][date]" value="{{ old('press_mentions.0.date') }}" class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm text-black outline-none focus:border-accent-400">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Consent --}}
            <div class="flex items-start gap-3">
                <input type="checkbox" id="consent" name="consent" value="1" required class="mt-1 size-4 rounded border-white/20 bg-accent-600 text-accent-500 focus:ring-accent-500">
                <label for="consent" class="text-sm text-gray-400">I agree to the <a href="{{ route('privacy') }}" class="text-accent-500 underline">Privacy Policy</a> and <a href="{{ route('terms') }}" class="text-accent-500 underline">Terms of Service</a>. I consent to the collection of my personal data including CNIC, images and videos. *</label>
            </div>
            @error('consent') <p class="-mt-4 text-xs text-red-400">{{ $message }}</p> @enderror

            <button type="submit" class="w-full rounded-full bg-accent-500 px-6 py-3.5 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-accent-400 sm:w-auto">Submit Application</button>
        </form>
    </section>
@endsection

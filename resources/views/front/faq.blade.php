@extends('layouts.public', ['settings' => $settings])

@section('title', 'FAQs — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-accent-600">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Got Questions?"
                title="Frequently Asked Questions"
                subtitle="Find answers to the most common questions about Sportika — from player registration to partnerships and everything in between."
            :inverted="true"
            />
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 py-14 sm:px-6 lg:px-8" x-data="{ open: null }">
        {{-- General --}}
        <h2 class="mb-6 font-display text-2xl uppercase tracking-wider text-white">General</h2>
        <div class="mb-12 space-y-3">
            @php $faqs = [
                ['q' => 'What is Sportika?', 'a' => 'Sportika is a player management and sports marketing platform based in Karachi, Pakistan. We represent athletes across multiple sports, organise tournaments, and connect players with sponsors, clubs, and media opportunities.'],
                ['q' => 'Which sports does Sportika cover?', 'a' => 'We cover all major sports played in Karachi and across Pakistan, including Cricket, Football, Futsal, Badminton, Chess, Padel, MMA, Boxing, Kabaddi, Volleyball, Basketball, Tennis, Table Tennis, Swimming, and Athletics.'],
                ['q' => 'Where is Sportika based?', 'a' => 'Our office is located in Karachi, Pakistan. However, we work with athletes at every level — from local club players to international competitors — across the country.'],
            ] @endphp
            @foreach ($faqs as $i => $faq)
                <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                    <button
                        @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                        class="flex w-full items-center justify-between px-6 py-4 text-left text-black transition hover:bg-blue-50"
                    >
                        <span class="pr-4 font-medium">{{ $faq['q'] }}</span>
                        <svg class="size-5 shrink-0 text-accent-500 transition-transform" :class="{ 'rotate-180': open === {{ $i }} }" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div x-show="open === {{ $i }}" x-collapse>
                        <div class="px-6 pb-5 text-sm leading-relaxed text-gray-400">{{ $faq['a'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Player Registration --}}
        <h2 class="mb-6 font-display text-2xl uppercase tracking-wider text-white">Player Registration</h2>
        <div class="mb-12 space-y-3">
            @php $faqs = [
                ['q' => 'How do I register as a player on Sportika?', 'a' => 'Click the "Join the Platform" button on the home page, then select "Join as Player". Fill out the registration form with your personal details, sport-specific information, achievements, and media. Once submitted, our admin team will review your application.'],
                ['q' => 'Is there a fee to register?', 'a' => 'Player registration on Sportika is free. There are no upfront costs to create your profile and be listed in our player directory.'],
                ['q' => 'What happens after I submit my registration?', 'a' => 'Our team reviews every application. If approved, your player profile and directory card are automatically created using the information you provided. You will be notified about the status of your application.'],
                ['q' => 'What is the difference between Unverified, Verified, and Featured status?', 'a' => 'Unverified means your profile is pending review. Verified means our team has confirmed your identity and details. Featured players are highlighted for their achievements or prominence and receive additional visibility on the platform.'],
                ['q' => 'Can I update my profile after it is created?', 'a' => 'Yes. Once your profile is live, you can contact us to request updates to your information, stats, achievements, or media. Our team will make the changes after verification.'],
                ['q' => 'Is my CNIC shown on my public profile?', 'a' => 'No. Your CNIC is collected for verification purposes only and is never displayed on your public profile. The same applies to your phone number — it is used for contact and verification only.'],
                ['q' => 'I am a school/college-level player. Can I still register?', 'a' => 'Absolutely. We welcome players at every level — School, College, University, Domestic, National, and International. If you are a minor, the form includes an optional Parent/Guardian Contact field.'],
            ] @endphp
            @foreach ($faqs as $i => $faq)
                <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                    <button
                        @click="open === 'p{{ $i }}' ? open = null : open = 'p{{ $i }}'"
                        class="flex w-full items-center justify-between px-6 py-4 text-left text-black transition hover:bg-blue-50"
                    >
                        <span class="pr-4 font-medium">{{ $faq['q'] }}</span>
                        <svg class="size-5 shrink-0 text-accent-500 transition-transform" :class="{ 'rotate-180': open === 'p{{ $i }}' }" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div x-show="open === 'p{{ $i }}'" x-collapse>
                        <div class="px-6 pb-5 text-sm leading-relaxed text-gray-400">{{ $faq['a'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Tournaments & Events --}}
        <h2 class="mb-6 font-display text-2xl uppercase tracking-wider text-white">Tournaments & Events</h2>
        <div class="mb-12 space-y-3">
            @php $faqs = [
                ['q' => 'How can I find upcoming tournaments?', 'a' => 'Visit the Tournaments page where you can filter by sport, city, and status (Upcoming, Ongoing, or Past) to find events relevant to you.'],
                ['q' => 'How do I participate in a tournament?', 'a' => 'Check the tournament detail page for registration information. If entry details are listed, follow the instructions. You can also contact us directly for help with tournament entries.'],
                ['q' => 'Can my brand sponsor a tournament?', 'a' => 'Yes! Visit our Sponsors page and click "Become a Sponsor" to submit an inquiry, or reach out via the Contact page. We offer various sponsorship and partnership packages.'],
            ] @endphp
            @foreach ($faqs as $i => $faq)
                <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                    <button
                        @click="open === 't{{ $i }}' ? open = null : open = 't{{ $i }}'"
                        class="flex w-full items-center justify-between px-6 py-4 text-left text-black transition hover:bg-blue-50"
                    >
                        <span class="pr-4 font-medium">{{ $faq['q'] }}</span>
                        <svg class="size-5 shrink-0 text-accent-500 transition-transform" :class="{ 'rotate-180': open === 't{{ $i }}' }" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div x-show="open === 't{{ $i }}'" x-collapse>
                        <div class="px-6 pb-5 text-sm leading-relaxed text-gray-400">{{ $faq['a'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Sponsorship & Partnerships --}}
        <h2 class="mb-6 font-display text-2xl uppercase tracking-wider text-white">Sponsorship & Partnerships</h2>
        <div class="mb-12 space-y-3">
            @php $faqs = [
                ['q' => 'How can my brand become a sponsor?', 'a' => 'Click "Join as Brand/Sponsor" from the home page, or visit the Sponsors page and click "Become a Sponsor". Fill out the form with your brand details and areas of interest (Sponsorship, Partnership, or Advertising). Our team will get back to you.'],
                ['q' => 'What kind of partnership opportunities are available?', 'a' => 'We offer tournament sponsorships, player endorsements, event branding, advertising on our platform, and co-branded content. Each partnership is tailored — reach out and we will discuss what works best for your brand.'],
                ['q' => 'Will I get visibility for my sponsorship?', 'a' => 'Absolutely. All sponsors and partners are featured on our Sponsors page with logos and descriptions. Depending on the partnership level, you may also get visibility across our social media, event banners, player profiles, and tournament coverage.'],
            ] @endphp
            @foreach ($faqs as $i => $faq)
                <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                    <button
                        @click="open === 's{{ $i }}' ? open = null : open = 's{{ $i }}'"
                        class="flex w-full items-center justify-between px-6 py-4 text-left text-black transition hover:bg-blue-50"
                    >
                        <span class="pr-4 font-medium">{{ $faq['q'] }}</span>
                        <svg class="size-5 shrink-0 text-accent-500 transition-transform" :class="{ 'rotate-180': open === 's{{ $i }}' }" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div x-show="open === 's{{ $i }}'" x-collapse>
                        <div class="px-6 pb-5 text-sm leading-relaxed text-gray-400">{{ $faq['a'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Podcast --}}
        <h2 class="mb-6 font-display text-2xl uppercase tracking-wider text-white">Podcast</h2>
        <div class="mb-12 space-y-3">
            @php $faqs = [
                ['q' => 'How can I apply to be a guest on the Sportika podcast?', 'a' => 'Visit the Podcast page and click "Apply for Podcast". Fill out the application form with your details, a pitch about why you should be featured, and your achievements. Our team reviews all applications and contacts selected guests directly.'],
                ['q' => 'What topics are covered on the podcast?', 'a' => 'Our podcast features conversations with athletes, coaches, and sports industry professionals. Topics include career journeys, training insights, tournament experiences, mental health in sports, and the business of sports.'],
            ] @endphp
            @foreach ($faqs as $i => $faq)
                <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                    <button
                        @click="open === 'pc{{ $i }}' ? open = null : open = 'pc{{ $i }}'"
                        class="flex w-full items-center justify-between px-6 py-4 text-left text-black transition hover:bg-blue-50"
                    >
                        <span class="pr-4 font-medium">{{ $faq['q'] }}</span>
                        <svg class="size-5 shrink-0 text-accent-500 transition-transform" :class="{ 'rotate-180': open === 'pc{{ $i }}' }" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </button>
                    <div x-show="open === 'pc{{ $i }}'" x-collapse>
                        <div class="px-6 pb-5 text-sm leading-relaxed text-gray-400">{{ $faq['a'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Still have questions? --}}
        <div class="mt-8 rounded-2xl border border-accent-200 bg-white p-8 text-center">
            <h3 class="font-display text-2xl tracking-wider text-white">Still have questions?</h3>
            <p class="mt-3 text-sm leading-relaxed text-gray-400">Can't find what you're looking for? Our team is happy to help.</p>
            <div class="mt-6 flex flex-wrap justify-center gap-3">
                <a href="{{ route('contact') }}" class="rounded-full bg-accent-500 px-6 py-3 text-sm font-bold uppercase tracking-wider text-white transition hover:bg-accent-400">
                    Contact us
                </a>
                <a href="mailto:{{ $settings->email }}" class="rounded-full border border-white/20 px-6 py-3 text-sm font-bold uppercase tracking-wider text-black transition hover:border-accent-400 hover:text-accent-400">
                    Email us
                </a>
            </div>
        </div>
    </section>
@endsection

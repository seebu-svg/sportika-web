@extends('layouts.public', ['settings' => $settings])

@section('title', 'Terms of Service — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-pitch-900">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Legal"
                title="Terms of Service"
                subtitle="Please read these terms carefully before using the Sportika platform."
            />
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="prose-custom space-y-10 text-sm leading-relaxed text-slate-400">
            <div>
                <p class="text-xs text-slate-500">Last updated: 17 September 2026</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-white">1. Acceptance of Terms</h2>
                <p>By accessing and using the Sportika website and platform ("Service"), you accept and agree to be bound by these Terms of Service ("Terms"). If you do not agree with any part of these Terms, you must not use our website or services.</p>
                <p class="mt-2">These Terms apply to all visitors, users, players, sponsors, and others who access or use the Service.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-white">2. Description of Service</h2>
                <p>Sportika is a player management and sports marketing platform that provides:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    <li>Player registration, profile creation, and directory listing</li>
                    <li>Tournament organisation, promotion, and coverage</li>
                    <li>Sponsor and partner matching and promotion</li>
                    <li>News, blog content, and podcast production</li>
                    <li>Media and press mention aggregation for players</li>
                    <li>A gallery of sports photography and video content</li>
                </ul>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-white">3. User Accounts & Registration</h2>
                <h3 class="mb-2 text-base font-semibold text-white">3.1 Player Registration</h3>
                <p>When you register as a player, you agree to provide accurate, current, and complete information. You are responsible for maintaining the accuracy of your profile information and updating it as necessary.</p>

                <h3 class="mt-4 mb-2 text-base font-semibold text-white">3.2 Brand/Sponsor Registration</h3>
                <p>When you register as a brand or sponsor, you represent that you are an authorised representative of the entity you are registering on behalf of.</p>

                <h3 class="mt-4 mb-2 text-base font-semibold text-white">3.3 Profile Approval</h3>
                <p>All registrations are subject to review and approval by our admin team. Sportika reserves the right to approve, reject, or remove any registration at its sole discretion. Approval of a registration does not constitute an endorsement of the individual or entity.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-white">4. Player Profiles & Content</h2>
                <h3 class="mb-2 text-base font-semibold text-white">4.1 Profile Content</h3>
                <p>By submitting content for your player profile (photos, videos, statistics, achievements, biographical information), you grant Sportika a non-exclusive, worldwide, royalty-free licence to display, distribute, and promote this content on the platform and associated marketing channels.</p>

                <h3 class="mt-4 mb-2 text-base font-semibold text-white">4.2 Accuracy of Information</h3>
                <p>Players are responsible for the accuracy of the information in their profiles. Sportika verifies player identities and credentials but does not guarantee the accuracy of all player-submitted data. Stats and achievements marked as "Unverified" have not been independently confirmed.</p>

                <h3 class="mt-4 mb-2 text-base font-semibold text-white">4.3 Status Badges</h3>
                <p>Player status badges (Unverified, Verified, Featured) reflect Sportika's assessment of profile completeness and authenticity. These badges are for informational purposes and do not constitute a guarantee or warranty of any kind.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-white">5. Intellectual Property</h2>
                <h3 class="mb-2 text-base font-semibold text-white">5.1 Our Content</h3>
                <p>The Sportika name, logo, branding, website design, and original content (excluding user-submitted content) are the property of Sportika and are protected by copyright, trademark, and other intellectual property laws.</p>

                <h3 class="mt-4 mb-2 text-base font-semibold text-white">5.2 User Content</h3>
                <p>Players retain ownership of their photographs, videos, and other content submitted to the platform. By submitting content, you confirm that you own or have the necessary rights to share the content and that it does not infringe on any third-party rights.</p>

                <h3 class="mt-4 mb-2 text-base font-semibold text-white">5.3 Prohibited Content</h3>
                <p>You must not submit content that is illegal, defamatory, obscene, or infringes on the intellectual property rights of others. Sportika reserves the right to remove any content that violates these Terms.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-white">6. Sponsorships & Partnerships</h2>
                <p>Sportika facilitates connections between players and sponsors/brands. Any sponsorship or partnership agreements entered into between parties are separate from these Terms and are the responsibility of the respective parties. Sportika is not a party to any agreement between players and sponsors and bears no liability for the performance or breach of such agreements.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-white">7. Tournament Participation</h2>
                <p>Participation in Sportika-organised or affiliated tournaments is subject to the specific rules and conditions of each event. Registration for a tournament constitutes acceptance of those event-specific terms in addition to these general Terms.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-white">8. Prohibited Uses</h2>
                <p>You agree not to use the Service:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    <li>For any unlawful purpose or in violation of any applicable laws or regulations</li>
                    <li>To submit false or misleading information</li>
                    <li>To impersonate another person or entity</li>
                    <li>To harass, abuse, or harm another person</li>
                    <li>To interfere with or disrupt the Service or its servers</li>
                    <li>To attempt to gain unauthorised access to any part of the Service</li>
                    <li>To scrape, data-mine, or systematically extract content without our written consent</li>
                    <li>To upload viruses or malicious code</li>
                </ul>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-white">9. Disclaimer of Warranties</h2>
                <p>The Service is provided on an "as is" and "as available" basis. Sportika makes no warranties, express or implied, regarding the Service, including but not limited to the accuracy of player profiles, the availability of tournaments, or the suitability of the platform for any particular purpose.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-white">10. Limitation of Liability</h2>
                <p>To the maximum extent permitted by law, Sportika shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including but not limited to loss of profits, data, or goodwill, arising from your use of or inability to use the Service.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-white">11. Indemnification</h2>
                <p>You agree to indemnify and hold harmless Sportika, its team members, partners, and affiliates from any claims, damages, losses, or expenses arising from your use of the Service, your violation of these Terms, or your violation of any third-party rights.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-white">12. Termination</h2>
                <p>Sportika reserves the right to suspend or terminate your access to the Service at any time, without notice, for conduct that violates these Terms or is harmful to other users, the Service, or third parties. You may discontinue using the Service at any time.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-white">13. Changes to Terms</h2>
                <p>We reserve the right to modify these Terms at any time. Changes will be effective immediately upon posting on the website. Your continued use of the Service after changes are posted constitutes acceptance of the modified Terms. We encourage you to review these Terms periodically.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-white">14. Governing Law</h2>
                <p>These Terms shall be governed by and construed in accordance with the laws of Pakistan. Any disputes arising from these Terms or the use of the Service shall be subject to the exclusive jurisdiction of the courts of Karachi, Pakistan.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-white">15. Contact Us</h2>
                <p>If you have questions about these Terms, please contact us:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    @if ($settings->email)<li>Email: <a href="mailto:{{ $settings->email }}" class="text-accent-400 hover:underline">{{ $settings->email }}</a></li>@endif
                    @if ($settings->phone)<li>Phone: <a href="tel:{{ $settings->phone }}" class="text-accent-400 hover:underline">{{ $settings->phone }}</a></li>@endif
                    @if ($settings->address)<li>Address: {{ $settings->address }}</li>@endif
                </ul>
            </div>
        </div>
    </section>
@endsection

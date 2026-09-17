@extends('layouts.public', ['settings' => $settings])

@section('title', 'Privacy Policy — '.$settings->site_name)

@section('content')
    <section class="relative overflow-hidden bg-accent-600">
        <div class="bg-diagonal absolute inset-0"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <x-section-heading
                eyebrow="Legal"
                title="Privacy Policy"
                subtitle="How we collect, use, and protect your personal data."
            :inverted="true"
            />
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="prose-custom space-y-10 text-sm leading-relaxed text-gray-400">
            <div>
                <p class="text-xs text-gray-400">Last updated: 17 September 2026</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-black">1. Introduction</h2>
                <p>Welcome to Sportika ("we", "our", or "us"). This Privacy Policy explains how we collect, use, disclose, and safeguard your personal data when you visit our website, interact with our services, or engage with our platform. We are committed to protecting your privacy and ensuring your personal information is handled responsibly.</p>
                <p class="mt-2">By using our website and services, you agree to the collection and use of information in accordance with this policy.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-black">2. Information We Collect</h2>
                <h3 class="mb-2 text-base font-semibold text-black">2.1 Personal Information</h3>
                <p>We may collect the following personal data:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    <li>Full name, email address, phone number, and physical address</li>
                    <li>CNIC (national identity card number) — collected for player verification only and never displayed publicly</li>
                    <li>Date of birth, height, and other physical/personal details (for player profiles)</li>
                    <li>Sport-specific statistics, achievements, and career details</li>
                    <li>Photographs, video links, and media content you provide</li>
                    <li>Press mentions and media coverage you submit</li>
                    <li>Biographical information and personal statements</li>
                </ul>

                <h3 class="mt-4 mb-2 text-base font-semibold text-black">2.2 Registration Data</h3>
                <p>When you register as a player or brand/sponsor, we collect all information submitted through our registration forms, including personal details, sport-specific information, institutional affiliations, and media content.</p>

                <h3 class="mt-4 mb-2 text-base font-semibold text-black">2.3 Contact & Communication Data</h3>
                <p>When you contact us through our forms, email, or phone, we collect your name, email, phone number, message content, and IP address.</p>

                <h3 class="mt-4 mb-2 text-base font-semibold text-black">2.4 Technical Data</h3>
                <p>We may automatically collect browser type, device information, IP address, pages visited, and referring URL when you use our website.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-black">3. How We Use Your Information</h2>
                <p>We use the collected data for the following purposes:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    <li>To create and manage player profiles and directory listings</li>
                    <li>To process player and brand/sponsor registration applications</li>
                    <li>To verify player identities and credentials</li>
                    <li>To facilitate communication between players, sponsors, organisers, and media</li>
                    <li>To respond to your enquiries, messages, and support requests</li>
                    <li>To organise and promote tournaments and events</li>
                    <li>To produce and publish podcast content</li>
                    <li>To publish news, blog posts, and other editorial content</li>
                    <li>To display sponsor and partner information on our platform</li>
                    <li>To improve our website, services, and user experience</li>
                    <li>To comply with legal obligations</li>
                </ul>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-black">4. Data Sharing & Disclosure</h2>
                <p>We may share your personal data in the following circumstances:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    <li><strong class="text-black">Player Profiles:</strong> Approved player information is displayed publicly on the Sportika platform. Sensitive data (CNIC, phone number) is never shown publicly.</li>
                    <li><strong class="text-black">Service Providers:</strong> We may share data with third-party service providers who assist in operating our website (hosting, email delivery, analytics).</li>
                    <li><strong class="text-black">Sponsors & Organisers:</strong> With your consent, we may share player profiles with sponsors or tournament organisers for legitimate opportunities.</li>
                    <li><strong class="text-black">Legal Requirements:</strong> We may disclose data if required by law, regulation, or legal proceedings.</li>
                    <li><strong class="text-black">Business Transfers:</strong> In the event of a merger, acquisition, or sale of assets, your data may be transferred to the successor entity.</li>
                </ul>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-black">5. Data Retention</h2>
                <p>We retain your personal data for as long as your player profile is active or as needed to fulfil the purposes outlined in this policy. If you request deletion of your account, we will remove your data within 30 days, except where we are required to retain it for legal or regulatory purposes.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-black">6. Your Rights</h2>
                <p>You have the following rights regarding your personal data:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    <li><strong class="text-black">Access:</strong> Request a copy of the personal data we hold about you.</li>
                    <li><strong class="text-black">Correction:</strong> Request correction of inaccurate or incomplete data.</li>
                    <li><strong class="text-black">Deletion:</strong> Request deletion of your personal data, subject to legal requirements.</li>
                    <li><strong class="text-black">Objection:</strong> Object to certain uses of your data, such as marketing communications.</li>
                    <li><strong class="text-black">Portability:</strong> Request transfer of your data to another service.</li>
                    <li><strong class="text-black">Withdrawal of Consent:</strong> Where processing is based on consent, you may withdraw it at any time.</li>
                </ul>
                <p class="mt-2">To exercise any of these rights, please contact us at the email address listed on our website.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-black">7. Data Security</h2>
                <p>We implement appropriate technical and organisational measures to protect your personal data against unauthorised access, alteration, disclosure, or destruction. However, no method of transmission over the internet is 100% secure, and we cannot guarantee absolute security.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-black">8. Cookies</h2>
                <p>Our website may use cookies or similar technologies to enhance user experience and collect usage data. You can control cookie settings through your browser preferences.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-black">9. Children's Privacy</h2>
                <p>Our platform is open to players of all ages, including school-level athletes who may be minors. For users under 18, we recommend that a parent or guardian reviews this privacy policy and provides consent before submitting personal data through our registration forms. We include an optional Parent/Guardian Contact field for school and college-level players.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-black">10. Changes to This Policy</h2>
                <p>We may update this Privacy Policy from time to time to reflect changes in our practices or legal requirements. We will notify you of significant changes by posting a notice on our website or sending an email. Your continued use of our services after changes are posted constitutes acceptance of the updated policy.</p>
            </div>

            <div>
                <h2 class="mb-3 font-display text-xl uppercase tracking-wider text-black">11. Contact Us</h2>
                <p>If you have questions, concerns, or requests regarding this Privacy Policy or our data practices, please contact us:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    @if ($settings->email)<li>Email: <a href="mailto:{{ $settings->email }}" class="text-accent-500 hover:underline">{{ $settings->email }}</a></li>@endif
                    @if ($settings->phone)<li>Phone: <a href="tel:{{ $settings->phone }}" class="text-accent-500 hover:underline">{{ $settings->phone }}</a></li>@endif
                    @if ($settings->address)<li>Address: {{ $settings->address }}</li>@endif
                </ul>
            </div>
        </div>
    </section>
@endsection

@extends('frontend.master')
@section('title', 'Privacy Policy')

@section('content')

    <header class="page-hero" style="--page-img:url('{{ asset('resources/frontend/img/banner.webp') }}')">
        <div class="container">
            <nav class="crumbs" aria-label="Breadcrumb">
                <a @spa href="{{ route('home') }}">Home</a><span class="sep">/</span><span>Privacy Policy</span>
            </nav>
            <span class="eyebrow light">Legal</span>
            <h1>Privacy Policy</h1>
            <p class="lead mt-3">Last updated: {{ date('F Y') }}</p>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="prose">

                        <h2>1. Who we are</h2>
                        <p>Unheard Voices MK is a registered charity based in Milton Keynes, UK. We are committed to
                            protecting your privacy and handling your personal data responsibly. This policy explains what
                            data we collect, how we use it, and your rights.</p>

                        <h2>2. What data we collect</h2>
                        <p>We may collect the following types of personal information:</p>
                        <ul>
                            <li>Name, email address, and phone number when you contact us or sign up for our newsletter</li>
                            <li>Donation details (name, email, amount) when you make a donation</li>
                            <li>Volunteer application information</li>
                            <li>Technical data such as IP address, browser type, and pages visited (via cookies)</li>
                        </ul>

                        <h2>3. How we use your data</h2>
                        <p>We use your personal data to:</p>
                        <ul>
                            <li>Respond to your enquiries and messages</li>
                            <li>Process donations and issue Gift Aid declarations</li>
                            <li>Send you updates about our work (only with your consent)</li>
                            <li>Improve our website and services</li>
                            <li>Meet legal and regulatory obligations</li>
                        </ul>

                        <h2>4. Legal basis for processing</h2>
                        <p>We process your data on the following legal bases:</p>
                        <ul>
                            <li><strong>Consent</strong> — when you opt in to marketing communications</li>
                            <li><strong>Legitimate interests</strong> — to respond to enquiries and improve our services
                            </li>
                            <li><strong>Legal obligation</strong> — to comply with charity law and HMRC requirements</li>
                        </ul>

                        <h2>5. Data sharing</h2>
                        <p>We do not sell or rent your personal data to third parties. We may share data with trusted
                            service providers (e.g. email platforms, payment processors) who process data on our behalf
                            under strict data protection agreements.</p>

                        <h2>6. Data retention</h2>
                        <p>We retain your personal data only for as long as necessary. Contact form submissions are kept for
                            up to 2 years. Donation records may be retained for up to 7 years for accounting purposes.</p>

                        <h2>7. Cookies</h2>
                        <p>Our website uses essential cookies to function correctly. We may also use analytics cookies to
                            understand how visitors use our site. You can control cookie settings in your browser.</p>

                        <h2>8. Your rights</h2>
                        <p>Under UK GDPR, you have the right to:</p>
                        <ul>
                            <li>Access the personal data we hold about you</li>
                            <li>Request correction of inaccurate data</li>
                            <li>Request deletion of your data</li>
                            <li>Object to or restrict processing</li>
                            <li>Withdraw consent at any time</li>
                            <li>Lodge a complaint with the ICO (ico.org.uk)</li>
                        </ul>

                        <h2>9. Contact us</h2>
                        <p>If you have any questions about these terms, please <a @spa href="{{ route('contact') }}">get in
                                touch with us</a>.</p>

                        <blockquote>We are committed to keeping your information safe and using it only to support our
                            mission.</blockquote>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.cta')

@endsection

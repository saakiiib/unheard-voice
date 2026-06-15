@extends('frontend.master')
@section('title', 'Terms & Conditions')

@section('content')

    <header class="page-hero" style="--page-img:url('{{ asset('resources/frontend/img/banner.webp') }}')">
        <div class="container">
            <nav class="crumbs" aria-label="Breadcrumb">
                <a @spa href="{{ route('home') }}">Home</a><span class="sep">/</span><span>Terms & Conditions</span>
            </nav>
            <span class="eyebrow light">Legal</span>
            <h1>Terms and Conditions</h1>
            <p class="lead mt-3">Last updated: {{ date('F Y') }}</p>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="prose">

                        <h2>1. About us</h2>
                        <p>Unheard Voices MK is a registered charity in England and Wales. By using our website, you agree
                            to these terms. Please read them carefully.</p>

                        <h2>2. Use of our website</h2>
                        <p>You may use our website for lawful purposes only. You must not use it in any way that breaches
                            applicable laws, infringes anyone's rights, or is fraudulent or harmful.</p>

                        <h2>3. Intellectual property</h2>
                        <p>All content on this website — including text, images, logos, and graphics — is owned by or
                            licensed to Unheard Voices MK. You may not reproduce or distribute any content without our prior
                            written permission.</p>

                        <h2>4. Donations</h2>
                        <p>All donations made through this website are voluntary and non-refundable unless an error has
                            occurred. We use donations solely to fund our charitable activities. Gift Aid declarations are
                            processed in accordance with HMRC guidelines.</p>

                        <h2>5. Third-party links</h2>
                        <p>Our website may contain links to external websites. We are not responsible for the content or
                            privacy practices of those sites. Visiting them is at your own risk.</p>

                        <h2>6. Disclaimer</h2>
                        <p>The content on this website is provided for general information only. It is not intended as
                            professional medical, legal, or financial advice. We make no guarantees about the accuracy or
                            completeness of the information provided.</p>

                        <h2>7. Limitation of liability</h2>
                        <p>To the fullest extent permitted by law, Unheard Voices MK shall not be liable for any loss or
                            damage arising from your use of this website or reliance on any content published here.</p>

                        <h2>8. Changes to these terms</h2>
                        <p>We may update these terms from time to time. Continued use of the website after any changes
                            constitutes acceptance of the revised terms. We encourage you to review this page periodically.
                        </p>

                        <h2>9. Governing law</h2>
                        <p>These terms are governed by the laws of England and Wales. Any disputes shall be subject to the
                            exclusive jurisdiction of the courts of England and Wales.</p>

                        <h2>10. Contact us</h2>
                        <p>If you have any questions about these terms, please <a @spa href="{{ route('contact') }}">get in
                                touch with us</a>.</p>

                        <blockquote>By using this website, you acknowledge that you have read and understood these terms.
                        </blockquote>

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.cta')

@endsection

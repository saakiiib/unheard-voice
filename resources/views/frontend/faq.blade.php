@extends('frontend.master')
@section('title', 'FAQs')

@section('content')

    <header class="page-hero" style="--page-img:url('{{ asset('resources/frontend/img/banner.webp') }}')">
        <div class="container">
            <nav class="crumbs" aria-label="Breadcrumb">
                <a @spa href="{{ route('home') }}">Home</a><span class="sep">/</span><span>FAQs</span>
            </nav>
            <span class="eyebrow light">Help</span>
            <h1>Frequently Asked Questions</h1>
            <p class="lead mt-3">Find answers to the most common questions about our work, events, and how to get involved.</p>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <span class="eyebrow">General</span>
                    <h2 class="mb-4">About Unheard Voices</h2>

                    <div class="accordion" id="faqGeneral">

                        <div class="accordion-item border mb-3 rounded-3 overflow-hidden">
                            <h3 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    What is Unheard Voices MK?
                                </button>
                            </h3>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqGeneral">
                                <div class="accordion-body text-muted">
                                    Unheard Voices MK is a registered charity based in Milton Keynes dedicated to providing culturally sensitive, stigma-free mental health support to ethnically diverse communities.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border mb-3 rounded-3 overflow-hidden">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Who do you support?
                                </button>
                            </h3>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqGeneral">
                                <div class="accordion-body text-muted">
                                    We support individuals and families from ethnically diverse communities in Milton Keynes, particularly those who face language barriers or cultural stigma around mental health.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border mb-3 rounded-3 overflow-hidden">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Are your services free?
                                </button>
                            </h3>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqGeneral">
                                <div class="accordion-body text-muted">
                                    Yes. All of our workshops, community meetups, and support sessions are completely free of charge, made possible through donations and grants.
                                </div>
                            </div>
                        </div>

                    </div>

                    <span class="eyebrow mt-5 d-block">Getting involved</span>
                    <h2 class="mb-4">Volunteering & Donations</h2>

                    <div class="accordion" id="faqInvolve">

                        <div class="accordion-item border mb-3 rounded-3 overflow-hidden">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    How can I volunteer?
                                </button>
                            </h3>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqInvolve">
                                <div class="accordion-body text-muted">
                                    We welcome volunteers with a range of skills. Please <a @spa href="{{ route('contact') }}">get in touch with us</a> and tell us a little about yourself and how you'd like to help.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border mb-3 rounded-3 overflow-hidden">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    How do I make a donation?
                                </button>
                            </h3>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqInvolve">
                                <div class="accordion-body text-muted">
                                    You can donate securely through our <a @spa href="{{ route('donate') }}">donation page</a>. We accept one-off and monthly donations. Gift Aid is available for UK taxpayers.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border mb-3 rounded-3 overflow-hidden">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                    Can my organisation partner with you?
                                </button>
                            </h3>
                            <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqInvolve">
                                <div class="accordion-body text-muted">
                                    Absolutely. We welcome partnerships with organisations that share our values. Please <a @spa href="{{ route('contact') }}">contact us</a> to start a conversation.
                                </div>
                            </div>
                        </div>

                    </div>

                    <span class="eyebrow mt-5 d-block">Events & Activities</span>
                    <h2 class="mb-4">Attending our sessions</h2>

                    <div class="accordion" id="faqEvents">

                        <div class="accordion-item border mb-3 rounded-3 overflow-hidden">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                                    Do I need to register for events?
                                </button>
                            </h3>
                            <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqEvents">
                                <div class="accordion-body text-muted">
                                    Some events require registration while others are open to all. Check the individual event page for details or <a @spa href="{{ route('contact') }}">contact us</a> if you are unsure.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border mb-3 rounded-3 overflow-hidden">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq8">
                                    Are events available online?
                                </button>
                            </h3>
                            <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqEvents">
                                <div class="accordion-body text-muted">
                                    Some of our sessions are available online or in a hybrid format. View our <a @spa href="{{ route('events') }}">events page</a> for the latest information.
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

    @include('frontend.cta')

@endsection
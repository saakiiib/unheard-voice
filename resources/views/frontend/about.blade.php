@extends('frontend.master')
@section('title', 'About Us')

@section('content')

    <header class="page-hero" style="--page-img: url('{{ asset('resources/frontend/img/banner.webp') }}')">
        <div class="container">
            <nav class="crumbs" aria-label="Breadcrumb">
                <a @spa href="{{ route('home') }}">Home</a>
                <span class="sep">/</span>
                <span>About</span>
            </nav>

            <span class="eyebrow light">About Us</span>
            <h1>Breaking the silence,<br>together.</h1>
            <p class="lead mt-3">
                Supporting the mental health and wellbeing of ethnically diverse communities through culturally sensitive,
                stigma-free support.
            </p>
        </div>
    </header>

    {{-- Hero Intro --}}
    <section class="py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-7">
                    <span class="eyebrow">Supporting Mental Health & Wellbeing</span>
                    <h2>For diverse communities with stigma-free support</h2>
                    <hr class="divider">
                    <p class="lead">At Unheard Voices, we believe no one should suffer in silence. Too often, people from
                        ethnically diverse communities face stigma, cultural barriers, or language challenges that prevent
                        them from getting the help they need.</p>
                    <p class="lead">We exist to change that — by creating safe, compassionate spaces where mental health
                        can
                        be spoken about openly, and every individual feels understood and supported.</p>
                </div>
                <div class="col-lg-5">
                    <img src="{{ asset('resources/frontend/img/about-2.webp') }}" alt="" class="story-img">
                </div>
            </div>
        </div>
    </section>

    {{-- Our Story --}}
    <section>
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6"><img src="{{ asset('resources/frontend/img/about-1.webp') }}" alt=""
                        class="story-img"></div>
                <div class="col-lg-6">
                    <span class="eyebrow">Our Story</span>
                    <h2>Born from lived experience.</h2>
                    <hr class="divider">
                    <p>Unheard Voices began as a grassroots response to a pressing need in our local communities of
                        Buckinghamshire and Bedfordshire. Founders with lived experience saw the deep stigma and cultural
                        silence around mental health, especially in families and older generations.</p>
                    <p>Mainstream services were not always accessible or culturally sensitive — leaving too many people
                        isolated. By combining professional expertise with community knowledge and lived experience, Unheard
                        Voices was born.</p>
                    <p>Unlike larger organisations, we put cultural awareness at the heart of everything we do, ensuring our
                        work truly resonates with the communities we serve.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Vision & Mission --}}
    <section class="bg-cream">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card-soft h-100"><span class="icon-circle"><i class="bi bi-eye"></i></span>
                        <h3>Our Vision</h3>
                        <p>A society where every individual — regardless of background, culture, or language — has equal
                            access to mental health support, free from stigma or barriers.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-soft h-100"><span class="icon-circle"><i class="bi bi-bullseye"></i></span>
                        <h3>Our Mission</h3>
                        <p>To support the mental health and wellbeing of ethnically diverse and wider communities through
                            culturally sensitive services, open conversations, and strong community connections.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- What We Do --}}
    <section>
        <div class="container">
            <div class="text-center mb-5"><span class="eyebrow">What We Do</span>
                <h2>Five approaches guide our work</h2>
                <hr class="divider mx-auto">
                <p class="lead muted">We address the cultural and structural barriers that prevent people from seeking help.
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card-soft"><span class="icon-circle"><i class="bi bi-chat-heart"></i></span>
                        <h3>Breaking Stigma</h3>
                        <p>Opening up honest, supportive conversations about mental health in trusted community spaces.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-soft"><span class="icon-circle"><i class="bi bi-people-fill"></i></span>
                        <h3>Inclusive Community Support</h3>
                        <p>Empowering diverse communities to overcome challenges, build resilience, and support one another.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-soft"><span class="icon-circle"><i class="bi bi-heart-pulse"></i></span>
                        <h3>Holistic Wellbeing</h3>
                        <p>Promoting not just emotional health, but physical and social wellbeing for balanced, resilient
                            lives.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-soft"><span class="icon-circle"><i class="bi bi-globe-asia-australia"></i></span>
                        <h3>Culturally Sensitive Care</h3>
                        <p>Ensuring services are shaped by lived experience and cultural understanding, so people feel safe
                            and respected.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-soft"><span class="icon-circle"><i class="bi bi-diagram-3"></i></span>
                        <h3>Community Empowerment</h3>
                        <p>Building networks and champions within communities so people can support one another long after
                            workshops or events end.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-soft" style="background:var(--dark);color:#fff;border-color:var(--dark)">
                        <h3 style="color:#fff">Meet the team behind it</h3>
                        <p style="color:rgba(255,255,255,.7)">Trustees and advisors with lived experience and professional
                            expertise.</p><a @spa href="{{ route('team') }}" class="btn btn-teal mt-2">Meet Our Team</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Core Values --}}
    <section class="bg-cream">
        <div class="container">
            <div class="text-center mb-5"><span class="eyebrow">Our Core Values</span>
                <h2>What we stand for</h2>
                <hr class="divider mx-auto">
                <p class="lead muted">At the heart of Unheard Voices are five core values that guide our work and shape our
                    community.</p>
            </div>
            <div class="values-grid">
                <div class="value-pill"><span class="ico"><i class="bi bi-heart-fill"></i></span>
                    <h4>Respect</h4>
                    <p class="muted mb-0 small mt-2">Every voice matters, and differences are embraced.</p>
                </div>
                <div class="value-pill"><span class="ico"><i class="bi bi-hand-thumbs-up-fill"></i></span>
                    <h4>Commitment</h4>
                    <p class="muted mb-0 small mt-2">We are dedicated to lasting impact and consistent support.</p>
                </div>
                <div class="value-pill"><span class="ico"><i class="bi bi-stars"></i></span>
                    <h4>Diversity</h4>
                    <p class="muted mb-0 small mt-2">Celebrating differences as strengths, driving innovation and inclusion.
                    </p>
                </div>
                <div class="value-pill"><span class="ico"><i class="bi bi-people"></i></span>
                    <h4>Collaboration</h4>
                    <p class="muted mb-0 small mt-2">Working together across cultures and perspectives to achieve change.
                    </p>
                </div>
                <div class="value-pill"><span class="ico"><i class="bi bi-heart"></i></span>
                    <h4>Empathy</h4>
                    <p class="muted mb-0 small mt-2">Leading with compassion, understanding, and lived experience.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    @include('frontend.cta')

@endsection
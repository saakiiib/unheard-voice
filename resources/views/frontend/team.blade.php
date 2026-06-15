@extends('frontend.master')
@section('title', 'About Us')

@section('content')

    <header class="page-hero" style="--page-img: url('{{ asset('resources/frontend/img/banner.webp') }}')">
        <div class="container">
            <nav class="crumbs" aria-label="Breadcrumb">
                <a @spa href="{{ route('home') }}">Home</a>
                <span class="sep">/</span><span>Our Team</span>
            </nav>
            <span class="eyebrow light">Our Team</span>
            <h1>Meet the people behind Unheard Voices.</h1>
            <p class="lead mt-3">Our trustees and advisors bring together lived experience, professional expertise, and deep
                community roots. Each member shares a commitment to breaking the silence on mental health.</p>
        </div>
    </header>

    {{-- Leadership --}}
    @if ($leadership->isNotEmpty())
        <section>
            <div class="container">
                <span class="eyebrow">Trustees</span>
                <h2>Leadership Team</h2>
                <hr class="divider">
                <p class="lead muted mb-5">Guiding our charity with passion and purpose.</p>
                <div class="row g-4">
                    @foreach ($leadership as $member)
                        <div class="col-md-6 col-lg-4">
                            <div class="team-card">
                                <div class="ph"
                                    style="background-image:url('{{ $member->image && $member->image !== 'placeholder.webp' ? asset($member->image) : asset('placeholder.webp') }}')">
                                </div>
                                <h3>{{ $member->name }}</h3>
                                <div class="role">{{ $member->position }}</div>
                                @if ($member->description)
                                    <p>{{ $member->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Advisors --}}
    @if ($advisors->isNotEmpty())
        <section class="bg-cream">
            <div class="container">
                <span class="eyebrow">Advisors</span>
                <h2>Our Advisors</h2>
                <hr class="divider">
                <p class="lead muted mb-5">Trusted voices supporting our strategy and reach.</p>
                <div class="row g-4">
                    @foreach ($advisors as $member)
                        <div class="col-md-6 col-lg-4">
                            <div class="team-card">
                                <div class="ph"
                                    style="background-image:url('{{ $member->image && $member->image !== 'placeholder.webp' ? asset($member->image) : asset('placeholder.webp') }}')">
                                </div>
                                <h3>{{ $member->name }}</h3>
                                <div class="role">{{ $member->position }}</div>
                                @if ($member->description)
                                    <p>{{ $member->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @include('frontend.cta')

@endsection
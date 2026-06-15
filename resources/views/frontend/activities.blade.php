@extends('frontend.master')
@section('title', 'Activities')

@section('content')

    <header class="page-hero" style="--page-img:url('{{ asset('resources/frontend/img/banner.webp') }}')">
        <div class="container">
            <nav class="crumbs" aria-label="Breadcrumb">
                <a @spa href="{{ route('home') }}">Home</a><span class="sep">/</span><span>Activities</span>
            </nav>
            <span class="eyebrow light">Activities</span>
            <h1>Our Activities</h1>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="row g-4">
                @forelse($activities as $activity)
                    <div class="col-md-6 col-lg-4">
                        <a class="activity-card d-block text-decoration-none" @spa
                            href="{{ route('activity.details', $activity->slug) }}">
                            <div class="thumb-wrap">
                                @if ($activity->category)
                                    <span class="cat-pill">{{ $activity->category->name }}</span>
                                @endif
                                <div class="thumb"
                                    style="background-image:url('{{ $activity->image && $activity->image !== 'placeholder.webp' ? asset($activity->image) : asset('placeholder.webp') }}')">
                                </div>
                            </div>
                            <div class="body">
                                <div class="meta-row">
                                    @if ($activity->activity_date)
                                        <span><i
                                                class="bi bi-calendar3"></i>{{ \Carbon\Carbon::parse($activity->activity_date)->format('d M Y') }}</span>
                                    @endif
                                    @if ($activity->location)
                                        <span><i
                                                class="bi bi-geo-alt"></i>{{ Str::before($activity->location, ',') }}</span>
                                    @endif
                                </div>
                                <h3>{{ $activity->title }}</h3>
                                <span class="more">Read more <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">No activities found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    @include('frontend.cta')

@endsection
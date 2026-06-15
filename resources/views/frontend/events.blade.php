@extends('frontend.master')
@section('title', 'Events')

@section('content')

    <header class="page-hero" style="--page-img:url('{{ asset('resources/frontend/img/banner.webp') }}')">
        <div class="container">
            <nav class="crumbs" aria-label="Breadcrumb">
                <a @spa href="{{ route('home') }}">Home</a><span class="sep">/</span><span>Events</span>
            </nav>
            <span class="eyebrow light">Events</span>
            <h1>Events and highlights.</h1>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="row g-4">
                @foreach($events as $event)
                <div class="col-md-6 col-lg-4">
                    <a class="activity-card d-block text-decoration-none" @spa href="{{ route('event.details', $event->slug) }}">
                        <div class="thumb-wrap">
                            @if($event->category)
                                <span class="cat-pill">{{ $event->category->name }}</span>
                            @endif
                            <div class="thumb" style="background-image:url('{{ $event->image && $event->image !== 'placeholder.webp' ? asset($event->image) : asset('placeholder.webp') }}')"></div>
                        </div>
                        <div class="body">
                            <div class="meta-row">
                                @if($event->event_date)
                                    <span><i class="bi bi-calendar3"></i>{{ $event->event_date->format('d M Y') }}</span>
                                @endif
                                @if($event->location)
                                    <span><i class="bi bi-geo-alt"></i>{{ Str::before($event->location, ',') }}</span>
                                @endif
                            </div>
                            <h3>{{ $event->title }}</h3>
                            <span class="more">View event <i class="bi bi-arrow-right"></i></span>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('frontend.cta')

@endsection
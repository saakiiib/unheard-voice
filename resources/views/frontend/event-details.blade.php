@extends('frontend.master')
@section('title', $event->title)

@section('content')

    <header class="page-hero" style="--page-img:url('{{ $event->image && $event->image !== 'placeholder.webp' ? asset($event->image) : asset('resources/frontend/img/banner.webp') }}')">
        <div class="container">
            <nav class="crumbs" aria-label="Breadcrumb">
                <a @spa href="{{ route('home') }}">Home</a><span class="sep">/</span>
                <a @spa href="{{ route('events') }}">Events</a><span class="sep">/</span>
                <span>{{ $event->title }}</span>
            </nav>
            @if($event->category)
                <span class="eyebrow light">{{ $event->category->name }}</span>
            @endif
            <h1>{{ $event->title }}</h1>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    @if($event->image && $event->image !== 'placeholder.webp')
                        <img src="{{ asset($event->image) }}" alt="{{ $event->title }}" class="detail-hero-img">
                    @endif

                    <div class="d-flex flex-wrap gap-3 mb-4 align-items-center">
                        @if($event->category)
                            <span class="tag">{{ $event->category->name }}</span>
                        @endif
                        @if($event->event_date)
                            <span class="muted" style="font-size:.92rem">
                                <i class="bi bi-calendar3 me-1"></i>{{ $event->event_date->format('d M Y') }}
                            </span>
                            <span class="muted" style="font-size:.92rem">
                                <i class="bi bi-clock me-1"></i>{{ $event->event_date->format('h:i A') }}
                            </span>
                        @endif
                        @if($event->location)
                            <span class="muted" style="font-size:.92rem">
                                <i class="bi bi-geo-alt me-1"></i>{{ $event->location }}
                            </span>
                        @endif
                    </div>

                    <div class="prose">
                        {!! $event->body !!}
                    </div>
                </div>

                <div class="col-lg-4">
                    <aside class="detail-aside">
                        <h4>Event details</h4>
                        @if($event->event_date)
                        <div class="info-row">
                            <div class="ico"><i class="bi bi-calendar3"></i></div>
                            <div>
                                <div class="lbl">Date</div>
                                <div class="val">{{ $event->event_date->format('d M Y') }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="ico"><i class="bi bi-clock"></i></div>
                            <div>
                                <div class="lbl">Time</div>
                                <div class="val">{{ $event->event_date->format('h:i A') }}</div>
                            </div>
                        </div>
                        @endif
                        @if($event->location)
                        <div class="info-row">
                            <div class="ico"><i class="bi bi-geo-alt"></i></div>
                            <div>
                                <div class="lbl">Location</div>
                                <div class="val">{{ $event->location }}</div>
                            </div>
                        </div>
                        @endif
                        @if($event->category)
                        <div class="info-row">
                            <div class="ico"><i class="bi bi-bookmark"></i></div>
                            <div>
                                <div class="lbl">Category</div>
                                <div class="val">{{ $event->category->name }}</div>
                            </div>
                        </div>
                        @endif
                        @if($event->event_date && $event->event_date->isFuture())
                            <a @spa href="{{ route('contact') }}" class="btn btn-teal"><i class="bi bi-bookmark-heart"></i> Register interest</a>
                        @endif
                        <a @spa href="{{ route('contact') }}" class="btn btn-outline-ink mt-2"><i class="bi bi-envelope"></i> Get in touch</a>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    @if($related->isNotEmpty())
    <section class="bg-cream">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
                <div>
                    <span class="eyebrow">More events</span>
                    <h2 class="mb-0">Other events</h2>
                </div>
                <a @spa href="{{ route('events') }}" class="btn btn-outline-ink">View all <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
            <div class="row g-4">
                @foreach($related as $item)
                <div class="col-md-6 col-lg-4">
                    <a class="activity-card d-block text-decoration-none" @spa href="{{ route('event.details', $item->slug) }}">
                        <div class="thumb-wrap">
                            @if($item->category)
                                <span class="cat-pill">{{ $item->category->name }}</span>
                            @endif
                            <div class="thumb" style="background-image:url('{{ $item->image && $item->image !== 'placeholder.webp' ? asset($item->image) : asset('placeholder.webp') }}')"></div>
                        </div>
                        <div class="body">
                            <div class="meta-row">
                                @if($item->event_date)
                                    <span><i class="bi bi-calendar3"></i>{{ $item->event_date->format('d M Y') }}</span>
                                @endif
                                @if($item->location)
                                    <span><i class="bi bi-geo-alt"></i>{{ Str::before($item->location, ',') }}</span>
                                @endif
                            </div>
                            <h3>{{ $item->title }}</h3>
                            <span class="more">View event <i class="bi bi-arrow-right"></i></span>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @include('frontend.cta')

@endsection
@extends('frontend.master')
@section('title', $activity->title)

@section('content')

    <header class="page-hero" style="--page-img:url('{{ $activity->image && $activity->image !== 'placeholder.webp' ? asset($activity->image) : asset('resources/frontend/img/banner.webp') }}')">
        <div class="container">
            <nav class="crumbs" aria-label="Breadcrumb">
                <a @spa href="{{ route('home') }}">Home</a><span class="sep">/</span>
                <a @spa href="{{ route('activities') }}">Activities</a><span class="sep">/</span>
                <span>{{ $activity->title }}</span>
            </nav>
            @if($activity->category)
                <span class="eyebrow light">{{ $activity->category->name }}</span>
            @endif
            <h1>{{ $activity->title }}</h1>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    @if($activity->image && $activity->image !== 'placeholder.webp')
                        <img src="{{ asset($activity->image) }}" alt="{{ $activity->title }}" class="detail-hero-img">
                    @endif

                    <div class="d-flex flex-wrap gap-3 mb-4">
                        @if($activity->category)
                            <span class="tag">{{ $activity->category->name }}</span>
                        @endif
                        @if($activity->event_date)
                            <span class="muted" style="font-size:.92rem">
                                <i class="bi bi-calendar3 me-1"></i>{{ $activity->event_date->format('d M Y') }}
                            </span>
                            <span class="muted" style="font-size:.92rem">
                                <i class="bi bi-clock me-1"></i>{{ $activity->event_date->format('h:i A') }}
                            </span>
                        @endif
                    </div>

                    <div class="prose">
                        @php
                            $body = preg_replace('/\s(width|height)=["\']?\d+(px)?["\']?/i', '', $activity->body);
                            $body = preg_replace('/width\s*:\s*\d+px;?/i', '', $body);
                        @endphp

                        {!! $body !!}
                    </div>
                </div>

                <div class="col-lg-4">
                    <aside class="detail-aside">
                        <h4>Event details</h4>
                        @if($activity->event_date)
                        <div class="info-row">
                            <div class="ico"><i class="bi bi-calendar3"></i></div>
                            <div>
                                <div class="lbl">Date</div>
                                <div class="val">{{ $activity->event_date->format('d M Y') }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="ico"><i class="bi bi-clock"></i></div>
                            <div>
                                <div class="lbl">Time</div>
                                <div class="val">{{ $activity->event_date->format('h:i A') }}</div>
                            </div>
                        </div>
                        @endif
                        @if($activity->location)
                        <div class="info-row">
                            <div class="ico"><i class="bi bi-geo-alt"></i></div>
                            <div>
                                <div class="lbl">Location</div>
                                <div class="val">{{ $activity->location }}</div>
                            </div>
                        </div>
                        @endif
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
                    <span class="eyebrow">More from us</span>
                    <h2 class="mb-0">Other activities</h2>
                </div>
                <a @spa href="{{ route('activities') }}" class="btn btn-outline-ink">View all <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
            <div class="row g-4">
                @foreach($related as $item)
                <div class="col-md-6 col-lg-4">
                    <a class="activity-card d-block text-decoration-none" @spa href="{{ route('activity.details', $item->slug) }}">
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
                            <span class="more">Read more <i class="bi bi-arrow-right"></i></span>
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
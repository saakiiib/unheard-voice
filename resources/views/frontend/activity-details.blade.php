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

                    <div class="activity-meta-bar d-flex flex-wrap gap-3 mb-4 p-3" style="background:var(--cream,#f8f6f2);border-radius:10px;">
                        @if($activity->category)
                            <span class="tag mb-0">{{ $activity->category->name }}</span>
                        @endif
                        @if($activity->activity_date)
                            <span class="muted d-flex align-items-center" style="font-size:.92rem">
                                <i class="bi bi-calendar3 me-1 text-teal"></i>{{ $activity->activity_date->format('d M Y') }}
                            </span>
                            <span class="muted d-flex align-items-center" style="font-size:.92rem">
                                <i class="bi bi-clock me-1 text-teal"></i>{{ $activity->activity_date->format('h:i A') }}
                            </span>
                        @endif
                        @if($activity->location)
                            <span class="muted d-flex align-items-center" style="font-size:.92rem">
                                <i class="bi bi-geo-alt me-1 text-teal"></i>{{ $activity->location }}
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
                        <h4>Activity details</h4>
                        @if($activity->category)
                        <div class="info-row">
                            <div class="ico"><i class="bi bi-bookmark"></i></div>
                            <div>
                                <div class="lbl">Category</div>
                                <div class="val">{{ $activity->category->name }}</div>
                            </div>
                        </div>
                        @endif
                        @if($activity->activity_date)
                        <div class="info-row">
                            <div class="ico"><i class="bi bi-calendar3"></i></div>
                            <div>
                                <div class="lbl">Date</div>
                                <div class="val">{{ $activity->activity_date->format('d M Y') }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="ico"><i class="bi bi-clock"></i></div>
                            <div>
                                <div class="lbl">Time</div>
                                <div class="val">{{ $activity->activity_date->format('h:i A') }}</div>
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
                        <a @spa href="{{ route('activities') }}" class="btn btn-outline-ink mt-2"><i class="bi bi-arrow-left"></i> View all activities</a>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    @if($activity->media->isNotEmpty())
    <section class="bg-cream-soft">
        <div class="container">
            <div class="text-center mb-5">
                <span class="eyebrow">Gallery</span>
                <h2>{{ $activity->title }}</h2>
                <hr class="divider mx-auto">
            </div>

            <div class="row g-4" id="gallery-grid">
                @foreach($activity->media as $item)
                    <div class="col-sm-6 col-md-4 col-lg-3 gallery-item">
                        <div class="gallery-card" data-type="{{ $item->type }}"
                            data-src="{{ $item->type === 'image' ? asset($item->file) : ($item->type === 'video' ? asset($item->file) : 'https://www.youtube.com/embed/' . $item->youtube_id . '?autoplay=1&rel=0') }}"
                            data-title="{{ $activity->title }}">

                            <div class="media-preview-wrap">
                                <div class="media-overlay">
                                    <div class="icon-indicator">
                                        @if($item->type === 'image')
                                            <i class="bi bi-zoom-in"></i>
                                        @else
                                            <i class="bi bi-play-circle-fill text-teal"></i>
                                        @endif
                                    </div>
                                </div>

                                @if($item->type === 'image')
                                    <div class="gallery-thumb" style="background-image: url('{{ asset($item->file) }}')"></div>
                                @elseif($item->type === 'video')
                                    <video class="gallery-thumb" preload="metadata" muted playsinline>
                                        <source src="{{ asset($item->file) }}#t=0.1">
                                    </video>
                                @else
                                    <div class="gallery-thumb" style="background-image: url('https://img.youtube.com/vi/{{ $item->youtube_id }}/hqdefault.jpg')"></div>
                                @endif
                            </div>

                            <div class="gallery-card-body">
                                <p class="media-type-lbl text-muted">
                                    <i class="bi {{ $item->type === 'image' ? 'bi-image' : 'bi-camera-video' }} me-1"></i>
                                    {{ ucfirst($item->type === 'image' ? 'photo' : 'video') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div id="custom-lightbox" class="lightbox-overlay" aria-hidden="true">
        <button class="lightbox-close" aria-label="Close lightbox"><i class="bi bi-x-lg"></i></button>
        <button class="lightbox-nav prev" aria-label="Previous item"><i class="bi bi-chevron-left"></i></button>
        <button class="lightbox-nav next" aria-label="Next item"><i class="bi bi-chevron-right"></i></button>

        <div class="lightbox-content-container">
            <div id="lightbox-media-box"></div>
            <div class="lightbox-caption">
                <h4 id="lightbox-title" class="serif text-white mb-1"></h4>
                <span id="lightbox-counter" class="text-teal font-monospace"></span>
            </div>
        </div>
    </div>
    @endif

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
                                @if($item->activity_date)
                                    <span><i class="bi bi-calendar3"></i>{{ $item->activity_date->format('d M Y') }}</span>
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

@section('script')
    <script>
        $(document).ready(function() {
            let cards = [];
            let currentIndex = 0;

            $(document).on('click', '.gallery-card', function() {
                cards = $('.gallery-item').map(function() {
                    return $(this).find('.gallery-card')[0];
                }).get();

                currentIndex = cards.indexOf(this);
                if (currentIndex === -1) return;

                $('#custom-lightbox').addClass('show');
                $('body').css('overflow', 'hidden');
                renderLightbox();
            });

            $(document).on('click', '.lightbox-nav.next', function(e) {
                e.stopPropagation();
                if (cards.length > 1) {
                    currentIndex = (currentIndex + 1) % cards.length;
                    renderLightbox();
                }
            });

            $(document).on('click', '.lightbox-nav.prev', function(e) {
                e.stopPropagation();
                if (cards.length > 1) {
                    currentIndex = (currentIndex - 1 + cards.length) % cards.length;
                    renderLightbox();
                }
            });

            $(document).on('click', '.lightbox-close, #custom-lightbox', function(e) {
                if (e.target.id === 'custom-lightbox' || $(this).hasClass('lightbox-close')) {
                    closeLightbox();
                }
            });

            $(document).on('keydown', function(e) {
                if (!$('#custom-lightbox').hasClass('show')) return;
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowRight') $('.lightbox-nav.next').click();
                if (e.key === 'ArrowLeft') $('.lightbox-nav.prev').click();
            });

            function renderLightbox() {
                destroyActiveVideo();
                let card = $(cards[currentIndex]);
                let type = card.data('type');
                let src = card.data('src');
                let title = card.data('title');
                let html = '';

                if (type === 'image') {
                    html = '<img src="' + src + '" alt="' + (title || '') + '">';
                } else if (type === 'video') {
                    html = '<div class="video-embed-container"><video src="' + src + '" controls playsinline muted autoplay style="width:100%;height:100%;"></video></div>';
                } else {
                    html = '<div class="video-embed-container"><iframe src="' + src + '" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>';
                }

                $('#lightbox-media-box').html(html);

                if (type === 'video') {
                    let vid = $('#lightbox-media-box video')[0];
                    if (vid) {
                        vid.load();
                        setTimeout(function() {
                            let playPromise = vid.play();
                            if (playPromise !== undefined) {
                                playPromise.catch(function(error) {
                                    console.log("Autoplay prevented:", error);
                                });
                            }
                        }, 50);
                    }
                }

                $('#lightbox-title').text(title || '');
                $('#lightbox-counter').text((currentIndex + 1) + ' / ' + cards.length);
            }

            function destroyActiveVideo() {
                let existingVid = $('#lightbox-media-box video')[0];
                if (existingVid) {
                    existingVid.pause();
                    existingVid.src = "";
                    existingVid.load();
                }
                $('#lightbox-media-box').html('');
            }

            function closeLightbox() {
                $('#custom-lightbox').removeClass('show');
                destroyActiveVideo();
                $('body').css('overflow', '');
            }
        });
    </script>
@endsection

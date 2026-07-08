@extends('frontend.master')
@section('title', 'Home')

@section('content')

    {{-- Slider --}}
    @if ($sliders && $sliders->isNotEmpty())
        <section class="hero" id="hero">
            <div class="hero-slides">
                @foreach ($sliders as $index => $slider)
                    <div class="hero-slide {{ $index === 0 ? 'active' : '' }}"
                        style="background-image: url('{{ asset($slider->image) }}')">
                    </div>
                @endforeach
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-lg-8 hero-content">

                        @foreach ($sliders as $index => $slider)
                            <div class="hero-slide-text" data-slide="{{ $index }}" {{ $index > 0 ? 'hidden' : '' }}>
                                @if ($slider->eyebrow_text)
                                    <span class="eyebrow light">{{ $slider->eyebrow_text }}</span>
                                @endif

                                <h1>{!! $slider->title !!}</h1>

                                @if ($slider->description)
                                    <p class="lead">{{ $slider->description }}</p>
                                @endif

                                <div class="d-flex gap-3 flex-wrap">
                                    @if ($slider->btn1_text)
                                        <a href="{{ $slider->btn1_url ?? '#' }}" class="btn btn-teal btn-lg">
                                            {{ $slider->btn1_text }}
                                        </a>
                                    @endif

                                    @if ($slider->btn2_text)
                                        <a href="{{ $slider->btn2_url ?? '#' }}" class="btn btn-outline-light btn-lg">
                                            {{ $slider->btn2_text }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="hero-stats d-none">
                            <div>
                                <div class="stat-num">2,500+</div>
                                <div class="stat-lbl">Voices Amplified</div>
                            </div>
                            <div>
                                <div class="stat-num">150+</div>
                                <div class="stat-lbl">Volunteers</div>
                            </div>
                            <div>
                                <div class="stat-num">50+</div>
                                <div class="stat-lbl">Events Held</div>
                            </div>
                            <div>
                                <div class="stat-num">10+</div>
                                <div class="stat-lbl">Years of Impact</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            @if ($sliders->count() > 1)
                <div class="hero-arrows">
                    <button class="prev" aria-label="Previous slide"><i class="bi bi-chevron-left"></i></button>
                    <button class="next" aria-label="Next slide"><i class="bi bi-chevron-right"></i></button>
                </div>

                <div class="hero-dots" role="tablist">
                    @foreach ($sliders as $index => $slider)
                        <button class="{{ $index === 0 ? 'active' : '' }}"
                            aria-label="Slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
            @endif
        </section>
    @endif

    {{-- Our Purpose --}}
    <section>
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="eyebrow">Our Purpose</span>
                    <h2>Together for Better Mental Health</h2>
                    <hr class="divider">
                    <p class="lead">Too many people suffer in silence because of stigma, language barriers, or cultural
                        differences. At Unheard Voices, we’re here to change that.</p>
                    <p class="muted">We create safe spaces where mental health can be spoken about openly, compassionately,
                        and without judgment. Through workshops, peer support, and community connections, we’re building
                        stronger, healthier, and more resilient communities.</p>
                    <a @spa href="{{ route('about') }}" class="btn btn-outline-ink mt-3">Learn More About Us <i
                            class="bi bi-arrow-right ms-1"></i></a>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('resources/frontend/img/our-purpose.webp') }}"
                        alt="Together for Better Mental Health" class="story-img">
                </div>
            </div>
        </div>
    </section>

    {{-- Upcoming Events --}}
    @if ($events && $events->isNotEmpty())
        <section class="bg-cream">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-3">
                    <div>
                        <span class="eyebrow">What's On</span>
                        <h2 class="mb-0">Upcoming Events</h2>
                    </div>
                    <a @spa href="{{ route('events') }}" class="btn btn-outline-ink">
                        View All Events <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="row g-4">
                    @foreach ($events as $event)
                        <div class="col-md-6 col-lg-4">
                            <a @spa class="activity-card d-block text-decoration-none"
                                href="{{ route('event.details', $event->slug) }}">
                                <div class="thumb-wrap">
                                    @if ($event->category)
                                        <span class="cat-pill">{{ $event->category->name }}</span>
                                    @endif
                                    <div class="thumb"
                                        style="background-image:url('{{ $event->image && $event->image !== 'placeholder.webp' ? asset($event->image) : asset('placeholder.webp') }}')">
                                    </div>
                                </div>
                                <div class="body">
                                    <div class="meta-row">
                                        @if ($event->event_date)
                                            <span><i
                                                    class="bi bi-calendar3"></i>{{ $event->event_date->format('d M Y') }}</span>
                                        @endif
                                        @if ($event->location)
                                            <span><i
                                                    class="bi bi-geo-alt"></i>{{ Str::before($event->location, ',') }}</span>
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
    @endif

    {{-- Our Impact --}}
    <section class="bg-cream d-none">
        <div class="container text-center">
            <span class="eyebrow">Our Impact</span>
            <h2>Real Change, Real Numbers</h2>
            <hr class="divider mx-auto">
            <p class="lead muted" style="max-width:640px;margin:0 auto">A decade of community-led work — measured not just
                in numbers, but in lives reshaped by support, dignity and connection.</p>
            <div class="impact">
                <div class="stat">
                    <div class="ico"><i class="bi bi-people-fill"></i></div>
                    <div class="num">2,500<span class="plus">+</span></div>
                    <div class="lbl">People Supported</div>
                    <div class="sub">Individuals and families reached through our programs</div>
                </div>
                <div class="stat">
                    <div class="ico"><i class="bi bi-hand-thumbs-up-fill"></i></div>
                    <div class="num">150<span class="plus">+</span></div>
                    <div class="lbl">Volunteers Engaged</div>
                    <div class="sub">Dedicated community members giving their time</div>
                </div>
                <div class="stat">
                    <div class="ico"><i class="bi bi-calendar-event-fill"></i></div>
                    <div class="num">50<span class="plus">+</span></div>
                    <div class="lbl">Community Events</div>
                    <div class="sub">Workshops, meetups, and awareness campaigns</div>
                </div>
                <div class="stat">
                    <div class="ico"><i class="bi bi-piggy-bank-fill"></i></div>
                    <div class="num">£120K<span class="plus">+</span></div>
                    <div class="lbl">Funds Raised</div>
                    <div class="sub">Invested directly into community mental health</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Our Approach --}}
    <section class="bg-cream">
        <div class="container">
            <div class="text-center mb-5"><span class="eyebrow">Our Approach</span>
                <h2>How We Create Change</h2>
                <hr class="divider mx-auto">
                <p class="lead muted">Through five core pillars, we build a comprehensive support system that addresses
                    mental health from every angle.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card-soft"><span class="icon-circle"><i class="bi bi-chat-quote"></i></span>
                        <h3>Breaking Stigma</h3>
                        <p>Opening honest conversations about mental health in trusted, culturally safe spaces.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-soft"><span class="icon-circle"><i class="bi bi-globe-asia-australia"></i></span>
                        <h3>Culturally Sensitive Support</h3>
                        <p>Care shaped by lived experience and deep cultural awareness for diverse communities.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-soft"><span class="icon-circle"><i class="bi bi-people"></i></span>
                        <h3>Community Empowerment</h3>
                        <p>Building peer networks that help people support each other through shared experience.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-soft"><span class="icon-circle"><i class="bi bi-compass"></i></span>
                        <h3>Accessible Guidance</h3>
                        <p>Making mental health support simple, clear, and approachable for everyone.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-soft"><span class="icon-circle"><i class="bi bi-heart-pulse"></i></span>
                        <h3>Holistic Wellbeing</h3>
                        <p>Promoting emotional, physical, and social health together for complete wellness.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-soft d-flex flex-column justify-content-center align-items-start"
                        style="background:var(--dark);color:#fff;border-color:var(--dark)">
                        <h3 style="color:#fff">Ready to explore?</h3>
                        <p style="color:rgba(255,255,255,.7)">We have a wide range of programs to help you.</p>
                        <a @spa href="{{ route('activities') }}" class="btn btn-teal mt-2">Explore Activities</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Why It Matters --}}
    <section>
        <div class="container">
            <div class="text-center mb-5"><span class="eyebrow">Why It Matters</span>
                <h2>Behind Every Statistic, a Person</h2>
                <hr class="divider mx-auto">
                <p class="lead muted">Behind every statistic is a person—a parent, child, or neighbour—navigating cultural
                    and systemic barriers in silence. For many ethnically diverse communities in the UK, mental health
                    remains heavily stigmatised.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card-soft"><span class="icon-circle"><i class="bi bi-mic-mute"></i></span>
                        <h3>Silenced by Stigma</h3>
                        <p>Mental health is often seen as shameful or taboo in many communities, discouraging people from
                            speaking out or seeking help.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card-soft"><span class="icon-circle"><i class="bi bi-shield-exclamation"></i></span>
                        <h3>Unequal Access to Care</h3>
                        <p>People from diverse backgrounds are 3.5× more likely to reach support through crisis than early
                            prevention.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card-soft"><span class="icon-circle"><i class="bi bi-graph-up-arrow"></i></span>
                        <h3>Higher Illness Risk</h3>
                        <p>Some groups are 3 to 7 times more likely to experience serious mental health conditions.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card-soft"><span class="icon-circle"><i class="bi bi-translate"></i></span>
                        <h3>Language Barriers</h3>
                        <p>Limited awareness and lack of culturally sensitive care make it harder to get help early.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Activities --}}
    @if ($activities && $activities->isNotEmpty())
        <section class="bg-cream">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-3">
                    <div>
                        <span class="eyebrow">Our Activities</span>
                        <h2 class="mb-0">Latest from the Community</h2>
                    </div>
                    <a @spa href="{{ route('activities') }}" class="btn btn-outline-ink">
                        View All Activities <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="row g-4" id="latest-activities">
                    @foreach ($activities as $activity)
                        <div class="col-md-6 col-lg-4">
                            <a class="activity-card d-block text-decoration-none" @spa
                                href="{{ route('activity.details', $activity->slug) }}">

                                <div class="thumb-wrap">
                                    @if ($activity->category)
                                        <span class="cat-pill">{{ $activity->category->name }}</span>
                                    @endif

                                    <div class="thumb"
                                        style="background-image:url('{{ $activity->image && $activity->image !== 'placeholder.webp'
                                            ? asset($activity->image)
                                            : asset('placeholder.webp') }}')">
                                    </div>
                                </div>

                                <div class="body">
                                    <div class="meta-row">
                                        @if ($activity->event_date)
                                            <span>
                                                <i class="bi bi-calendar3"></i>
                                                {{ $activity->event_date->format('d M Y') }}
                                            </span>
                                        @endif

                                        @if ($activity->location)
                                            <span>
                                                <i class="bi bi-geo-alt"></i>
                                                {{ Str::before($activity->location, ',') }}
                                            </span>
                                        @endif
                                    </div>

                                    <h3>{{ $activity->title }}</h3>

                                    <span class="more">
                                        Read more <i class="bi bi-arrow-right"></i>
                                    </span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Testimonials --}}
    @if ($testimonials && $testimonials->isNotEmpty())
        <section class="bg-cream">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="eyebrow">Testimonials</span>
                    <h2>Voices From Our Community</h2>
                    <hr class="divider mx-auto">
                </div>

                <div class="row g-4">
                    @foreach ($testimonials as $testimonial)
                        <div class="col-md-4">
                            <div class="quote-card">

                                <p class="q">"{{ $testimonial->review }}"</p>

                                <hr class="my-3" style="border-top: 2px solid rgba(0,0,0,0.3);">

                                <div class="who">

                                    <div>
                                        <div class="nm">{{ $testimonial->name }}</div>
                                        <div class="rl">{{ $testimonial->designation ?? 'Programme Participant' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($galleries && $galleries->isNotEmpty())
        <section class="bg-cream-soft">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="eyebrow">Our Gallery</span>
                    <h2>Moments Worth Sharing</h2>
                    <hr class="divider mx-auto">
                </div>

                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <div class="gallery-filters d-flex flex-wrap justify-content-center gap-2">
                            <button class="filter-btn active" data-filter="all">All Media</button>
                            @foreach ($galleries as $g)
                                @if ($g->media->count() > 0)
                                    <button class="filter-btn"
                                        data-filter="album-{{ $g->id }}">{{ $g->title }}</button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row g-4" id="gallery-grid">
                    @php $hasMedia = false; @endphp

                    @foreach ($galleries as $gallery)
                        @foreach ($gallery->media as $item)
                            @php $hasMedia = true; @endphp
                            <div class="col-sm-6 col-md-4 col-lg-3 gallery-item" data-album="album-{{ $gallery->id }}">
                                <div class="gallery-card" data-type="{{ $item->type }}"
                                    data-src="{{ $item->type === 'image' ? asset($item->file) : ($item->type === 'video' ? asset($item->file) : 'https://www.youtube.com/embed/' . $item->youtube_id . '?autoplay=1&rel=0') }}"
                                    data-title="{{ $gallery->title }}">

                                    <div class="media-preview-wrap">
                                        <div class="media-overlay">
                                            <div class="icon-indicator">
                                                @if ($item->type === 'image')
                                                    <i class="bi bi-zoom-in"></i>
                                                @else
                                                    <i class="bi bi-play-circle-fill text-teal"></i>
                                                @endif
                                            </div>
                                        </div>

                                        @if ($item->type === 'image')
                                            <div class="gallery-thumb"
                                                style="background-image: url('{{ asset($item->file) }}')"></div>
                                        @elseif ($item->type === 'video')
                                            <video class="gallery-thumb" preload="metadata" muted playsinline>
                                                <source src="{{ asset($item->file) }}#t=0.1">
                                            </video>
                                        @else
                                            <div class="gallery-thumb"
                                                style="background-image: url('https://img.youtube.com/vi/{{ $item->youtube_id }}/hqdefault.jpg')">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="gallery-card-body">
                                        <span class="album-tag">{{ $gallery->title }}</span>
                                        <p class="media-type-lbl text-muted">
                                            <i
                                                class="bi {{ $item->type === 'image' ? 'bi-image' : 'bi-camera-video' }} me-1"></i>
                                            {{ ucfirst($item->type === 'image' ? 'photo' : 'video') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach

                    @if (!$hasMedia)
                        <div class="col-12 text-center py-5">
                            <div class="icon-circle mb-3"><i class="bi bi-images fs-2"></i></div>
                            <h3 class="serif text-muted">No media items found</h3>
                        </div>
                    @endif
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

    {{-- CTA --}}
    @include('frontend.cta')

@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.filter-btn', function() {
                $('.filter-btn').removeClass('active');
                $(this).addClass('active');

                let selector = $(this).data('filter');

                $('.gallery-item').each(function() {
                    if (selector === 'all') {
                        $(this).show();
                    } else {
                        $(this).toggle($(this).data('album') === selector);
                    }
                });
            });

            let cards = [];
            let currentIndex = 0;

            $(document).on('click', '.gallery-card', function() {
                let visibleItems = $('.gallery-item:visible');

                cards = visibleItems.map(function() {
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
                    html = `<img src="${src}" alt="${title || ''}">`;
                } else if (type === 'video') {
                    html = `
                        <div class="video-embed-container">
                            <video src="${src}" controls playsinline muted autoplay style="width:100%;height:100%;"></video>
                        </div>`;
                } else {
                    html = `
                        <div class="video-embed-container">
                            <iframe src="${src}" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        </div>`;
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
                                    console.log("Autoplay prevented or interrupted:", error);
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
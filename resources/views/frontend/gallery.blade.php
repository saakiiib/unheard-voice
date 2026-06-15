@extends('frontend.master')
@section('title', 'Gallery')

@section('content')

    <header class="page-hero" style="--page-img:url('{{ asset('resources/frontend/img/banner.webp') }}')">
        <div class="container">
            <nav class="crumbs" aria-label="Breadcrumb">
                <a @spa href="{{ route('home') }}">Home</a><span class="sep">/</span><span>Gallery</span>
            </nav>
            <span class="eyebrow light">Gallery</span>
            <h1>Visual Stories and Highlights</h1>
        </div>
    </header>

    <section class="bg-cream-soft">
        <div class="container">
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
                                data-src="{{ $item->type === 'image' ? asset($item->file) : 'https://www.youtube.com/embed/' . $item->youtube_id . '?autoplay=1&rel=0' }}"
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

                let card = $(cards[currentIndex]);

                let type = card.data('type');
                let src = card.data('src');
                let title = card.data('title');

                let html = '';

                if (type === 'image') {
                    html = `<img src="${src}" alt="${title || ''}">`;
                } else {
                    html = `
                <div class="video-embed-container">
                    <iframe src="${src}" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>`;
                }

                $('#lightbox-media-box').html(html);
                $('#lightbox-title').text(title || '');
                $('#lightbox-counter').text((currentIndex + 1) + ' / ' + cards.length);
            }

            function closeLightbox() {
                $('#custom-lightbox').removeClass('show');
                $('#lightbox-media-box').html('');
                $('body').css('overflow', '');
            }

        });
    </script>
@endsection

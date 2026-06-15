@extends('frontend.master')
@section('title', $blog->title)

@section('content')

    <header class="page-hero"
        style="--page-img:url('{{ $blog->image && $blog->image !== 'placeholder.webp' ? asset($blog->image) : asset('resources/frontend/img/banner.webp') }}')">
        <div class="container">
            <nav class="crumbs" aria-label="Breadcrumb">
                <a @spa href="{{ route('home') }}">Home</a><span class="sep">/</span>
                <a @spa href="{{ route('blogs') }}">Blog</a><span class="sep">/</span>
                <span>{{ $blog->title }}</span>
            </nav>
            @if ($blog->category)
                <span class="eyebrow light">{{ $blog->category->name }}</span>
            @endif
            <h1>{{ $blog->title }}</h1>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    @if ($blog->image && $blog->image !== 'placeholder.webp')
                        <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="detail-hero-img">
                    @endif

                    <div class="d-flex flex-wrap gap-3 mb-4 align-items-center">
                        @if ($blog->category)
                            <span class="tag">{{ $blog->category->name }}</span>
                        @endif
                        <span class="muted" style="font-size:.92rem">
                            <i class="bi bi-calendar3 me-1"></i>{{ $blog->created_at->format('d M Y') }}
                        </span>
                        @if ($blog->read_time)
                            <span class="muted" style="font-size:.92rem">
                                <i class="bi bi-clock me-1"></i>{{ $blog->read_time }}
                            </span>
                        @endif
                        @if ($blog->author_name)
                            <span class="muted" style="font-size:.92rem">
                                <i class="bi bi-person me-1"></i>{{ $blog->author_name }}
                            </span>
                        @endif
                    </div>

                    <div class="prose">
                        {!! $blog->body !!}
                    </div>
                </div>

                <div class="col-lg-4">
                    <aside class="detail-aside">
                        <h4>About this article</h4>
                        @if ($blog->author_name)
                            <div class="info-row">
                                <div class="ico"><i class="bi bi-person"></i></div>
                                <div>
                                    <div class="lbl">Author</div>
                                    <div class="val">{{ $blog->author_name }}</div>
                                </div>
                            </div>
                        @endif
                        <div class="info-row">
                            <div class="ico"><i class="bi bi-calendar3"></i></div>
                            <div>
                                <div class="lbl">Published</div>
                                <div class="val">{{ $blog->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                        @if ($blog->read_time)
                            <div class="info-row">
                                <div class="ico"><i class="bi bi-clock"></i></div>
                                <div>
                                    <div class="lbl">Reading time</div>
                                    <div class="val">{{ $blog->read_time }}</div>
                                </div>
                            </div>
                        @endif
                        @if ($blog->category)
                            <div class="info-row">
                                <div class="ico"><i class="bi bi-bookmark"></i></div>
                                <div>
                                    <div class="lbl">Category</div>
                                    <div class="val">{{ $blog->category->name }}</div>
                                </div>
                            </div>
                        @endif
                        <a @spa href="{{ route('contact') }}" class="btn btn-teal"><i class="bi bi-envelope"></i> Get in
                            touch</a>
                        <a @spa href="{{ route('donate') }}" class="btn btn-outline-ink mt-2"><i class="bi bi-heart"></i>
                            Support our work</a>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    @if ($related->isNotEmpty())
        <section class="bg-cream">
            <div class="container">
                <div class="d-flex justify-content-between align-items-end mb-4 flex-wrap gap-2">
                    <div>
                        <span class="eyebrow">Keep reading</span>
                        <h2 class="mb-0">More from the blog</h2>
                    </div>
                    <a @spa href="{{ route('blogs') }}" class="btn btn-outline-ink">All articles <i
                            class="bi bi-arrow-right ms-1"></i></a>
                </div>
                <div class="row g-4">
                    @foreach ($related as $item)
                        <div class="col-md-6 col-lg-4">
                            <a class="activity-card d-block text-decoration-none" @spa
                                href="{{ route('blog.details', $item->slug) }}">
                                <div class="thumb-wrap">
                                    @if ($item->category)
                                        <span class="cat-pill">{{ $item->category->name }}</span>
                                    @endif
                                    <div class="thumb"
                                        style="background-image:url('{{ $item->image && $item->image !== 'placeholder.webp' ? asset($item->image) : asset('placeholder.webp') }}')">
                                    </div>
                                </div>
                                <div class="body">
                                    <div class="meta-row">
                                        <span><i
                                                class="bi bi-calendar3"></i>{{ $item->created_at->format('d M Y') }}</span>
                                        @if ($item->read_time)
                                            <span><i class="bi bi-clock"></i>{{ $item->read_time }}</span>
                                        @endif
                                    </div>
                                    <h3>{{ $item->title }}</h3>
                                    <span class="more">Read article <i class="bi bi-arrow-right"></i></span>
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
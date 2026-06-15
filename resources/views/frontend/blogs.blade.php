@extends('frontend.master')
@section('title', 'Blog')

@section('content')

    <header class="page-hero" style="--page-img:url('{{ asset('resources/frontend/img/banner.webp') }}')">
        <div class="container">
            <nav class="crumbs" aria-label="Breadcrumb">
                <a @spa href="{{ route('home') }}">Home</a><span class="sep">/</span><span>Blog</span>
            </nav>
            <span class="eyebrow light">Our Blog</span>
            <h1>Voices, ideas & reflections.</h1>
            <p class="lead mt-3">Honest writing from our team, volunteers and community on mental health, culture and care
                &mdash; the things we talk about most often, in our own words.</p>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="row g-4">
                @foreach($blogs as $blog)
                    <div class="col-md-6 col-lg-4">
                        <a class="activity-card d-block text-decoration-none" @spa
                            href="{{ route('blog.details', $blog->slug) }}">
                            <div class="thumb-wrap">
                                @if ($blog->category)
                                    <span class="cat-pill">{{ $blog->category->name }}</span>
                                @endif
                                <div class="thumb"
                                    style="background-image:url('{{ $blog->image && $blog->image !== 'placeholder.webp' ? asset($blog->image) : asset('placeholder.webp') }}')">
                                </div>
                            </div>
                            <div class="body">
                                <div class="meta-row">
                                    <span><i class="bi bi-calendar3"></i>{{ $blog->created_at->format('d M Y') }}</span>
                                    @if ($blog->read_time)
                                        <span><i class="bi bi-clock"></i>{{ $blog->read_time }}</span>
                                    @endif
                                </div>
                                <h3>{{ $blog->title }}</h3>
                                <span class="more">Read article <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('frontend.cta')

@endsection
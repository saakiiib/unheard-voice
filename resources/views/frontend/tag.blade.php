@extends('frontend.master')

@section('title', $tag->name)

@section('content')

<section class="pb-cat-hero">
    <div class="container-pb">
        <h1 class="my-1">বিষয়: “{{ $tag->name }}”</h1>
        <div class="sub">
            @if($articles->count() > 0)
                খোঁজা হয়েছে এবং সর্বোচ্চ {{ $articles->count() }}টি ফলাফল পাওয়া গেছে
            @else
                কোনো ফলাফল পাওয়া যায়নি
            @endif
        </div>
    </div>
</section>

<section class="pb-section">
    <div class="container-pb">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="row g-4" id="articles-wrapper">
                    @forelse($articles as $article)
                        <div class="col-md-6 col-xl-4">
                            <article class="pb-card">
                                <a @spa class="pb-thumb pb-ar-16x9" href="{{ route('article.show', $article->slug) }}">
                                    <img src="{{ $article->featured_image ? asset($article->featured_image) : asset('placeholder.webp') }}" alt="{{ $article->title }}" loading="lazy">
                                    @if($article->category)
                                        <span class="pb-cat">{{ $article->category->name }}</span>
                                    @endif
                                </a>
                                <h3 class="pb-title">
                                    <a @spa href="{{ route('article.show', $article->slug) }}">{{ $article->title }}</a>
                                </h3>
                                <div class="pb-meta">
                                    @if($article->category)
                                        <span class="pb-cat-text">{{ $article->category->name }}</span> · 
                                    @endif
                                    <span>{{ $article->published_at ? $article->published_at->diffForHumans() : '' }}</span>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <div class="mb-3 text-muted" style="font-size: 3rem;"><i class="bi bi-newspaper"></i></div>
                            <p class="text-muted">দুঃখিত, এই বিষয়ের অধীনে এই মুহূর্তে কোনো খবর পাওয়া যায়নি।</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <aside class="col-lg-4">
                <div class="pb-widget">
                    <div class="pb-widget-head"><h3>সর্বাধিক পঠিত</h3></div>
                    <div class="pb-popular">
                        @forelse($mostReadArticles as $mostRead)
                            <div class="pb-pop-item">
                                <div>
                                    <a @spa class="pb-title" href="{{ route('article.show', $mostRead->slug) }}">
                                        {{ $mostRead->title }}
                                    </a>
                                    <div class="pb-meta">{{ $mostRead->published_at ? $mostRead->published_at->diffForHumans() : '' }}</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted p-3 mb-0">কোনো তথ্য নেই</p>
                        @endforelse
                    </div>
                </div>

                <div style="padding:0;">
                    {!! renderAd('sidebar_top') !!}
                </div>

                @if ($popularTags->count())
                    <div class="pb-widget">
                        <div class="pb-widget-head"><h3>আলোচিত বিষয়</h3></div>
                        <div class="pb-pills">
                            @foreach ($popularTags as $pTag)
                                <a @spa href="{{ route('tag.show', $pTag->slug) }}" class="{{ $pTag->id == $tag->id ? 'active' : '' }}">{{ $pTag->name }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <div style="padding:0;">
                   {!! renderAd('sidebar_bottom') !!}
                </div>
            </aside>

        </div>
    </div>
</section>

@endsection
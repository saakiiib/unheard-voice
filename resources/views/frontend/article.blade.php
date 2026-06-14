@extends('frontend.master')
@section('title', $article->title?? '')

@section('content')

<section class="pb-section">
    <div class="container-pb">
        <div class="row g-4">
            
            <div class="col-lg-8">
                <header class="pb-article-head">
                    <div class="pb-crumb">
                        <a @spa href="{{ url('/') }}">হোম</a> › 
                        @if($article->category)
                            <a @spa href="{{ url('category/'.$article->category->slug) }}">{{ $article->category->name }}</a>
                        @endif
                    </div>
                    
                    @if($article->category)
                        <span class="pb-cat-tag">{{ $article->category->name }}</span>
                    @endif
                    
                    <h1>{{ $article->title }}</h1>
                    
                    <div class="pb-article-meta">
                        <span><i class="bi bi-person-circle"></i> {{ $article->author ?: 'নিজস্ব প্রতিবেদক' }}</span>
                        <span><i class="bi bi-clock"></i> প্রকাশ: {{ $article->published_at ? $article->published_at->format('d M Y, h:i A') : '' }}</span>
                        <span><i class="bi bi-eye"></i> {{ number_format($article->view_count) }} বার পঠিত</span>
                        
                        <span class="pb-article-share ms-auto">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank"><i class="bi bi-facebook"></i></a>
                            <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ urlencode($article->title) }}" target="_blank"><i class="bi bi-twitter-x"></i></a>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . url()->current()) }}" target="_blank"><i class="bi bi-whatsapp"></i></a>
                            <a href="javascript:void(0);" onclick="navigator.clipboard.writeText('{{ url()->current() }}'); alert('লিঙ্ক কপি হয়েছে!');"><i class="bi bi-link-45deg"></i></a>
                        </span>
                    </div>
                </header>

                @php
                    $imgSrc = $article->sources->firstWhere('type', 'image');
                    $artSrc = $article->sources->firstWhere('type', 'article');

                    $embedUrl = null;
                    $isYoutube = false;
                    if ($article->is_video && $article->video_url) {
                        if (preg_match('/[?&]v=([^&]+)/', $article->video_url, $m)) {
                            $embedUrl = 'https://www.youtube.com/embed/' . $m[1];
                            $isYoutube = true;
                        } elseif (preg_match('/youtu\.be\/([^?&]+)/', $article->video_url, $m)) {
                            $embedUrl = 'https://www.youtube.com/embed/' . $m[1];
                            $isYoutube = true;
                        } elseif (preg_match('/youtube\.com\/embed\/([^?&]+)/', $article->video_url, $m)) {
                            $embedUrl = $article->video_url;
                            $isYoutube = true;
                        }
                    }
                @endphp

                @if($article->is_video && $article->video_url)
                    @if($isYoutube && $embedUrl)
                        <div class="pb-video-wrap" style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:6px;">
                            <iframe src="{{ $embedUrl }}"
                                style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;"
                                allowfullscreen loading="lazy"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                            </iframe>
                        </div>
                    @else
                        <video controls style="width:100%;border-radius:6px;">
                            <source src="{{ $article->video_url }}">
                        </video>
                    @endif
                @else
                    <figure>
                        <img src="{{ $article->featured_image ? asset($article->featured_image) : asset('placeholder.webp') }}"
                             alt="{{ $article->title }}" style="width:100%;border-radius:6px;object-fit:cover;">
                        @if($imgSrc)
                            <div class="pb-figcap">
                                @if($imgSrc->url)
                                    <a href="{{ $imgSrc->url }}" target="_blank" rel="noopener">{{ $imgSrc->title ?: $imgSrc->url }}</a>
                                @else
                                    {{ $imgSrc->title }}
                                @endif
                            </div>
                        @endif
                    </figure>
                @endif

                <div class="pb-article-body">
                    {!! $article->body !!}
                </div>

                @if($artSrc)
                    <div class="pb-article-source">
                        <i class="bi bi-link-45deg"></i> সূত্র:
                        @if($artSrc->url)
                            <a href="{{ $artSrc->url }}" target="_blank" rel="noopener">{{ $artSrc->title ?: $artSrc->url }}</a>
                        @else
                            {{ $artSrc->title }}
                        @endif
                    </div>
                @endif

                @if($article->tags && $article->tags->count() > 0)
                    <div class="pb-tag-chips">
                        @foreach($article->tags as $tag)
                            <a @spa href="{{ url('tag/'.$tag->slug) }}">#{{ $tag->name }}</a>
                        @endforeach
                    </div>
                @endif

                <div class="pb-section-head mt-4">
                    <h2>{{ $article->is_video ? 'সম্পর্কিত ভিডিও' : 'সম্পর্কিত খবর' }}</h2>
                </div>
                <div class="row g-4">
                    @forelse($relatedArticles as $related)
                        @php
                            $relThumb = $related->featured_image ? asset($related->featured_image) : asset('placeholder.webp');
                            if (!$related->featured_image && $related->is_video && $related->video_url) {
                                $ytId = null;
                                if (preg_match('/[?&]v=([^&]+)/', $related->video_url, $m)) $ytId = $m[1];
                                elseif (preg_match('/youtu\.be\/([^?&]+)/', $related->video_url, $m)) $ytId = $m[1];
                                elseif (preg_match('/youtube\.com\/embed\/([^?&]+)/', $related->video_url, $m)) $ytId = $m[1];
                                if ($ytId) $relThumb = 'https://img.youtube.com/vi/' . $ytId . '/hqdefault.jpg';
                            }
                        @endphp
                        <div class="col-md-4">
                            <article class="pb-card">
                                <a @spa class="pb-thumb pb-ar-16x9" href="{{ route('article.show', $related->slug) }}">
                                    <img src="{{ $relThumb }}" alt="{{ $related->title }}">
                                    @if($related->is_video)
                                        <span class="pb-play-icon"><i class="bi bi-play-circle-fill"></i></span>
                                    @endif
                                    @if($related->category)
                                        <span class="pb-cat">{{ $related->category->name }}</span>
                                    @endif
                                </a>
                                <h3 class="pb-title">
                                    <a @spa href="{{ route('article.show', $related->slug) }}">{{ $related->title }}</a>
                                </h3>
                                <div class="pb-meta">
                                    @if($related->category)
                                        <span class="pb-cat-text">{{ $related->category->name }}</span> · 
                                    @endif
                                    <span>{{ $related->published_at ? $related->published_at->diffForHumans() : '' }}</span>
                                </div>
                            </article>
                        </div>
                    @empty
                        <p class="text-muted ps-3">কোনো {{ $article->is_video ? 'সম্পর্কিত ভিডিও' : 'সম্পর্কিত খবর' }} পাওয়া যায়নি।</p>
                    @endforelse
                </div>
            </div>
            
            <aside class="col-lg-4">
                <div class="pb-widget">
                    <div class="pb-widget-head"><h3>{{ $article->is_video ? 'সর্বাধিক দেখা' : 'সর্বাধিক পঠিত' }}</h3></div>
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
                            @foreach ($popularTags as $tag)
                                <a @spa href="{{ route('tag.show', $tag->slug) }}">{{ $tag->name }}</a>
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
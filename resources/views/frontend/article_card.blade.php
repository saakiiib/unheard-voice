@php
    $thumbnail = $article->featured_image ? asset($article->featured_image) : asset('placeholder.webp');

    if (!$article->featured_image && $article->is_video && $article->video_url) {
        $ytId = null;
        if (preg_match('/[?&]v=([^&]+)/', $article->video_url, $m)) {
            $ytId = $m[1];
        } elseif (preg_match('/youtu\.be\/([^?&]+)/', $article->video_url, $m)) {
            $ytId = $m[1];
        } elseif (preg_match('/youtube\.com\/embed\/([^?&]+)/', $article->video_url, $m)) {
            $ytId = $m[1];
        }
        if ($ytId) {
            $thumbnail = 'https://img.youtube.com/vi/' . $ytId . '/hqdefault.jpg';
        }
    }
@endphp

<div class="col-md-6 col-lg-4 article-item">
    <article class="pb-card">
        <a @spa class="pb-thumb pb-ar-16x9" href="{{ route('article.show', $article->slug) }}">
            <img src="{{ $thumbnail }}" alt="{{ $article->title }}">
            @if($article->is_video)
                <span class="pb-play-icon"><i class="bi bi-play-circle-fill"></i></span>
            @endif
            <span class="pb-cat">{{ $article->category?->name }}</span>
        </a>
        <h3 class="pb-title">
            <a @spa href="{{ route('article.show', $article->slug) }}">{{ $article->title }}</a>
        </h3>
        <div class="pb-meta">
            @if($article->is_video)
                <span class="pb-video-badge"><i class="bi bi-camera-video-fill me-1"></i>ভিডিও</span> · 
            @endif
            <span class="pb-cat-text">{{ $article->category?->name }}</span> · 
            <span>{{ $article->published_at ? $article->published_at->diffForHumans() : '' }}</span>
        </div>
    </article>
</div>
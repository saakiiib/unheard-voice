@php
    $article = $article ?? $item;
@endphp

<article class="pb-card-h">
    <a @spa class="pb-thumb pb-ar-4x3" href="{{ route('article.show', $article->slug) }}">
        <img src="{{ Str::startsWith($article->featured_image, 'http') ? $article->featured_image : asset($article->featured_image) }}"
            alt="{{ $article->title }}" loading="lazy">
    </a>
    <div>
        <h4 class="pb-title">
            <a @spa href="{{ route('article.show', $article->slug) }}">{{ $article->title }}</a>
        </h4>
        <div class="pb-meta">
            @if(isset($showViewCount) && $showViewCount)
                <i class="bi bi-eye"></i> {{ number_format($article->view_count) }}
            @else
                <i class="bi bi-clock"></i> {{ $article->published_at->diffForHumans() }}
            @endif
        </div>
    </div>
</article>
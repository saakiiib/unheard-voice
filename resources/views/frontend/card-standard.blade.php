@php
    // যদি বাইরে থেকে ভেরিয়েবল 'article' নামে পাস করা হয়, তা না হলে ডিফল্ট '$item' ধরবে
    $article = $article ?? $item;
    $showMeta = $showMeta ?? true;
@endphp

<article class="pb-card">
    <a @spa class="pb-thumb pb-ar-16x9" href="{{ route('article.show', $article->slug) }}">
        <img src="{{ Str::startsWith($article->featured_image, 'http') ? $article->featured_image : asset($article->featured_image) }}"
            alt="{{ $article->title }}" loading="lazy">
        @if (isset($showCategory) && $showCategory && $article->category)
            <span class="pb-cat">{{ $article->category->name }}</span>
        @endif
    </a>
    <h3 class="pb-title">
        <a @spa href="{{ route('article.show', $article->slug) }}">{{ $article->title }}</a>
    </h3>
    @if($showMeta)
        <div class="pb-meta">
            @if (isset($showCategoryText) && $showCategoryText && $article->category)
                <span class="pb-cat-text">{{ $article->category->name }}</span> ·
            @endif
            {{ $article->published_at->diffForHumans() }}
        </div>
    @endif
</article>
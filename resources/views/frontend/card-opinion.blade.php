<article class="pb-card">
    <a @spa class="pb-thumb pb-ar-1x1" href="{{ route('article.show', $item->slug) }}">
        <img src="{{ Str::startsWith($item->featured_image, 'http') ? $item->featured_image : asset($item->featured_image) }}"
            alt="{{ $item->title }}" loading="lazy">
    </a>
    <h3 class="pb-title">
        <a @spa href="{{ route('article.show', $item->slug) }}">{{ $item->title }}</a>
    </h3>
    <div class="pb-meta">
        {{ $item->author }}
        @if ($item->category)
            · {{ $item->category->name }}
        @endif
    </div>
</article>
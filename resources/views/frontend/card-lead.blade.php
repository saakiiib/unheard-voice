<article class="pb-card pb-lead">
    <a @spa class="pb-thumb pb-ar-16x9" href="{{ route('article.show', $lead->slug) }}">
        <img src="{{ Str::startsWith($lead->featured_image, 'http') ? $lead->featured_image : asset($lead->featured_image) }}"
            alt="{{ $lead->title }}" loading="lazy">
        @if ($lead->category)
            <span class="pb-cat">{{ $lead->category->name }}</span>
        @endif
    </a>
    <h2 class="pb-title">
        <a @spa href="{{ route('article.show', $lead->slug) }}">{{ $lead->title }}</a>
    </h2>
    @if ($lead->excerpt)
        <p class="pb-excerpt">{{ $lead->excerpt }}</p>
    @endif
    <div class="pb-meta">
        @if ($lead->category)
            <span class="pb-cat-text">{{ $lead->category->name }}</span> ·
        @endif
        <span><i class="bi bi-clock"></i> {{ $lead->published_at->diffForHumans() }}</span>
        · <span><i class="bi bi-eye"></i> {{ number_format($lead->view_count) }}</span>
    </div>
</article>
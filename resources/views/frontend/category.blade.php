@extends('frontend.master')
@section('title', $category->name?? '')

@section('content')

<section class="pb-cat-hero">
    <div class="container-pb">
        <h1 class="my-1">{{ $category->name }}</h1>
        @if($category->description)
            <div class="sub">{{ $category->description }}</div>
        @endif
    </div>
</section>

<section class="pb-section">
    <div class="container-pb">
        <div class="pb-section-head mt-3"><h2>{{ $category->name?? '' }}</h2></div>
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="row g-4" id="articles-wrapper">
                    @forelse($articles as $article)
                        @include('frontend.article_card', ['article' => $article])
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">এই ক্যাটাগরিতে কোনো নিউজ পাওয়া যায়নি।</p>
                        </div>
                    @endforelse
                </div>

                @if($articles->hasMorePages())
                    <div class="text-center mt-5 mb-4">
                        <button id="load-more-btn" data-page="1" class="btn pb-btn-epaper px-4 py-2">
                            <span class="spinner-border spinner-border-sm me-2 d-none" id="btn-spinner" role="status"></span>
                            আরো খবর দেখুন
                        </button>
                    </div>
                @endif
            </div>
            
            <aside class="col-lg-4">
                <div class="pb-widget">
                    <div class="pb-widget-head"><h3>সর্বাধিক পঠিত</h3></div>
                    <div class="pb-popular">
                        @forelse($mostReadArticles as $mostRead)
                            <div class="pb-pop-item">
                                <div>
                                    <a class="pb-title" href="{{ route('article.show', $mostRead->slug) }}">
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

@section('script')
<script>
    $(document).ready(function () {
        
        $(document).on('click', '#load-more-btn', function () {
            var btn = $(this);
            var page = btn.data('page');
            var nextPage = page + 1;
            var spinner = $('#btn-spinner');

            spinner.removeClass('d-none');
            btn.prop('disabled', true);

            $.ajax({
                url: "{{ url()->current() }}?page=" + nextPage,
                type: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.html) {
                        console.log(response.html);
                        $('#articles-wrapper').append(response.html);
                        btn.data('page', nextPage);
                        
                        spinner.addClass('d-none');
                        btn.prop('disabled', false);

                        if (!response.hasMorePages) {
                            btn.parent().remove();
                        }
                    } else {
                        btn.parent().remove();
                    }
                },
                error: function (xhr) {
                    console.log('Error loading articles.');
                    spinner.addClass('d-none');
                    btn.prop('disabled', false);
                }
            });
        });

    });
</script>
@endsection
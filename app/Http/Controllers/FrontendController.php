<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\CompanyDetails;
use App\Models\Contact;
use App\Models\PageSeo;
use App\Models\Tag;
use Illuminate\Http\Request;
use OpenGraph;
use SEOMeta;
use Twitter;

class FrontendController extends Controller
{
    public function index()
    {
        $this->seo();

        return spa('frontend.index');
    }

    public function category(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $articlesQuery = Article::where('category_id', $category->id)
            ->where('is_active', true)
            ->where('is_video', false)
            ->where('published_at', '<=', now())
            ->latest('published_at');

        if ($request->ajax()) {
            $articles = $articlesQuery->paginate(9);

            $html = '';
            foreach ($articles as $article) {
                $html .= view('frontend.article_card', compact('article'))->render();
            }

            return response()->json([
                'html' => $html,
                'hasMorePages' => $articles->hasMorePages()
            ]);
        }

        $articles = $articlesQuery->paginate(9);

        $mostReadArticles = Article::where('category_id', $category->id)
            ->where('is_video', false)
            ->where('is_active', true)
            ->where('published_at', '<=', now())
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();

        $popularTags = Tag::where('is_active', true)
            ->withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->limit(12)
            ->get();

        $this->seo(
            null,
            $category->meta_title ?: $category->name,
            $category->meta_description ?: $category->description,
            $category->meta_keywords,
            $category->image
        );

        return spa('frontend.category', compact('category', 'articles', 'mostReadArticles', 'popularTags'));
    }

    public function video(Request $request)
    {
        $articlesQuery = Article::where('is_video', true)
            ->where('is_active', true)
            ->where('published_at', '<=', now())
            ->latest('published_at');

        if ($request->ajax()) {
            $articles = $articlesQuery->paginate(9);

            $html = '';
            foreach ($articles as $article) {
                $html .= view('frontend.article_card', compact('article'))->render();
            }

            return response()->json([
                'html'         => $html,
                'hasMorePages' => $articles->hasMorePages()
            ]);
        }

        $articles = $articlesQuery->paginate(9);

        $mostReadArticles = Article::where('is_video', true)
            ->where('is_active', true)
            ->where('published_at', '<=', now())
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();

        $popularTags = Tag::where('is_active', true)
            ->withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->limit(12)
            ->get();

        $this->seo(null, 'ভিডিও', null, null, null);

        return spa('frontend.video', compact('articles', 'mostReadArticles', 'popularTags'));
    }

    private function categoryArticles(string $slug, int $limit)
    {
        return Article::where('is_active', true)
            ->where('is_video', false)
            ->whereHas('category', fn($q) => $q->where('slug', $slug))
            ->with('category')
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    public function article($slug)
    {
        $article = Article::with(['category', 'tags', 'sources'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $article->increment('view_count');

        $isVideo = $article->is_video;

        $mostReadArticles = Article::where('category_id', $article->category_id)
            ->where('is_video', $isVideo)
            ->where('is_active', true)
            ->where('published_at', '<=', now())
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();

        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('is_video', $isVideo)
            ->where('is_active', true)
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(3)
            ->get();

        $popularTags = Tag::where('is_active', true)
            ->withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->limit(12)
            ->get();

        $this->seo(
            null,
            $article->meta_title ?: $article->title,
            $article->meta_description ?: $article->excerpt,
            $article->meta_keywords,
            $article->featured_image
        );

        return spa('frontend.article', compact('article', 'mostReadArticles', 'relatedArticles', 'popularTags'));
    }

    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $articles = $tag->articles()
            ->where('is_active', true)
            ->where('is_video', false)
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(9)
            ->get();

        $mostReadArticles = Article::where('is_active', true)
            ->where('is_video', false)
            ->where('published_at', '<=', now())
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();

        $popularTags = Tag::where('is_active', true)
            ->withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->limit(12)
            ->get();

        $this->seo();

        return spa('frontend.tag', compact('tag', 'articles', 'mostReadArticles', 'popularTags'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $date = $request->input('date');

        $articlesQuery = Article::with(['category'])
            ->where('is_video', false)
            ->where('is_active', true)
            ->where('published_at', '<=', now());

        if (!empty(trim($query))) {
            $articlesQuery->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('body', 'LIKE', "%{$query}%")
                    ->orWhere('author', 'LIKE', "%{$query}%");
            });
        }

        if (!empty($date)) {
            $articlesQuery->whereDate('published_at', $date);
        }

        $articles = $articlesQuery->latest('published_at')->take(9)->get();

        $mostReadArticles = Article::where('is_active', true)
            ->where('is_video', false)
            ->where('published_at', '<=', now())
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();

        $popularTags = Tag::where('is_active', true)
            ->withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->limit(12)
            ->get();

        $seoTitle = !empty($date) ? date('d-m-Y', strtotime($date)) . ' এর খবর' : 'অনুসন্ধান';
        $this->seo(null, null, $seoTitle . ' এর জন্য প্রকাশিত খবরসমূহ দেখুন।');

        return spa('frontend.search', compact('articles', 'query', 'date', 'mostReadArticles', 'popularTags'));
    }

    public function epaper()
    {
        $this->seo(
            null,
            'ই-পেপার — ' . config('app.name'),
            'আজকের দৈনিক পত্রিকার ডিজিটাল সংস্করণ বা ই-পেপার পড়তে এখানে ভিজিট করুন।',
            null,
            null
        );
        return spa('frontend.epaper');
    }

    public function live()
    {
        $this->seo(
            null,
            'লাইভ — ' . config('app.name'),
            'সর্বশেষ ঘটনার সরাসরি সম্প্রচার এবং লাইভ আপডেট দেখতে আমাদের সাথেই থাকুন।',
            null,
            null
        );

        return spa('frontend.live');
    }

    public function archive()
    {
        $this->seo(null, null, 'পুরোনো দিনের সব খবর ও আর্কাইভ সংস্করণ দেখতে তারিখ নির্বাচন করুন।');

        return spa('frontend.archive');
    }

    public function about()
    {
        $this->seo('about');

        return spa('frontend.about');
    }

    public function contact()
    {
        $this->seo();

        return spa('frontend.contact');
    }

    public function contactStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'unread',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'আপনার বার্তাটি সফলভাবে পাঠানো হয়েছে।'
        ]);
    }

    public function advertise()
    {
        $this->seo(null, null, 'আমাদের অনলাইন ও প্রিন্ট সংস্করণে বিজ্ঞাপন দেওয়ার নিয়মাবলী এবং রেট কার্ড সম্পর্কে জানুন।');

        return spa('frontend.advertise');
    }

    public function career()
    {
        $this->seo(null, null, 'আমাদের সাথে কাজ করার সুযোগ এবং চলমান ক্যারিয়ার বিজ্ঞপ্তিগুলো এখানে দেখুন।');

        return spa('frontend.career');
    }

    public function privacy()
    {
        $this->seo(null, null, 'আমাদের গোপনীয়তা নীতি এবং ব্যবহারকারীদের তথ্য সুরক্ষার নিয়মাবলী।');

        return spa('frontend.privacy');
    }

    public function newsletter(Request $r)
    {
        return back()->with('success', 'সাবস্ক্রাইব সম্পন্ন হয়েছে।');
    }

    private function seo($pageKey = null, $title = null, $description = null, $keywords = null, $image = null)
    {
        $company = CompanyDetails::first();

        $pageSeo = $pageKey ? PageSeo::where('page_key', $pageKey)->first() : null;

        $title = $title ?: ($pageSeo?->meta_title ?: $company?->meta_title);

        $description = $description ?: ($pageSeo?->meta_description ?: $company?->meta_description);

        $keywords = $keywords ?: ($pageSeo?->meta_keywords ?: $company?->meta_keywords);

        $image = $image ?: ($pageSeo?->meta_image ? asset($pageSeo->meta_image) : ($company?->meta_image ? asset('uploads/company/meta/' . $company->meta_image) : null));

        if ($title) {
            SEOMeta::setTitle($title);
            OpenGraph::setTitle($title);
            Twitter::setTitle($title);
        }

        if ($description) {
            SEOMeta::setDescription($description);
            OpenGraph::setDescription($description);
            Twitter::setDescription($description);
        }

        if ($keywords) {
            SEOMeta::setKeywords($keywords);
        }

        if ($image) {
            OpenGraph::addImage($image);
            Twitter::setImage($image);
        }
    }
}
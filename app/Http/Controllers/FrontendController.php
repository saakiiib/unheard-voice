<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Article;
use App\Models\Category;
use App\Models\CompanyDetails;
use App\Models\Contact;
use App\Models\PageSeo;
use App\Models\Slider;
use App\Models\Tag;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use OpenGraph;
use SEOMeta;
use Twitter;

class FrontendController extends Controller
{
    public function index()
    {
        $this->seo();

        $sliders = Slider::where('is_active', true)->orderBy('sort_order', 'asc')->get();

        $activities = Activity::with('category')->where('is_active', true)->orderBy('sort_order', 'asc')->take(3)->get();

        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order', 'asc')->get();

        return spa('frontend.index', compact('sliders', 'activities', 'testimonials'));
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

    public function privacy()
    {
        $this->seo(null, null, 'আমাদের গোপনীয়তা নীতি এবং ব্যবহারকারীদের তথ্য সুরক্ষার নিয়মাবলী।');

        return spa('frontend.privacy');
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
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Blog;
use App\Models\CompanyDetails;
use App\Models\Contact;
use App\Models\Event;
use App\Models\PageSeo;
use App\Models\Slider;
use App\Models\Team;
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

    public function about()
    {
        $this->seo('about');

        return spa('frontend.about');
    }

    public function team()
    {
        $this->seo('team');

        $leadership = Team::where('type', 'Leadership')->where('is_active', true)->orderBy('sort_order')->get();

        $advisors   = Team::where('type', 'Advisors')->where('is_active', true)->orderBy('sort_order')->get();

        return spa('frontend.team', compact('leadership', 'advisors'));
    }

    public function activities()
    {
        $this->seo('activities');

        $activities = Activity::where('is_active', true)
            ->with('category')
            ->orderBy('sort_order')
            ->get();

        return spa('frontend.activities', compact('activities'));
    }

    public function activityDetails($slug)
    {
        $activity = Activity::where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();

        $this->seo(
            null,
            $activity->meta_title ?: $activity->title,
            $activity->meta_description,
            $activity->meta_keywords,
            $activity->meta_image ?: $activity->image
        );

        $related = Activity::where('is_active', true)
            ->where('id', '!=', $activity->id)
            ->with('category')
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return spa('frontend.activity-details', compact('activity', 'related'));
    }

    public function blogs()
    {
        $this->seo('blogs');

        $blogs = Blog::where('is_active', true)
            ->with('category')
            ->orderBy('sort_order')
            ->get();

        return spa('frontend.blogs', compact('blogs'));
    }

    public function blogDetails($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();

        $this->seo(
            null,
            $blog->meta_title ?: $blog->title,
            $blog->meta_description,
            $blog->meta_keywords,
            $blog->meta_image ?: $blog->image
        );

        $related = Blog::where('is_active', true)
            ->where('id', '!=', $blog->id)
            ->with('category')
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return spa('frontend.blog-details', compact('blog', 'related'));
    }

    public function events()
    {
        $this->seo('events');

        $events = Event::where('is_active', true)
            ->with('category')
            ->orderBy('sort_order')
            ->get();

        return spa('frontend.events', compact('events'));
    }

    public function eventDetails($slug)
    {
        $event = Event::where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();

        $this->seo(
            null,
            $event->meta_title ?: $event->title,
            $event->meta_description,
            $event->meta_keywords,
            $event->meta_image ?: $event->image
        );

        $related = Event::where('is_active', true)
            ->where('id', '!=', $event->id)
            ->with('category')
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return spa('frontend.event-details', compact('event', 'related'));
    }

    public function contact()
    {
        $this->seo('contact');

        $companyDetails = CompanyDetails::firstOrCreate();
        
        return spa('frontend.contact', compact('companyDetails'));
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
            'message' => 'Your message has been sent successfully.',
        ]);
    }

    public function donate()
    {
        $this->seo('donate');

        return spa('frontend.donate');
    }

    public function privacy()
    {
        $this->seo('privacy');

        return spa('frontend.privacy');
    }

    public function terms()
    {
        $this->seo('terms');

        return spa('frontend.terms');
    }

    public function faq()
    {
        $this->seo('faq');
        
        return spa('frontend.faq');
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
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Activity;
use App\Models\Blog;
use App\Models\CompanyDetails;
use App\Models\Contact;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\PageSeo;
use App\Models\Slider;
use App\Models\Team;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

        $activities = Event::with('category')->where('is_active', true)->past()->orderBy('event_date', 'desc')->take(3)->get();

        $events = Event::with('category')->where('is_active', true)->upcoming()->orderBy('event_date', 'asc')->take(3)->get();

        return spa('frontend.index', compact('sliders', 'activities', 'testimonials', 'events'));
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

        $activities = Event::where('is_active', true)
            ->past()
            ->with('category')
            ->orderBy('event_date', 'desc')
            ->get();

        return spa('frontend.activities', compact('activities'));
    }

    public function activityDetails($slug)
    {
        $activity = Event::where('slug', $slug)
            ->where('is_active', true)
            ->past()
            ->with('category')
            ->firstOrFail();

        $this->seo(
            null,
            $activity->meta_title ?: $activity->title,
            $activity->meta_description,
            $activity->meta_keywords,
            $activity->meta_image ?: $activity->image
        );

        $related = Event::where('is_active', true)
            ->past()
            ->where('id', '!=', $activity->id)
            ->with('category')
            ->orderBy('event_date', 'desc')
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
            ->upcoming()
            ->with('category')
            ->orderBy('event_date', 'asc')
            ->get();

        return spa('frontend.events', compact('events'));
    }

    public function eventDetails($slug)
    {
        $event = Event::where('slug', $slug)
            ->where('is_active', true)
            ->upcoming()
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
            ->upcoming()
            ->where('id', '!=', $event->id)
            ->with('category')
            ->orderBy('event_date', 'asc')
            ->limit(3)
            ->get();

        return spa('frontend.event-details', compact('event', 'related'));
    }

    public function gallery()
    {
        $this->seo('gallery');

        $galleries = Gallery::where('is_active', true)
            ->with(['media' => function ($query) {
                $query->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();

        return spa('frontend.gallery', compact('galleries'));
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
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => ['nullable', 'string', 'max:20', 'regex:/^(?:\+44|0)(?:7\d{9}|1\d{9}|2\d{9}|3\d{9})$/'],
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $contact = Contact::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'status'  => 'unread',
        ]);

        Mail::to(config('mail.from.address'))->send(new ContactMail($contact));

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

        $image = $image ?: ($pageSeo?->meta_image ? asset($pageSeo->meta_image) : ($company?->meta_image ? asset('uploads/company/' . $company->meta_image) : null));

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
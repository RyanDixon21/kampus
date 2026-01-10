<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\News;
use App\Models\Facility;
use App\Models\Tendik;
use App\Models\HeroCard;
use App\Models\WhyChooseUs;

class HomeController extends Controller
{
    /**
     * Display the home page with all necessary content.
     * 
     * Requirements: 2.1, 2.2, 2.3, 6.4
     */
    public function index()
    {
        // Load settings from cache
        $settings = Setting::getSettings();
        
        // Load latest news with eager loading for author relationship
        $latestNews = News::with('author')
            ->published()
            ->latest('published_at')
            ->take(6)
            ->get();
        
        // Load active facilities ordered by order column
        $facilities = Facility::published()
            ->latest('published_at')
            ->get();
        
        // Load active tendik
        $tendik = Tendik::active()->get();
        
        // Load active hero cards
        $heroCards = HeroCard::active()->ordered()->get();
        
        // Load why choose us items
        $whyChooseUs = WhyChooseUs::where('is_active', true)
            ->orderBy('order')
            ->get();
        
        return view('home', compact('settings', 'latestNews', 'facilities', 'tendik', 'heroCards', 'whyChooseUs'));
    }

    /**
     * Display all news page
     */
    public function allNews()
    {
        // Load settings
        $settings = Setting::getSettings();
        
        // Load all published news with pagination
        $allNews = News::with('author')
            ->published()
            ->latest('published_at')
            ->paginate(12);
        
        return view('news-index', compact('settings', 'allNews'));
    }

    /**
     * Display news detail page
     */
    public function showNews(News $news)
    {
        // Check if news is published
        if ($news->status !== 'published' || $news->published_at > now()) {
            abort(404);
        }

        // Load settings
        $settings = Setting::getSettings();
        
        // Load related news (same category or latest)
        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('news-detail', compact('news', 'settings', 'relatedNews'));
    }

    /**
     * Display facility detail page
     */
    public function showFacility(Facility $facility)
    {
        // Check if facility is published
        if ($facility->status !== 'published' || $facility->published_at > now()) {
            abort(404);
        }

        // Load settings
        $settings = Setting::getSettings();
        
        // Load related facilities
        $relatedFacilities = Facility::published()
            ->where('id', '!=', $facility->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('facility-detail', compact('facility', 'settings', 'relatedFacilities'));
    }
}

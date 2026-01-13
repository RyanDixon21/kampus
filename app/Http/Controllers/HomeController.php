<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\News;
use App\Models\Facility;
use App\Models\Tendik;
use App\Models\HeroCard;
use App\Models\WhyChooseUs;
use App\Models\About;

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

    /**
     * Display about page
     */
    public function about()
    {
        // Load settings
        $settings = Setting::getSettings();
        
        // Load about content grouped by section
        $sejarah = About::active()->bySection('sejarah')->ordered()->get();
        $visi = About::active()->bySection('visi')->ordered()->get();
        $misi = About::active()->bySection('misi')->ordered()->get();
        $nilaiNilai = About::active()->bySection('nilai')->ordered()->get();
        
        // Load nilai header
        $nilaiHeader = About::active()->bySection('nilai_header')->first();
        
        // Load akreditasi header and items
        $akreditasiHeader = About::active()->bySection('akreditasi_header')->first();
        $akreditasiItems = About::active()->bySection('akreditasi')->ordered()->get();
        
        // Load CTA data
        $cta = About::active()->bySection('cta')->first();
        $ctaButton = About::active()->bySection('cta_button')->first();
        
        // Load akreditasi (for backward compatibility)
        $accreditation = About::active()->bySection('akreditasi')->first()?->content ?? 'B';

        return view('about', compact('settings', 'sejarah', 'visi', 'misi', 'nilaiNilai', 'nilaiHeader', 'akreditasiHeader', 'akreditasiItems', 'cta', 'ctaButton', 'accreditation'));
    }
}

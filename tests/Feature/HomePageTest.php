<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Setting;
use App\Models\News;
use App\Models\Facility;
use App\Models\Tendik;
use App\Models\User;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that home page renders all sections correctly.
     * 
     * Requirements: 2.1, 2.4, 2.5, 2.6, 2.7
     */
    public function test_home_page_renders_all_sections(): void
    {
        // Setup test data
        Setting::set('university_name', 'STT Pratama Adi');
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        
        // Check for all main sections
        $response->assertSee('beranda', false); // Section ID
        $response->assertSee('berita', false);  // Section ID
        $response->assertSee('fasilitas', false); // Section ID
        $response->assertSee('tendik', false);  // Section ID
        
        // Check section headings
        $response->assertSee('Selamat Datang');
        $response->assertSee('Berita Terkini');
        $response->assertSee('Fasilitas Kampus');
        $response->assertSee('Tenaga Kependidikan');
    }

    /**
     * Test that hero section displays university information.
     * 
     * Requirements: 2.1, 10.4
     */
    public function test_hero_section_displays_university_info(): void
    {
        Setting::set('university_name', 'STT Pratama Adi');
        Setting::set('description', 'Kampus teknologi terdepan');
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('STT Pratama Adi');
        $response->assertSee('Sekolah Tinggi Teknologi Terdepan');
        $response->assertSee('Daftar Sekarang');
    }

    /**
     * Test that news section displays published news with thumbnails.
     * 
     * Requirements: 2.5, 10.4
     */
    public function test_news_section_displays_published_news(): void
    {
        Setting::set('university_name', 'STT Pratama Adi');
        $user = User::factory()->create();
        
        // Create published news
        $news = News::create([
            'title' => 'Test News Article',
            'slug' => 'test-news-article',
            'content' => 'This is test content for the news article.',
            'status' => 'published',
            'published_at' => now(),
            'created_by' => $user->id,
        ]);
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Test News Article');
        $response->assertSee('Berita Terkini');
    }

    /**
     * Test that news section shows empty state when no news available.
     * 
     * Requirements: 2.5
     */
    public function test_news_section_shows_empty_state(): void
    {
        Setting::set('university_name', 'STT Pratama Adi');
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Belum ada berita tersedia');
    }

    /**
     * Test that facilities section displays active facilities.
     * 
     * Requirements: 2.6, 10.4
     */
    public function test_facilities_section_displays_active_facilities(): void
    {
        Setting::set('university_name', 'STT Pratama Adi');
        
        // Create active facility
        $facility = Facility::create([
            'name' => 'Laboratorium Komputer',
            'description' => 'Lab dengan peralatan modern',
            'order' => 1,
            'is_active' => true,
        ]);
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Laboratorium Komputer');
        $response->assertSee('Lab dengan peralatan modern');
        $response->assertSee('Fasilitas Kampus');
    }

    /**
     * Test that facilities section shows empty state when no facilities available.
     * 
     * Requirements: 2.6
     */
    public function test_facilities_section_shows_empty_state(): void
    {
        Setting::set('university_name', 'STT Pratama Adi');
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Informasi fasilitas akan segera tersedia');
    }

    /**
     * Test that tendik section displays active staff.
     * 
     * Requirements: 2.7, 10.4
     */
    public function test_tendik_section_displays_active_staff(): void
    {
        Setting::set('university_name', 'STT Pratama Adi');
        
        // Create active tendik
        $tendik = Tendik::create([
            'name' => 'John Doe',
            'position' => 'Staff Administrasi',
            'email' => 'john@example.com',
            'phone' => '081234567890',
            'is_active' => true,
        ]);
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('Staff Administrasi');
        $response->assertSee('john@example.com');
        $response->assertSee('081234567890');
    }

    /**
     * Test that tendik section shows empty state when no staff available.
     * 
     * Requirements: 2.7
     */
    public function test_tendik_section_shows_empty_state(): void
    {
        Setting::set('university_name', 'STT Pratama Adi');
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Informasi tenaga kependidikan akan segera tersedia');
    }

    /**
     * Test that page includes smooth animations.
     * 
     * Requirements: 10.4
     */
    public function test_page_includes_smooth_animations(): void
    {
        Setting::set('university_name', 'STT Pratama Adi');
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        // Check for animation classes
        $response->assertSee('animate-fade-in');
        $response->assertSee('animate-fade-in-up');
        $response->assertSee('animate-on-scroll');
    }

    /**
     * Test that page includes loading indicators.
     * 
     * Requirements: 10.5
     */
    public function test_page_includes_loading_indicators(): void
    {
        Setting::set('university_name', 'STT Pratama Adi');
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        // Check for loading state with Alpine.js
        $response->assertSee('loading: true');
        $response->assertSee('animate-pulse');
    }

    /**
     * Test that CTA section includes registration and WhatsApp links.
     * 
     * Requirements: 2.1, 10.4
     */
    public function test_cta_section_includes_action_buttons(): void
    {
        Setting::set('university_name', 'STT Pratama Adi');
        Setting::set('wa_admin', '628123456789');
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Siap Bergabung dengan Kami?');
        $response->assertSee('Daftar Sekarang');
        $response->assertSee('Hubungi Kami');
        $response->assertSee('wa.me/628123456789');
    }

    /**
     * Test that page is responsive with proper grid layouts.
     * 
     * Requirements: 2.8, 10.4
     */
    public function test_page_uses_responsive_grid_layouts(): void
    {
        Setting::set('university_name', 'STT Pratama Adi');
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        // Check for responsive grid classes
        $response->assertSee('grid-cols-1');
        $response->assertSee('md:grid-cols-2');
        $response->assertSee('lg:grid-cols-3');
        $response->assertSee('lg:grid-cols-4');
    }
}

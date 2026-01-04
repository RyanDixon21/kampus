<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Setting;
use App\Models\News;
use App\Models\Facility;
use App\Models\Tendik;
use App\Models\User;

class LayoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the app layout renders correctly.
     */
    public function test_app_layout_renders_correctly(): void
    {
        // Create a user for news author
        $user = User::factory()->create();
        
        // Create some test data
        Setting::set('university_name', 'STT Pratama Adi');
        Setting::set('address', 'Jl. Test No. 123');
        Setting::set('phone', '021-12345678');
        Setting::set('email', 'info@sttpratama.ac.id');
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('STT Pratama Adi');
        $response->assertSee('Beranda');
        $response->assertSee('Berita');
        $response->assertSee('Fasilitas');
        $response->assertSee('Tendik');
        $response->assertSee('Pendaftaran');
    }

    /**
     * Test that navigation menu is responsive.
     */
    public function test_navigation_menu_has_mobile_toggle(): void
    {
        Setting::set('university_name', 'STT Pratama Adi');
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        // Check for Alpine.js mobile menu toggle
        $response->assertSee('mobileMenuOpen');
    }

    /**
     * Test that footer displays contact information.
     */
    public function test_footer_displays_contact_information(): void
    {
        Setting::set('university_name', 'STT Pratama Adi');
        Setting::set('address', 'Jl. Test No. 123');
        Setting::set('phone', '021-12345678');
        Setting::set('email', 'info@sttpratama.ac.id');
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('Jl. Test No. 123');
        $response->assertSee('021-12345678');
        $response->assertSee('info@sttpratama.ac.id');
    }

    /**
     * Test that social media links are displayed when configured.
     */
    public function test_social_media_links_display_when_configured(): void
    {
        Setting::set('university_name', 'STT Pratama Adi');
        Setting::set('facebook_url', 'https://facebook.com/sttpratama');
        Setting::set('instagram_url', 'https://instagram.com/sttpratama');
        Setting::set('youtube_url', 'https://youtube.com/sttpratama');
        
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertSee('https://facebook.com/sttpratama');
        $response->assertSee('https://instagram.com/sttpratama');
        $response->assertSee('https://youtube.com/sttpratama');
    }
}

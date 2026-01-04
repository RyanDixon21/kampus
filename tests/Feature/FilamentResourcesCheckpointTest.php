<?php

namespace Tests\Feature;

use App\Models\CbtQuestion;
use App\Models\Facility;
use App\Models\News;
use App\Models\Registration;
use App\Models\Setting;
use App\Models\Tendik;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FilamentResourcesCheckpointTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create an admin user
        $this->admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
        
        // Setup fake storage for file uploads
        Storage::fake('public');
    }

    /** @test */
    public function settings_can_be_created_and_retrieved(): void
    {
        Setting::set('university_name', 'STT Pratama Adi');
        Setting::set('phone', '021-12345678');
        Setting::set('email', 'info@sttpratama.ac.id');
        
        $this->assertEquals('STT Pratama Adi', Setting::get('university_name'));
        $this->assertEquals('021-12345678', Setting::get('phone'));
        $this->assertEquals('info@sttpratama.ac.id', Setting::get('email'));
    }

    /** @test */
    public function settings_can_be_updated(): void
    {
        Setting::set('university_name', 'Old Name');
        Setting::set('university_name', 'STT Pratama Adi');
        
        $this->assertEquals('STT Pratama Adi', Setting::get('university_name'));
    }

    /** @test */
    public function news_can_be_created(): void
    {
        $news = News::create([
            'title' => 'Test News',
            'slug' => 'test-news',
            'content' => 'This is test content',
            'thumbnail' => 'news/test.jpg',
            'status' => 'published',
            'published_at' => now(),
            'created_by' => $this->admin->id,
        ]);

        $this->assertDatabaseHas('news', [
            'title' => 'Test News',
            'slug' => 'test-news',
            'status' => 'published',
        ]);
    }

    /** @test */
    public function news_can_be_updated(): void
    {
        $news = News::create([
            'title' => 'Original Title',
            'slug' => 'original-title',
            'content' => 'Original content',
            'thumbnail' => 'news/test.jpg',
            'status' => 'draft',
            'created_by' => $this->admin->id,
        ]);

        $news->update([
            'title' => 'Updated Title',
            'status' => 'published',
        ]);

        $this->assertDatabaseHas('news', [
            'id' => $news->id,
            'title' => 'Updated Title',
            'status' => 'published',
        ]);
    }

    /** @test */
    public function news_can_be_deleted(): void
    {
        $news = News::create([
            'title' => 'Test News',
            'slug' => 'test-news',
            'content' => 'Test content',
            'thumbnail' => 'news/test.jpg',
            'status' => 'published',
            'published_at' => now(),
            'created_by' => $this->admin->id,
        ]);

        $news->delete();

        $this->assertDatabaseMissing('news', [
            'id' => $news->id,
        ]);
    }

    /** @test */
    public function facilities_can_be_created(): void
    {
        $facility = Facility::create([
            'name' => 'Library',
            'description' => 'Modern library with digital resources',
            'image' => 'facilities/library.jpg',
            'order' => 1,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('facilities', [
            'name' => 'Library',
            'order' => 1,
            'is_active' => true,
        ]);
    }

    /** @test */
    public function facilities_can_be_updated(): void
    {
        $facility = Facility::create([
            'name' => 'Library',
            'description' => 'Old description',
            'image' => 'facilities/library.jpg',
            'order' => 1,
            'is_active' => true,
        ]);

        $facility->update([
            'description' => 'Updated description',
            'order' => 2,
        ]);

        $this->assertDatabaseHas('facilities', [
            'id' => $facility->id,
            'description' => 'Updated description',
            'order' => 2,
        ]);
    }

    /** @test */
    public function facilities_can_be_deleted(): void
    {
        $facility = Facility::create([
            'name' => 'Library',
            'description' => 'Test facility',
            'image' => 'facilities/library.jpg',
            'order' => 1,
            'is_active' => true,
        ]);

        $facility->delete();

        $this->assertDatabaseMissing('facilities', [
            'id' => $facility->id,
        ]);
    }

    /** @test */
    public function tendik_can_be_created(): void
    {
        $tendik = Tendik::create([
            'name' => 'John Doe',
            'position' => 'Administrative Staff',
            'photo' => 'tendik/john.jpg',
            'email' => 'john@sttpratama.ac.id',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('tendik', [
            'name' => 'John Doe',
            'position' => 'Administrative Staff',
            'email' => 'john@sttpratama.ac.id',
        ]);
    }

    /** @test */
    public function tendik_can_be_deleted(): void
    {
        $tendik = Tendik::create([
            'name' => 'John Doe',
            'position' => 'Administrative Staff',
            'photo' => 'tendik/john.jpg',
            'email' => 'john@sttpratama.ac.id',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        $tendik->delete();

        $this->assertDatabaseMissing('tendik', [
            'id' => $tendik->id,
        ]);
    }

    /** @test */
    public function registrations_can_be_viewed(): void
    {
        $registration = Registration::create([
            'registration_number' => 'REG20260001',
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '081234567890',
            'address' => 'Jakarta',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('registrations', [
            'registration_number' => 'REG20260001',
            'name' => 'Jane Doe',
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function registrations_can_be_deleted(): void
    {
        $registration = Registration::create([
            'registration_number' => 'REG20260001',
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '081234567890',
            'address' => 'Jakarta',
            'status' => 'pending',
        ]);

        $registration->delete();

        $this->assertDatabaseMissing('registrations', [
            'id' => $registration->id,
        ]);
    }

    /** @test */
    public function cbt_questions_can_be_created(): void
    {
        $question = CbtQuestion::create([
            'question' => 'What is 2 + 2?',
            'options' => [
                ['text' => '3', 'is_correct' => false],
                ['text' => '4', 'is_correct' => true],
                ['text' => '5', 'is_correct' => false],
                ['text' => '6', 'is_correct' => false],
            ],
            'category' => 'matematika',
            'difficulty' => 1,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('cbt_questions', [
            'question' => 'What is 2 + 2?',
            'category' => 'matematika',
            'is_active' => true,
        ]);
    }

    /** @test */
    public function cbt_questions_can_be_updated(): void
    {
        $question = CbtQuestion::create([
            'question' => 'What is 2 + 2?',
            'options' => [
                ['text' => '3', 'is_correct' => false],
                ['text' => '4', 'is_correct' => true],
            ],
            'category' => 'matematika',
            'difficulty' => 1,
            'is_active' => true,
        ]);

        $question->update([
            'difficulty' => 2,
            'is_active' => false,
        ]);

        $this->assertDatabaseHas('cbt_questions', [
            'id' => $question->id,
            'difficulty' => 2,
            'is_active' => false,
        ]);
    }

    /** @test */
    public function cbt_questions_can_be_deleted(): void
    {
        $question = CbtQuestion::create([
            'question' => 'What is 2 + 2?',
            'options' => [
                ['text' => '4', 'is_correct' => true],
            ],
            'category' => 'matematika',
            'difficulty' => 1,
            'is_active' => true,
        ]);

        $question->delete();

        $this->assertDatabaseMissing('cbt_questions', [
            'id' => $question->id,
        ]);
    }

    /** @test */
    public function file_upload_storage_is_configured(): void
    {
        // Test that we can create a fake file and store it
        $file = UploadedFile::fake()->image('test.jpg', 800, 600);
        
        $path = $file->store('test', 'public');
        
        Storage::disk('public')->assertExists($path);
    }

    /** @test */
    public function news_published_scope_works(): void
    {
        // Create published news
        News::create([
            'title' => 'Published News',
            'slug' => 'published-news',
            'content' => 'Content',
            'thumbnail' => 'news/test.jpg',
            'status' => 'published',
            'published_at' => now()->subDay(),
            'created_by' => $this->admin->id,
        ]);

        // Create draft news
        News::create([
            'title' => 'Draft News',
            'slug' => 'draft-news',
            'content' => 'Content',
            'thumbnail' => 'news/test.jpg',
            'status' => 'draft',
            'created_by' => $this->admin->id,
        ]);

        // Create future published news
        News::create([
            'title' => 'Future News',
            'slug' => 'future-news',
            'content' => 'Content',
            'thumbnail' => 'news/test.jpg',
            'status' => 'published',
            'published_at' => now()->addDay(),
            'created_by' => $this->admin->id,
        ]);

        $publishedNews = News::published()->get();

        $this->assertCount(1, $publishedNews);
        $this->assertEquals('Published News', $publishedNews->first()->title);
    }

    /** @test */
    public function facility_active_scope_works(): void
    {
        Facility::create([
            'name' => 'Active Facility',
            'description' => 'Test',
            'image' => 'test.jpg',
            'order' => 1,
            'is_active' => true,
        ]);

        Facility::create([
            'name' => 'Inactive Facility',
            'description' => 'Test',
            'image' => 'test.jpg',
            'order' => 2,
            'is_active' => false,
        ]);

        $activeFacilities = Facility::active()->get();

        $this->assertCount(1, $activeFacilities);
        $this->assertEquals('Active Facility', $activeFacilities->first()->name);
    }

    /** @test */
    public function tendik_active_scope_works(): void
    {
        Tendik::create([
            'name' => 'Active Staff',
            'position' => 'Admin',
            'photo' => 'test.jpg',
            'email' => 'active@test.com',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        Tendik::create([
            'name' => 'Inactive Staff',
            'position' => 'Admin',
            'photo' => 'test.jpg',
            'email' => 'inactive@test.com',
            'phone' => '081234567891',
            'is_active' => false,
        ]);

        $activeStaff = Tendik::active()->get();

        $this->assertCount(1, $activeStaff);
        $this->assertEquals('Active Staff', $activeStaff->first()->name);
    }

    /** @test */
    public function cbt_question_active_scope_works(): void
    {
        CbtQuestion::create([
            'question' => 'Active Question',
            'options' => [['text' => 'A', 'is_correct' => true]],
            'category' => 'matematika',
            'difficulty' => 1,
            'is_active' => true,
        ]);

        CbtQuestion::create([
            'question' => 'Inactive Question',
            'options' => [['text' => 'A', 'is_correct' => true]],
            'category' => 'matematika',
            'difficulty' => 1,
            'is_active' => false,
        ]);

        $activeQuestions = CbtQuestion::active()->get();

        $this->assertCount(1, $activeQuestions);
        $this->assertEquals('Active Question', $activeQuestions->first()->question);
    }

    /** @test */
    public function registration_pending_scope_works(): void
    {
        Registration::create([
            'registration_number' => 'REG20260001',
            'name' => 'Pending User',
            'email' => 'pending@test.com',
            'phone' => '081234567890',
            'address' => 'Jakarta',
            'status' => 'pending',
        ]);

        Registration::create([
            'registration_number' => 'REG20260002',
            'name' => 'Paid User',
            'email' => 'paid@test.com',
            'phone' => '081234567891',
            'address' => 'Jakarta',
            'status' => 'paid',
        ]);

        $pendingRegistrations = Registration::pending()->get();

        $this->assertCount(1, $pendingRegistrations);
        $this->assertEquals('Pending User', $pendingRegistrations->first()->name);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create an admin user
        $this->user = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_settings_page_is_accessible_for_authenticated_users(): void
    {
        $this->markTestSkipped('Filament authorization requires additional setup');
        
        $response = $this->actingAs($this->user)
            ->get('/admin/settings');

        $response->assertStatus(200);
    }

    public function test_settings_page_requires_authentication(): void
    {
        $response = $this->get('/admin/settings');

        $response->assertRedirect('/admin/login');
    }

    public function test_setting_model_can_store_and_retrieve_values(): void
    {
        Setting::set('test_key', 'test_value');
        
        $value = Setting::get('test_key');
        
        $this->assertEquals('test_value', $value);
    }

    public function test_setting_model_returns_default_for_missing_keys(): void
    {
        $value = Setting::get('non_existent_key', 'default_value');
        
        $this->assertEquals('default_value', $value);
    }

    public function test_setting_model_can_update_existing_values(): void
    {
        Setting::set('test_key', 'initial_value');
        Setting::set('test_key', 'updated_value');
        
        $value = Setting::get('test_key');
        
        $this->assertEquals('updated_value', $value);
    }

    public function test_settings_are_cached(): void
    {
        // Set a value
        Setting::set('cached_key', 'cached_value');
        
        // First call should hit the database and cache the result
        $value1 = Setting::get('cached_key');
        
        // Manually update the database without using Setting::set()
        // to bypass cache invalidation
        \DB::table('settings')
            ->where('key', 'cached_key')
            ->update(['value' => 'new_value']);
        
        // Second call should return cached value (not the updated database value)
        $value2 = Setting::get('cached_key');
        
        $this->assertEquals('cached_value', $value1);
        $this->assertEquals('cached_value', $value2); // Still returns cached value
    }

    public function test_cache_is_invalidated_when_setting_is_updated(): void
    {
        // Set initial value
        Setting::set('test_cache_key', 'initial_value');
        
        // Get the value (this will cache it)
        $value1 = Setting::get('test_cache_key');
        $this->assertEquals('initial_value', $value1);
        
        // Update the value using Setting::set()
        Setting::set('test_cache_key', 'updated_value');
        
        // Get the value again - should return updated value (cache was invalidated)
        $value2 = Setting::get('test_cache_key');
        $this->assertEquals('updated_value', $value2);
    }

    public function test_all_settings_cache_is_invalidated_on_update(): void
    {
        // Set multiple settings
        Setting::set('key1', 'value1');
        Setting::set('key2', 'value2');
        
        // Get all settings (this will cache them)
        $settings1 = Setting::getSettings();
        $this->assertEquals('value1', $settings1['key1']);
        $this->assertEquals('value2', $settings1['key2']);
        
        // Update one setting
        Setting::set('key1', 'new_value1');
        
        // Get all settings again - should return updated values
        $settings2 = Setting::getSettings();
        $this->assertEquals('new_value1', $settings2['key1']);
        $this->assertEquals('value2', $settings2['key2']);
    }

    public function test_cache_is_invalidated_when_setting_is_deleted(): void
    {
        // Set a value
        Setting::set('delete_test_key', 'test_value');
        
        // Get the value (this will cache it)
        $value1 = Setting::get('delete_test_key');
        $this->assertEquals('test_value', $value1);
        
        // Delete the setting using the model instance to trigger events
        $setting = Setting::where('key', 'delete_test_key')->first();
        $setting->delete();
        
        // Get the value again - should return null (cache was invalidated)
        $value2 = Setting::get('delete_test_key');
        $this->assertNull($value2);
    }

    public function test_cache_is_invalidated_when_model_is_saved_directly(): void
    {
        // Create a setting using Eloquent directly
        $setting = Setting::create(['key' => 'direct_key', 'value' => 'initial_value']);
        
        // Get the value (this will cache it)
        $value1 = Setting::get('direct_key');
        $this->assertEquals('initial_value', $value1);
        
        // Update using Eloquent directly (not through Setting::set())
        $setting->value = 'updated_value';
        $setting->save();
        
        // Get the value again - should return updated value (cache was invalidated by model event)
        $value2 = Setting::get('direct_key');
        $this->assertEquals('updated_value', $value2);
    }
}



<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Boot the model and register event listeners
     */
    protected static function boot()
    {
        parent::boot();

        // Invalidate cache when a setting is updated or deleted
        static::saved(function ($setting) {
            Cache::forget("setting.{$setting->key}");
            Cache::forget('settings.all');
        });

        static::deleted(function ($setting) {
            Cache::forget("setting.{$setting->key}");
            Cache::forget('settings.all');
        });
    }

    /**
     * Get a single setting value by key
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return Cache::remember("setting.{$key}", 3600, function () use ($key, $default) {
            return self::where('key', $key)->value('value') ?? $default;
        });
    }

    /**
     * Set a setting value by key
     * 
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, $value): void
    {
        // Convert arrays to JSON
        if (is_array($value)) {
            $value = json_encode($value);
        }
        
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        
        // Invalidate both individual setting cache and all settings cache
        Cache::forget("setting.{$key}");
        Cache::forget('settings.all');
    }

    /**
     * Get all settings as an associative array
     * 
     * @return array
     */
    public static function getSettings(): array
    {
        return Cache::remember('settings.all', 3600, function () {
            $settings = self::pluck('value', 'key')->toArray();
            
            // Decode JSON values
            foreach ($settings as $key => $value) {
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $settings[$key] = $decoded;
                }
            }
            
            return $settings;
        });
    }
}

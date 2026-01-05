<?php

namespace App\Observers;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingObserver
{
    /**
     * Handle the Setting "updating" event.
     */
    public function updating(Setting $setting): void
    {
        // Only handle file-related settings
        $fileSettings = ['logo', 'campus_images'];
        
        if (!in_array($setting->key, $fileSettings)) {
            return;
        }

        if ($setting->isDirty('value') && $setting->getOriginal('value')) {
            $oldValue = $setting->getOriginal('value');
            $newValue = $setting->value;

            // Handle single file (logo)
            if ($setting->key === 'logo') {
                if ($oldValue && Storage::disk('public')->exists($oldValue)) {
                    Storage::disk('public')->delete($oldValue);
                }
            }

            // Handle multiple files (campus_images)
            if ($setting->key === 'campus_images') {
                $oldImages = is_string($oldValue) ? json_decode($oldValue, true) : [];
                $newImages = is_string($newValue) ? json_decode($newValue, true) : [];

                if (!is_array($oldImages)) {
                    $oldImages = [];
                }
                if (!is_array($newImages)) {
                    $newImages = [];
                }

                // Find images that were removed
                $removedImages = array_diff($oldImages, $newImages);
                
                foreach ($removedImages as $image) {
                    if (Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }
        }
    }

    /**
     * Handle the Setting "deleting" event.
     */
    public function deleting(Setting $setting): void
    {
        // Only handle file-related settings
        $fileSettings = ['logo', 'campus_images'];
        
        if (!in_array($setting->key, $fileSettings)) {
            return;
        }

        // Handle single file (logo)
        if ($setting->key === 'logo' && $setting->value) {
            if (Storage::disk('public')->exists($setting->value)) {
                Storage::disk('public')->delete($setting->value);
            }
        }

        // Handle multiple files (campus_images)
        if ($setting->key === 'campus_images' && $setting->value) {
            $images = is_string($setting->value) ? json_decode($setting->value, true) : [];
            
            if (is_array($images)) {
                foreach ($images as $image) {
                    if (Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }
        }
    }
}

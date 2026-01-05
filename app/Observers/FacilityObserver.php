<?php

namespace App\Observers;

use App\Models\Facility;
use Illuminate\Support\Facades\Storage;

class FacilityObserver
{
    /**
     * Handle the Facility "updating" event.
     */
    public function updating(Facility $facility): void
    {
        // Handle main image replacement
        if ($facility->isDirty('image') && $facility->getOriginal('image')) {
            $oldImage = $facility->getOriginal('image');
            if (Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
        }

        // Handle images array replacement
        if ($facility->isDirty('images')) {
            $oldImages = $facility->getOriginal('images');
            $newImages = $facility->images;

            if (is_string($oldImages)) {
                $oldImages = json_decode($oldImages, true) ?? [];
            }
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

    /**
     * Handle the Facility "deleting" event.
     */
    public function deleting(Facility $facility): void
    {
        // Delete main image
        if ($facility->image && Storage::disk('public')->exists($facility->image)) {
            Storage::disk('public')->delete($facility->image);
        }

        // Delete all images
        if ($facility->images && is_array($facility->images)) {
            foreach ($facility->images as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }
    }
}

<?php

namespace App\Observers;

use App\Models\News;
use Illuminate\Support\Facades\Storage;

class NewsObserver
{
    /**
     * Handle the News "updating" event.
     */
    public function updating(News $news): void
    {
        // Handle thumbnail replacement
        if ($news->isDirty('thumbnail') && $news->getOriginal('thumbnail')) {
            $oldThumbnail = $news->getOriginal('thumbnail');
            if (Storage::disk('public')->exists($oldThumbnail)) {
                Storage::disk('public')->delete($oldThumbnail);
            }
        }

        // Handle images array replacement
        if ($news->isDirty('images')) {
            $oldImages = $news->getOriginal('images');
            $newImages = $news->images;

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
     * Handle the News "deleting" event.
     */
    public function deleting(News $news): void
    {
        // Delete thumbnail
        if ($news->thumbnail && Storage::disk('public')->exists($news->thumbnail)) {
            Storage::disk('public')->delete($news->thumbnail);
        }

        // Delete all images
        if ($news->images && is_array($news->images)) {
            foreach ($news->images as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }
    }
}

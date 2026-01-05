<?php

namespace App\Observers;

use App\Models\HeroCard;
use Illuminate\Support\Facades\Storage;

class HeroCardObserver
{
    /**
     * Handle the HeroCard "updating" event.
     */
    public function updating(HeroCard $heroCard): void
    {
        // Handle background image replacement
        if ($heroCard->isDirty('background_image') && $heroCard->getOriginal('background_image')) {
            $oldImage = $heroCard->getOriginal('background_image');
            if (Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
        }
    }

    /**
     * Handle the HeroCard "deleting" event.
     */
    public function deleting(HeroCard $heroCard): void
    {
        // Delete background image
        if ($heroCard->background_image && Storage::disk('public')->exists($heroCard->background_image)) {
            Storage::disk('public')->delete($heroCard->background_image);
        }
    }
}

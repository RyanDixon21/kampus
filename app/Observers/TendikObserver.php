<?php

namespace App\Observers;

use App\Models\Tendik;
use Illuminate\Support\Facades\Storage;

class TendikObserver
{
    /**
     * Handle the Tendik "updating" event.
     */
    public function updating(Tendik $tendik): void
    {
        // Handle photo replacement
        if ($tendik->isDirty('photo') && $tendik->getOriginal('photo')) {
            $oldPhoto = $tendik->getOriginal('photo');
            if (Storage::disk('public')->exists($oldPhoto)) {
                Storage::disk('public')->delete($oldPhoto);
            }
        }
    }

    /**
     * Handle the Tendik "deleting" event.
     */
    public function deleting(Tendik $tendik): void
    {
        // Delete photo
        if ($tendik->photo && Storage::disk('public')->exists($tendik->photo)) {
            Storage::disk('public')->delete($tendik->photo);
        }
    }
}

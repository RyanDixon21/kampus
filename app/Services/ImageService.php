<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageService
{
    /**
     * Optimize and save uploaded image with optional thumbnail generation
     * 
     * @param UploadedFile $file
     * @param string $path Storage path (e.g., 'news', 'facilities')
     * @param array $sizes Optional thumbnail sizes ['thumbnail' => ['width' => 300, 'height' => 200]]
     * @return string Relative path to saved image
     */
    public function optimize(UploadedFile $file, string $path, array $sizes = []): string
    {
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $image = Image::make($file);
        
        // Compress and resize main image (max width 1200px)
        $image->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        
        // Save main image with 80% quality
        $fullPath = storage_path("app/public/{$path}/{$filename}");
        
        // Ensure directory exists
        $directory = dirname($fullPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        $image->save($fullPath, 80);
        
        // Generate thumbnails
        foreach ($sizes as $sizeName => $dimensions) {
            $thumb = Image::make($file);
            $thumb->fit($dimensions['width'], $dimensions['height']);
            
            $thumbFilename = "{$sizeName}_{$filename}";
            $thumbPath = storage_path("app/public/{$path}/{$thumbFilename}");
            
            $thumb->save($thumbPath, 80);
        }
        
        return "{$path}/{$filename}";
    }
}

<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Compress and store image.
     */
    public function compressAndStore(UploadedFile $file, string $directory = 'products'): string
    {
        $filename = Str::random(40) . '.webp';
        
        $image = Image::read($file);
        
        $image->scaleDown(width: 1200);
        
        $path = "{$directory}/{$filename}";
        
        Storage::disk('public')->put($path, (string) $image->toWebp(80));
        
        return $path;
    }

    /**
     * Generate thumbnail.
     */
    public function generateThumbnail(string $imagePath): string
    {
        $fullPath = storage_path("app/public/{$imagePath}");
        
        $pathInfo = pathinfo($imagePath);
        $thumbPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_thumb.' . $pathInfo['extension'];
        
        $image = Image::read($fullPath);
        
        $image->cover(400, 300);
        
        Storage::disk('public')->put($thumbPath, (string) $image->toWebp(80)); // Encode correctly or just use default format
        
        return $thumbPath;
    }

    /**
     * Delete image.
     */
    public function deleteImage(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}

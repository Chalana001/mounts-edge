<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class GalleryItem extends Model
{
    protected $fillable = ['gallery_category_id', 'image', 'description'];

    public function category()
    {
        return $this->belongsTo(GalleryCategory::class, 'gallery_category_id');
    }

    /**
     * "width / height" for a CSS aspect-ratio, read from the stored file.
     *
     * The masonry gallery lets each image keep its own proportions, so without
     * this the browser cannot reserve space for a lazy-loaded image and the
     * columns visibly reflow as photos arrive. Cached per file path + mtime so
     * the dimensions are only measured once, and re-measured if the file is
     * replaced. Falls back to a 4:3 box if the file is missing or unreadable.
     */
    public function getAspectRatioAttribute(): string
    {
        $relativePath = ltrim(str_replace('/storage/', '', (string) $this->image), '/');
        $absolutePath = storage_path('app/public/'.$relativePath);

        if ($relativePath === '' || ! is_file($absolutePath)) {
            return '4 / 3';
        }

        return Cache::rememberForever(
            'gallery-aspect:'.md5($absolutePath.'|'.filemtime($absolutePath)),
            function () use ($absolutePath) {
                $size = @getimagesize($absolutePath);

                if (! $size || empty($size[0]) || empty($size[1])) {
                    return '4 / 3';
                }

                return $size[0].' / '.$size[1];
            }
        );
    }
}

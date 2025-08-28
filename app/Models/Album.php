<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = [
        'name',
        'description',
        'cover_image',
        'is_active',
        'sort_order'
    ];

    /**
     * Get the gallery images for the album.
     */
    public function galleryImages()
    {
        return $this->hasMany(GalleryImage::class);
    }
}

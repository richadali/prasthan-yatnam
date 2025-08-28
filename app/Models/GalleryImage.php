<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = [
        'album_id',
        'image_path'
    ];

    /**
     * Get the album that owns the gallery image.
     */
    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poem extends Model
{
    protected $fillable = [
        'title',
        'image',
        'display_order',
    ];

    protected $casts = [
        'display_order' => 'integer',
    ];
}

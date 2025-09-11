<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poem extends Model
{
    protected $fillable = [
        'title',
        'file_path',
        'file_type',
        'display_order',
    ];

    protected $casts = [
        'display_order' => 'integer',
    ];
}

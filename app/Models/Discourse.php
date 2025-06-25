<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Discourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'is_featured',
        'is_active',
        'price',
        'slug',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($discourse) {
            // Generate slug if not provided
            if (!$discourse->slug) {
                $discourse->slug = Str::slug($discourse->title);
            }
        });
    }

    /**
     * Get the videos for the discourse.
     */
    public function videos(): HasMany
    {
        return $this->hasMany(DiscourseVideo::class)->orderBy('sequence');
    }

    /**
     * Get the enrolled users for the discourse.
     */
    public function enrolledUsers()
    {
        return $this->belongsToMany(User::class, 'user_discourses')
            ->withPivot(['enrolled_at', 'expires_at', 'payment_id', 'payment_status', 'amount_paid'])
            ->withTimestamps();
    }

    /**
     * Check if discourse has free preview videos
     */
    public function hasFreePreview(): bool
    {
        return $this->videos()->where('is_free_preview', true)->exists();
    }

    /**
     * Get free preview videos
     */
    public function freePreviewVideos()
    {
        return $this->videos()->where('is_free_preview', true)->orderBy('sequence')->get();
    }
}

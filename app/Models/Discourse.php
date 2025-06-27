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
        'is_active',
        'is_upcoming',
        'expected_release_date',
        'price',
        'slug',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_upcoming' => 'boolean',
        'expected_release_date' => 'date',
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
                $discourse->slug = $discourse->generateUniqueSlug($discourse->title);
            }
        });

        static::updating(function ($discourse) {
            // If title changed but slug didn't, update the slug
            if ($discourse->isDirty('title') && !$discourse->isDirty('slug')) {
                $discourse->slug = $discourse->generateUniqueSlug($discourse->title);
            }
        });

        // Delete all related videos when a discourse is deleted
        static::deleting(function ($discourse) {
            $discourse->videos()->delete();
        });
    }

    /**
     * Generate a unique slug for the discourse.
     *
     * @param string $title
     * @return string
     */
    protected function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        // Check if the slug already exists
        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
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

    // Free preview functionality has been removed
}

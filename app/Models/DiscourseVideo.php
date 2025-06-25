<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscourseVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'discourse_id',
        'title',
        'description',
        'youtube_video_id',
        'sequence',
        'is_free_preview',
        'is_active',
        'duration_seconds',
    ];

    protected $casts = [
        'is_free_preview' => 'boolean',
        'is_active' => 'boolean',
        'duration_seconds' => 'integer',
        'sequence' => 'integer',
    ];

    /**
     * Get the discourse that owns the video.
     */
    public function discourse(): BelongsTo
    {
        return $this->belongsTo(Discourse::class);
    }

    /**
     * Get the user progress records for this video.
     */
    public function userProgress()
    {
        return $this->hasMany(UserVideoProgress::class);
    }

    /**
     * Format the video duration as a human-readable string.
     */
    public function getFormattedDurationAttribute(): string
    {
        if (!$this->duration_seconds) {
            return '--:--';
        }

        $minutes = floor($this->duration_seconds / 60);
        $seconds = $this->duration_seconds % 60;

        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    /**
     * Generate the secure embed URL for this video.
     */
    public function getEmbedUrl(): string
    {
        return 'https://www.youtube.com/embed/' . $this->youtube_video_id;
    }
}

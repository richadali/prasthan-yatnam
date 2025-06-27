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
        'youtube_video_id',
        'sequence',
        'duration_seconds',
    ];

    protected $casts = [
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

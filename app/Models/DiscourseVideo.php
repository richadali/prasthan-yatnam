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
        'video_path',
        'video_filename',
        'mime_type',
        'file_size',
        'is_processed',
        'sequence',
        'duration_seconds',
    ];

    protected $casts = [
        'duration_seconds' => 'integer',
        'sequence' => 'integer',
        'is_processed' => 'boolean',
        'file_size' => 'integer',
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
     * Get the video URL
     */
    public function getVideoUrl(): string
    {
        // Use the secure streaming route for paid content
        // or direct access for free content
        $discourse = $this->discourse;

        if ($discourse && $discourse->price > 0) {
            return route('video.stream', ['id' => $this->id]);
        }

        return asset('storage/' . $this->video_path);
    }

    /**
     * Get the video thumbnail URL
     */
    public function getThumbnailUrl(): string
    {
        // Use the discourse's thumbnail
        $discourse = $this->discourse;

        if ($discourse && $discourse->thumbnail) {
            return $discourse->getThumbnailUrl();
        }

        // Default thumbnail
        return asset('images/video-placeholder.jpg');
    }
}

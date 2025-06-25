<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserVideoProgress extends Model
{
    use HasFactory;

    protected $table = 'user_video_progress';

    protected $fillable = [
        'user_id',
        'discourse_video_id',
        'current_position_seconds',
        'completed',
        'last_watched_at',
    ];

    protected $casts = [
        'current_position_seconds' => 'integer',
        'completed' => 'boolean',
        'last_watched_at' => 'datetime',
    ];

    /**
     * Get the user that owns the progress record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the video that the progress is for.
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(DiscourseVideo::class, 'discourse_video_id');
    }

    /**
     * Format the current position as a human-readable string.
     */
    public function getFormattedPositionAttribute(): string
    {
        if (!$this->current_position_seconds) {
            return '00:00';
        }

        $minutes = floor($this->current_position_seconds / 60);
        $seconds = $this->current_position_seconds % 60;

        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    /**
     * Calculate progress percentage.
     */
    public function getProgressPercentageAttribute(): int
    {
        if (!$this->video || !$this->video->duration_seconds || $this->video->duration_seconds == 0) {
            return 0;
        }

        $percentage = ($this->current_position_seconds / $this->video->duration_seconds) * 100;
        return min(100, (int)$percentage);
    }
}

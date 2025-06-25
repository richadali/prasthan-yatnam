<?php

namespace App\Http\Controllers;

use App\Models\Discourse;
use App\Models\DiscourseVideo;
use App\Models\UserVideoProgress;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    /**
     * Display a video player for the specified video.
     * This method is protected by auth middleware in routes/web.php
     */
    public function show($discourse_slug, $video_id)
    {
        // Find the discourse and video
        $discourse = Discourse::where('slug', $discourse_slug)
            ->where('is_active', true)
            ->firstOrFail();

        $video = DiscourseVideo::where('id', $video_id)
            ->where('discourse_id', $discourse->id)
            ->where('is_active', true)
            ->firstOrFail();

        // Check if user has access to the video
        $user = Auth::user();
        $hasAccess = $video->is_free_preview || $this->checkUserAccess($user, $discourse);

        if (!$hasAccess) {
            return redirect()->route('discourses.show', $discourse->slug)
                ->with('error', 'You need to enroll in this discourse to access this video.');
        }

        // Get user's progress for this video
        $progress = UserVideoProgress::firstOrNew([
            'user_id' => $user->id,
            'discourse_video_id' => $video->id,
        ]);

        // Update last watched timestamp
        $progress->last_watched_at = Carbon::now();
        $progress->save();

        // Get next and previous videos in sequence
        $nextVideo = DiscourseVideo::where('discourse_id', $discourse->id)
            ->where('sequence', '>', $video->sequence)
            ->where('is_active', true)
            ->orderBy('sequence')
            ->first();

        $prevVideo = DiscourseVideo::where('discourse_id', $discourse->id)
            ->where('sequence', '<', $video->sequence)
            ->where('is_active', true)
            ->orderBy('sequence', 'desc')
            ->first();

        return view('videos.show', compact('discourse', 'video', 'progress', 'nextVideo', 'prevVideo'));
    }

    /**
     * Display a free preview video.
     */
    public function preview($discourse_slug, $video_id)
    {
        // Find the discourse and video
        $discourse = Discourse::where('slug', $discourse_slug)
            ->where('is_active', true)
            ->firstOrFail();

        $video = DiscourseVideo::where('id', $video_id)
            ->where('discourse_id', $discourse->id)
            ->where('is_active', true)
            ->where('is_free_preview', true) // Must be a free preview
            ->firstOrFail();

        // Track progress if user is logged in
        $progress = null;
        if (Auth::check()) {
            $user = Auth::user();
            $progress = UserVideoProgress::firstOrNew([
                'user_id' => $user->id,
                'discourse_video_id' => $video->id,
            ]);

            $progress->last_watched_at = Carbon::now();
            $progress->save();
        }

        return view('videos.preview', compact('discourse', 'video', 'progress'));
    }

    /**
     * Update video progress via AJAX.
     * This method is protected by auth middleware in routes/web.php
     */
    public function updateProgress(Request $request, $video_id)
    {
        $video = DiscourseVideo::findOrFail($video_id);
        $user = Auth::user();

        // Verify user has access to this video
        $discourse = $video->discourse;
        $hasAccess = $video->is_free_preview || $this->checkUserAccess($user, $discourse);

        if (!$hasAccess) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validate request
        $validated = $request->validate([
            'current_position' => 'required|integer|min:0',
            'completed' => 'boolean',
        ]);

        // Update or create progress record
        $progress = UserVideoProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'discourse_video_id' => $video->id,
            ],
            [
                'current_position_seconds' => $validated['current_position'],
                'completed' => $request->input('completed', false),
                'last_watched_at' => Carbon::now(),
            ]
        );

        return response()->json([
            'success' => true,
            'progress' => $progress->current_position_seconds,
            'percentage' => $progress->getProgressPercentageAttribute(),
        ]);
    }

    /**
     * Check if user has access to the discourse.
     */
    private function checkUserAccess($user, $discourse)
    {
        return $user->enrolledDiscourses()
            ->where('discourse_id', $discourse->id)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->exists();
    }
}

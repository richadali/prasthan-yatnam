<?php

namespace App\Http\Controllers;

use App\Models\Discourse;
use App\Models\DiscourseVideo;
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
            ->firstOrFail();

        // Check if user has access to the video
        $user = Auth::user();
        $hasAccess = $this->checkUserAccess($user, $discourse);

        if (!$hasAccess) {
            return redirect()->route('discourses.show', $discourse->slug)
                ->with('error', 'You need to enroll in this discourse to access this video.');
        }

        // Get next and previous videos in sequence
        $nextVideo = DiscourseVideo::where('discourse_id', $discourse->id)
            ->where('sequence', '>', $video->sequence)
            ->orderBy('sequence')
            ->first();

        $prevVideo = DiscourseVideo::where('discourse_id', $discourse->id)
            ->where('sequence', '<', $video->sequence)
            ->orderBy('sequence', 'desc')
            ->first();

        return view('videos.show', compact('discourse', 'video', 'nextVideo', 'prevVideo'));
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

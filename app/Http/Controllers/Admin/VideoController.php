<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discourse;
use App\Models\DiscourseVideo;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of videos for a discourse.
     */
    public function index(Discourse $discourse)
    {
        $videos = $discourse->videos()->orderBy('sequence')->paginate(10);
        return view('admin.videos.index', compact('discourse', 'videos'));
    }

    /**
     * Show the form for creating a new video.
     */
    public function create(Discourse $discourse)
    {
        return view('admin.videos.create', compact('discourse'));
    }

    /**
     * Store a newly created video in storage.
     */
    public function store(Request $request, Discourse $discourse)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_video_id' => 'required|string|max:20',
            'sequence' => 'nullable|integer|min:0',
            'is_free_preview' => 'boolean',
            'is_active' => 'boolean',
            'duration_seconds' => 'nullable|integer|min:0',
        ]);

        // Set boolean fields
        $validated['is_free_preview'] = $request->has('is_free_preview');
        $validated['is_active'] = $request->has('is_active');

        // Set sequence to last if not provided
        if (empty($validated['sequence'])) {
            $lastSequence = $discourse->videos()->max('sequence') ?? -1;
            $validated['sequence'] = $lastSequence + 1;
        }

        // Create the video
        $discourse->videos()->create($validated);

        return redirect()->route('admin.discourses.videos.index', $discourse)
            ->with('success', 'Video added successfully.');
    }

    /**
     * Show the form for editing the specified video.
     */
    public function edit(Discourse $discourse, DiscourseVideo $video)
    {
        return view('admin.videos.edit', compact('discourse', 'video'));
    }

    /**
     * Update the specified video in storage.
     */
    public function update(Request $request, Discourse $discourse, DiscourseVideo $video)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_video_id' => 'required|string|max:20',
            'sequence' => 'required|integer|min:0',
            'is_free_preview' => 'boolean',
            'is_active' => 'boolean',
            'duration_seconds' => 'nullable|integer|min:0',
        ]);

        // Set boolean fields
        $validated['is_free_preview'] = $request->has('is_free_preview');
        $validated['is_active'] = $request->has('is_active');

        $video->update($validated);

        return redirect()->route('admin.discourses.videos.index', $discourse)
            ->with('success', 'Video updated successfully.');
    }

    /**
     * Remove the specified video from storage.
     */
    public function destroy(Discourse $discourse, DiscourseVideo $video)
    {
        $video->delete();

        return redirect()->route('admin.discourses.videos.index', $discourse)
            ->with('success', 'Video deleted successfully.');
    }

    /**
     * Reorder videos.
     */
    public function reorder(Request $request, Discourse $discourse)
    {
        $request->validate([
            'videos' => 'required|array',
            'videos.*' => 'exists:discourse_videos,id',
        ]);

        $videos = $request->input('videos');

        foreach ($videos as $index => $videoId) {
            DiscourseVideo::where('id', $videoId)->update(['sequence' => $index]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Fetch video details from YouTube.
     */
    public function fetchYouTubeDetails(Request $request)
    {
        $request->validate([
            'youtube_video_id' => 'required|string|max:20',
        ]);

        $videoId = $request->input('youtube_video_id');

        // In a real implementation, you would use YouTube API to fetch details
        // For now, we'll return a mock response
        return response()->json([
            'title' => 'YouTube Video Title',
            'description' => 'YouTube video description would appear here.',
            'duration_seconds' => 300, // 5 minutes
        ]);
    }
}

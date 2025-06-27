<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discourse;
use App\Models\DiscourseVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            'youtube_video_id' => 'required|string|max:20',
            'sequence' => 'nullable|integer|min:0',
            'duration_seconds' => 'nullable|integer|min:0',
        ]);

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
            'youtube_video_id' => 'required|string|max:20',
            'sequence' => 'required|integer|min:0',
            'duration_seconds' => 'nullable|integer|min:0',
        ]);

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
     * Fetch YouTube video details
     */
    public function fetchYouTubeDetails(Request $request)
    {
        $request->validate([
            'youtube_video_id' => 'required|string|max:20',
        ]);

        $videoId = $request->youtube_video_id;

        try {
            // Check if we have a YouTube API key in config
            $apiKey = config('services.youtube.api_key');

            if (!$apiKey) {
                return response()->json([
                    'error' => 'YouTube API key is not configured. Please add YOUTUBE_API_KEY to your .env file.'
                ], 400);
            }

            // Use YouTube API to get video details
            // Disable SSL verification in local environment to avoid certificate issues
            $httpOptions = [];
            if (app()->environment('local')) {
                $httpOptions['verify'] = false;
            }

            $response = Http::withOptions($httpOptions)->get('https://www.googleapis.com/youtube/v3/videos', [
                'part' => 'snippet,contentDetails',
                'id' => $videoId,
                'key' => $apiKey
            ]);

            if (!$response->successful()) {
                return response()->json([
                    'error' => 'YouTube API request failed. Please check your API key and quota limits.'
                ], 400);
            }

            if (empty($response->json()['items'])) {
                return response()->json([
                    'error' => 'Video not found. Please check the YouTube URL.'
                ], 404);
            }

            $videoData = $response->json()['items'][0];
            $title = $videoData['snippet']['title'] ?? '';

            // Parse duration from format like "PT1H30M15S" to seconds
            $durationString = $videoData['contentDetails']['duration'] ?? 'PT0S';
            $duration = $this->parseDuration($durationString);

        return response()->json([
                'title' => $title,
                'duration_seconds' => $duration,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching YouTube video details: ' . $e->getMessage());

            // Provide more helpful error message for SSL issues
            if (strpos($e->getMessage(), 'SSL certificate problem') !== false) {
                return response()->json([
                    'error' => 'SSL certificate issue detected. This is a local development environment issue, not a problem with your API key.',
                    'solution' => 'The API call has been updated to ignore SSL verification in local environments. Please try again.'
                ], 500);
            }

            return response()->json([
                'error' => 'Error connecting to YouTube API: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Convert YouTube duration format (ISO 8601) to seconds
     * Handles format like PT1H30M15S (1 hour, 30 minutes, 15 seconds)
     */
    private function parseDuration($durationString)
    {
        $pattern = '/PT(?:(\d+)H)?(?:(\d+)M)?(?:(\d+)S)?/';
        preg_match($pattern, $durationString, $matches);

        $hours = !empty($matches[1]) ? (int)$matches[1] : 0;
        $minutes = !empty($matches[2]) ? (int)$matches[2] : 0;
        $seconds = !empty($matches[3]) ? (int)$matches[3] : 0;

        return $hours * 3600 + $minutes * 60 + $seconds;
    }
}

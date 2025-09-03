<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discourse;
use App\Models\DiscourseVideo;
use App\Services\VideoProcessingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
            'video_file' => 'required|file|mimes:mp4,mov,avi,wmv|max:1048576', // 1GB max
            'video_path' => 'nullable|string',
            'video_filename' => 'nullable|string',
            'mime_type' => 'nullable|string',
            'file_size' => 'nullable|integer',
            'is_processed' => 'nullable|boolean',
            'sequence' => 'nullable|integer|min:0',
            'duration_seconds' => 'nullable|integer|min:0',
        ]);

        // Set sequence to last if not provided
        if (empty($validated['sequence'])) {
            $lastSequence = $discourse->videos()->max('sequence') ?? -1;
            $validated['sequence'] = $lastSequence + 1;
        }

        // Create the video
        $video = $discourse->videos()->create($validated);

        // Process video file with increased timeout
        set_time_limit(900); // 15 minutes timeout for large files
        ini_set('max_execution_time', 900);
        ini_set('max_input_time', 900);

        // Store the file information in the database first
        $file = $request->file('video_file');
        if ($file) {
            try {
                // Log the start of upload process
                \Log::info('Starting video upload', [
                    'filename' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'discourse_id' => $discourse->id
                ]);

                // Update video with file info
                $video->video_filename = $file->getClientOriginalName();
                $video->mime_type = $file->getMimeType();
                $video->file_size = $file->getSize();
                $video->save();

                // Process the video
                $videoProcessingService = new VideoProcessingService();
                $success = $videoProcessingService->processVideo($file, $video);

                if (!$success) {
                    // If upload failed, delete the video and return with error
                    $video->delete();
                    return redirect()->back()->withErrors(['video_file' => 'Failed to upload video file.'])->withInput();
                }

                \Log::info('Video upload completed successfully', [
                    'filename' => $file->getClientOriginalName(),
                    'discourse_id' => $discourse->id
                ]);
            } catch (\Exception $e) {
                \Log::error('Video upload error: ' . $e->getMessage(), [
                    'file' => $file->getClientOriginalName(),
                    'exception' => $e
                ]);
                $video->delete();
                return redirect()->back()->withErrors(['video_file' => 'Error during video upload: ' . $e->getMessage()])->withInput();
            }
        }

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
            'video_file' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:1048576', // 1GB max
            'video_path' => 'nullable|string',
            'video_filename' => 'nullable|string',
            'mime_type' => 'nullable|string',
            'file_size' => 'nullable|integer',
            'is_processed' => 'nullable|boolean',
            'sequence' => 'required|integer|min:0',
            'duration_seconds' => 'nullable|integer|min:0',
        ]);

        // Update the video
        $video->update($validated);

        // Process new video file if uploaded
        if ($request->hasFile('video_file')) {
            // Delete old video if it exists
            if ($video->video_path) {
                Storage::delete('public/' . $video->video_path);
            }

            try {
                // Set longer timeout
                set_time_limit(900); // 15 minutes
                ini_set('max_execution_time', 900);
                ini_set('max_input_time', 900);

                \Log::info('Starting video update', [
                    'filename' => $request->file('video_file')->getClientOriginalName(),
                    'video_id' => $video->id
                ]);

                $videoProcessingService = new VideoProcessingService();
                $success = $videoProcessingService->processVideo($request->file('video_file'), $video);

                if (!$success) {
                    return redirect()->back()->withErrors(['video_file' => 'Failed to upload video file.'])->withInput();
                }

                \Log::info('Video update completed successfully', [
                    'video_id' => $video->id
                ]);
            } catch (\Exception $e) {
                \Log::error('Video update error: ' . $e->getMessage(), [
                    'file' => $request->file('video_file')->getClientOriginalName(),
                    'exception' => $e
                ]);
                return redirect()->back()->withErrors(['video_file' => 'Error during video upload: ' . $e->getMessage()])->withInput();
            }
        }

        return redirect()->route('admin.discourses.videos.index', $discourse)
            ->with('success', 'Video updated successfully.');
    }

    /**
     * Remove the specified video from storage.
     */
    public function destroy(Discourse $discourse, DiscourseVideo $video)
    {
        // Delete video file if it exists
        if ($video->video_path) {
            Storage::delete('public/' . $video->video_path);
        }

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
}

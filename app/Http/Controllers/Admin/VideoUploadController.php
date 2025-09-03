<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discourse;
use App\Models\DiscourseVideo;
use App\Services\VideoProcessingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoUploadController extends Controller
{
    /**
     * Show the upload form for testing large file uploads
     */
    public function showUploadForm()
    {
        $discourses = Discourse::where('is_active', true)->orderBy('title')->get();
        return view('admin.videos.upload-form', compact('discourses'));
    }

    /**
     * Handle chunked video upload
     */
    public function uploadChunk(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'upload_id' => 'required|string',
            'chunk_index' => 'required|integer',
            'total_chunks' => 'required|integer',
        ]);

        $file = $request->file('file');
        $uploadId = $request->input('upload_id');
        $chunkIndex = $request->input('chunk_index');

        $tempDir = storage_path('app/temp/' . $uploadId);
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $file->move($tempDir, $chunkIndex);

        return response()->json(['success' => true]);
    }

    public function finalize(Request $request)
    {
        Log::info('Finalize method called.');
        Log::info('Request data:', $request->all());

        $request->validate([
            'upload_id' => 'required|string',
            'filename' => 'required|string',
            'total_size' => 'required|integer',
            'discourse_id' => 'required|exists:discourses,id',
            'title' => 'required|string|max:255',
            'sequence' => 'nullable|integer|min:0',
            'duration_seconds' => 'nullable|integer|min:0',
        ]);

        $uploadId = $request->input('upload_id');
        $filename = time() . '_' . $request->input('filename');
        $discourseId = $request->input('discourse_id');
        $title = $request->input('title');
        $sequence = $request->input('sequence', 0);
        $duration_seconds = $request->input('duration_seconds', 0);

        $tempDir = storage_path('app/temp/' . $uploadId);
        $finalPath = storage_path('app/public/videos/' . $filename);

        Log::info('Combining chunks from ' . $tempDir . ' to ' . $finalPath);
        $this->combineChunks($tempDir, $finalPath);
        Log::info('Chunks combined successfully.');

        $discourse = Discourse::findOrFail($discourseId);
        $video = new DiscourseVideo([
            'discourse_id' => $discourseId,
            'title' => $title,
            'video_path' => 'videos/' . $filename,
            'video_filename' => $filename,
            'mime_type' => mime_content_type($finalPath),
            'file_size' => filesize($finalPath),
            'sequence' => $sequence,
            'duration_seconds' => $duration_seconds,
            'is_processed' => false,
        ]);
        $video->save();
        Log::info('DiscourseVideo record created with ID: ' . $video->id);

        return response()->json([
            'success' => true,
            'message' => 'Video uploaded successfully',
            'video_id' => $video->id
        ]);
    }

    private function combineChunks($tempDir, $finalPath)
    {
        $chunks = array_diff(scandir($tempDir), ['.', '..']);
        sort($chunks, SORT_NUMERIC);

        $finalHandle = fopen($finalPath, 'w');

        foreach ($chunks as $chunk) {
            $chunkPath = $tempDir . '/' . $chunk;
            $chunkHandle = fopen($chunkPath, 'r');
            stream_copy_to_stream($chunkHandle, $finalHandle);
            fclose($chunkHandle);
            unlink($chunkPath);
        }

        fclose($finalHandle);
        rmdir($tempDir);
    }

    /**
     * Check upload progress (placeholder for now)
     */
    public function progress(Request $request)
    {
        // In a real implementation, this would check the actual upload progress
        // For now, we'll just return a placeholder response
        return response()->json([
            'progress' => 100,
            'status' => 'complete'
        ]);
    }
}

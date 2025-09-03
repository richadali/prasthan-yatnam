<?php

namespace App\Http\Controllers;

use App\Models\DiscourseVideo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VideoController extends Controller
{
    public function show($discourse_slug, $video_id)
    {
        $video = DiscourseVideo::with('discourse')->findOrFail($video_id);
        $discourse = $video->discourse;

        // Check if user has access
        $hasAccess = false;
        if (Auth::check()) {
            $user = Auth::user();
            $hasAccess = $user->enrolledDiscourses()->where('discourse_id', $discourse->id)->exists();
        }

        if (!$hasAccess && $discourse->price > 0) {
            return redirect()->route('discourses.show', $discourse->slug)
                ->with('error', 'You must be enrolled in this discourse to watch this video.');
        }

        // Get previous and next videos
        $prevVideo = $discourse->videos()->where('sequence', '<', $video->sequence)->orderBy('sequence', 'desc')->first();
        $nextVideo = $discourse->videos()->where('sequence', '>', $video->sequence)->orderBy('sequence')->first();

        return view('videos.show', compact('discourse', 'video', 'prevVideo', 'nextVideo'));
    }

    /**
     * Stream a video securely
     * This method checks if the user has purchased the discourse
     * before streaming the video
     */
    public function stream(Request $request, $id)
    {
        $video = DiscourseVideo::with('discourse')->findOrFail($id);
        $discourse = $video->discourse;

        // Free videos can be accessed by any authenticated user
        if ($discourse->price <= 0) {
            return $this->streamVideo($video);
        }

        // For paid videos, check if the user has purchased the discourse
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if the user has purchased this discourse
        // Assuming there's a pivot table user_discourses with user_id and discourse_id
        $hasPurchased = $user->enrolledDiscourses()->where('discourse_id', $discourse->id)->exists();

        if (!$hasPurchased) {
            abort(403, 'You need to purchase this discourse to access this video.');
        }

        return $this->streamVideo($video);
    }

    /**
     * Stream the video file
     */
    private function streamVideo(DiscourseVideo $video): StreamedResponse
    {
        if (!$video->video_path || !Storage::disk('public')->exists($video->video_path)) {
            abort(404, 'Video file not found.');
        }

        $filePath = Storage::disk('public')->path($video->video_path);
        $fileSize = $video->file_size ?: filesize($filePath);
        $fileName = $video->video_filename ?: basename($filePath);
        $mimeType = $video->mime_type ?: 'video/mp4';

        // Handle range requests for video seeking
        $headers = [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
            'Accept-Ranges' => 'bytes',
            'X-Pad' => 'avoid browser bug',
            'Pragma' => 'public',
            'Cache-Control' => 'max-age=86400, public',
            'Expires' => gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT',
        ];

        // Handle range requests
        $range = request()->header('Range');
        if ($range) {
            return $this->handleRangeRequest($filePath, $fileSize, $range, $mimeType);
        }

        // Standard request
        $headers['Content-Length'] = $fileSize;

        return response()->stream(function () use ($filePath) {
            $file = fopen($filePath, 'rb');
            fpassthru($file);
            fclose($file);
        }, 200, $headers);
    }

    /**
     * Handle range requests for video seeking
     */
    private function handleRangeRequest(string $filePath, int $fileSize, string $range, string $mimeType): StreamedResponse
    {
        $end = $fileSize - 1;
        $start = 0;

        // Parse the range header
        if (preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $range, $matches)) {
            $start = (int) $matches[1];

            if (!empty($matches[2])) {
                $end = (int) $matches[2];
            }
        }

        // Set the headers for a partial response
        $length = $end - $start + 1;
        $headers = [
            'Content-Type' => $mimeType,
            'Content-Range' => "bytes $start-$end/$fileSize",
            'Accept-Ranges' => 'bytes',
            'Content-Length' => $length,
            'X-Pad' => 'avoid browser bug',
            'Pragma' => 'public',
            'Cache-Control' => 'max-age=86400, public',
            'Expires' => gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT',
        ];

        // Return the partial content
        return response()->stream(function () use ($filePath, $start, $end) {
            $file = fopen($filePath, 'rb');
            fseek($file, $start);
            $buffer = 1024 * 8;
            $currentPosition = $start;

            while (!feof($file) && $currentPosition <= $end) {
                // Don't read more than the specified end
                $bytesToRead = min($buffer, $end - $currentPosition + 1);
                echo fread($file, $bytesToRead);
                $currentPosition += $bytesToRead;
                flush();
            }

            fclose($file);
        }, 206, $headers);
    }
}

<?php

namespace App\Services;

use App\Models\DiscourseVideo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoProcessingService
{
    /**
     * Process and store an uploaded video file
     * 
     * This simplified version stores the video as-is without FFmpeg processing
     */
    public function processVideo(UploadedFile $file, DiscourseVideo $video): bool
    {
        try {
            // Set longer timeout for large files
            set_time_limit(600); // 10 minutes

            // Generate a unique filename
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '_' . time() . '.' . $extension;

            // Create output directory if it doesn't exist
            $outputDir = 'public/videos/' . $video->discourse_id;
            if (!Storage::exists($outputDir)) {
                Storage::makeDirectory($outputDir);
            }

            // Log the start of upload
            Log::info('Starting video upload', [
                'filename' => $filename,
                'size' => $file->getSize(),
                'discourse_id' => $video->discourse_id
            ]);

            // Store the file directly with stream to handle large files better
            $outputPath = $outputDir . '/' . $filename;

            // Use stream copy to handle large files
            $stream = fopen($file->getRealPath(), 'r');
            Storage::put($outputPath, $stream);
            if (is_resource($stream)) {
                fclose($stream);
            }

            // Log successful upload
            Log::info('Video upload completed', [
                'filename' => $filename,
                'path' => $outputPath
            ]);

            // Update the video model
            $video->video_path = str_replace('public/', '', $outputPath);
            $video->video_filename = $filename;
            $video->is_processed = true;
            $video->save();

            return true;
        } catch (\Exception $e) {
            Log::error('Video processing error: ' . $e->getMessage(), [
                'file' => $file->getClientOriginalName(),
                'exception' => $e
            ]);
            return false;
        }
    }
}

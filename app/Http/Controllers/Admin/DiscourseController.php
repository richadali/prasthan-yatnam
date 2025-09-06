<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discourse;
use App\Models\DiscourseVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class DiscourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discourses = Discourse::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.discourses.index', compact('discourses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.discourses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate(
                [
                    'title' => 'required|string|max:255',
                    'description' => 'required|string',
                    'thumbnail' => 'nullable|image|max:51200',
                    'price' => 'required|numeric|min:0',
                    'is_active' => 'boolean',
                    'is_upcoming' => 'boolean',
                    'expected_release_date' => 'nullable|date',
                    'slug' => 'nullable|string|unique:discourses,slug',
                ],
                [
                    'slug.unique' => 'A discourse with this title already exists. Please choose a different title.',
                ]
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', $e->errors());
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        }

        // Handle boolean fields
        $validated['is_active'] = $request->has('is_active');
        $validated['is_upcoming'] = $request->has('is_upcoming');

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            try {
                $path = $request->file('thumbnail')->store('thumbnails', 'public');
                $validated['thumbnail'] = $path;
                Log::info('Discourse thumbnail uploaded successfully', ['path' => $path]);
            } catch (\Exception $e) {
                Log::error('Thumbnail upload failed', ['error' => $e->getMessage()]);
                return redirect()->back()
                    ->with('error', 'Error uploading thumbnail: ' . $e->getMessage())
                    ->withInput();
            }
        }

        // Create the discourse
        $discourse = Discourse::create($validated);

        // Handle videos if any
        if ($request->has('videos')) {
            foreach ($request->videos as $index => $videoData) {
                // Check if a video file was uploaded
                if ($request->hasFile("videos.{$index}.video_file")) {
                    $file = $request->file("videos.{$index}.video_file");
                    $path = $file->store('videos', 'public');

                    $discourse->videos()->create([
                        'title' => $videoData['title'],
                        'video_path' => $path,
                        'video_filename' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                        'is_processed' => false,
                        'sequence' => $videoData['sequence'] ?? $index,
                        'duration_seconds' => $videoData['duration_seconds'] ?? null,
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Discourse created successfully.',
            'discourse_id' => $discourse->id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Discourse $discourse)
    {
        return view('admin.discourses.show', compact('discourse'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discourse $discourse)
    {
        return view('admin.discourses.edit', compact('discourse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discourse $discourse)
    {
        try {
            $validated = $request->validate(
                [
                    'title' => 'required|string|max:255',
                    'description' => 'required|string',
                    'thumbnail' => 'nullable|image|max:51200',
                    'price' => 'required|numeric|min:0',
                    'is_active' => 'boolean',
                    'is_upcoming' => 'boolean',
                    'expected_release_date' => 'nullable|date',
                    'slug' => 'nullable|string|unique:discourses,slug,' . $discourse->id,
                ],
                [
                    'slug.unique' => 'A discourse with this title already exists. Please choose a different title.',
                ]
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        }

        // Handle boolean fields
        $validated['is_active'] = $request->has('is_active');
        $validated['is_upcoming'] = $request->has('is_upcoming');

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            try {
                // Delete the old thumbnail if it exists
                if ($discourse->thumbnail) {
                    Storage::disk('public')->delete($discourse->thumbnail);
                    Log::info('Deleted old thumbnail', ['path' => $discourse->thumbnail]);
                }

                $path = $request->file('thumbnail')->store('thumbnails', 'public');
                $validated['thumbnail'] = $path;
                Log::info('New thumbnail uploaded', ['path' => $path]);
            } catch (\Exception $e) {
                Log::error('Thumbnail upload failed during update', ['error' => $e->getMessage()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Error uploading thumbnail: ' . $e->getMessage()
                ], 500);
            }
        }

        // Update the discourse
        $discourse->update($validated);

        // Handle videos if any
        if ($request->has('videos')) {
            foreach ($request->videos as $index => $videoData) {
                if ($request->hasFile("videos.{$index}.video_file")) {
                    $file = $request->file("videos.{$index}.video_file");
                    $path = $file->store('videos', 'public');

                    $discourse->videos()->updateOrCreate(
                        ['id' => $videoData['id'] ?? null],
                        [
                            'title' => $videoData['title'],
                            'video_path' => $path,
                            'video_filename' => $file->getClientOriginalName(),
                            'mime_type' => $file->getMimeType(),
                            'file_size' => $file->getSize(),
                            'is_processed' => false,
                            'sequence' => $videoData['sequence'] ?? $index,
                            'duration_seconds' => $videoData['duration_seconds'] ?? null,
                        ]
                    );
                } elseif (isset($videoData['id'])) {
                    $video = DiscourseVideo::find($videoData['id']);
                    if ($video) {
                        $video->update([
                            'title' => $videoData['title'],
                            'sequence' => $videoData['sequence'] ?? $index,
                            'duration_seconds' => $videoData['duration_seconds'] ?? null,
                        ]);
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Discourse updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discourse $discourse)
    {
        // Delete thumbnail if exists
        if ($discourse->thumbnail) {
            Storage::disk('public')->delete($discourse->thumbnail);
            Log::info('Deleted discourse thumbnail', ['path' => $discourse->thumbnail]);
        }

        // Delete all related videos (will cascade delete through the model boot method)
        $discourse->delete();

        return redirect()->route('admin.discourses.index')
            ->with('success', 'Discourse deleted successfully.');
    }
}

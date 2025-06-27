<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DiscourseController extends Controller
{
    /**
     * Display a listing of the discourses.
     */
    public function index()
    {
        $discourses = Discourse::with('videos')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.discourses.index', compact('discourses'));
    }

    /**
     * Show the form for creating a new discourse.
     */
    public function create()
    {
        return view('admin.discourses.create');
    }

    /**
     * Store a newly created discourse in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'is_upcoming' => 'boolean',
            'expected_release_date' => 'nullable|date',
            'price' => 'nullable|numeric|min:0',
            'slug' => 'nullable|string|max:255|unique:discourses,slug',
            'videos.*.title' => 'nullable|string|max:255',
            'videos.*.youtube_video_id' => 'nullable|string|max:20',
            'videos.*.sequence' => 'nullable|integer|min:0',
            'videos.*.duration_seconds' => 'nullable|integer|min:0',
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $filename = time() . '_' . $thumbnailFile->getClientOriginalName();

            // Store in public disk instead of using the 'public' prefix
            $thumbnailPath = Storage::disk('public')->putFileAs(
                'images/discourses',
                $thumbnailFile,
                $filename
            );

            $validated['thumbnail'] = $thumbnailPath;
        }

        // Set is_active to true by default if not provided
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : true;

        // Set is_upcoming to false by default if not provided
        $validated['is_upcoming'] = $request->has('is_upcoming') ? $request->boolean('is_upcoming') : false;

        // Set price to 0 if not provided
        $validated['price'] = $validated['price'] ?? 0;

        // Create the discourse
        $discourse = Discourse::create($validated);

        // Process videos if they exist in the request
        if ($request->has('videos')) {
            foreach ($request->videos as $videoData) {
                if (!empty($videoData['youtube_video_id'])) {
                    $discourse->videos()->create([
                        'title' => $videoData['title'],
                        'youtube_video_id' => $videoData['youtube_video_id'],
                        'sequence' => $videoData['sequence'] ?? 0,
                        'duration_seconds' => $videoData['duration_seconds'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.discourses.index')
            ->with('success', 'Discourse created successfully.');
    }

    /**
     * Display the specified discourse.
     */
    public function show(Discourse $discourse)
    {
        return view('admin.discourses.show', compact('discourse'));
    }

    /**
     * Show the form for editing the specified discourse.
     */
    public function edit(Discourse $discourse)
    {
        return view('admin.discourses.edit', compact('discourse'));
    }

    /**
     * Update the specified discourse in storage.
     */
    public function update(Request $request, Discourse $discourse)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'is_upcoming' => 'boolean',
            'expected_release_date' => 'nullable|date',
            'price' => 'nullable|numeric|min:0',
            'slug' => 'nullable|string|max:255|unique:discourses,slug,' . $discourse->id,
            'videos.*.id' => 'nullable|exists:discourse_videos,id',
            'videos.*.title' => 'nullable|string|max:255',
            'videos.*.youtube_video_id' => 'nullable|string|max:20',
            'videos.*.sequence' => 'nullable|integer|min:0',
            'videos.*.duration_seconds' => 'nullable|integer|min:0',
            'delete_videos.*' => 'nullable|exists:discourse_videos,id',
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($discourse->thumbnail) {
                Storage::disk('public')->delete($discourse->thumbnail);
            }

            $thumbnailFile = $request->file('thumbnail');
            $filename = time() . '_' . $thumbnailFile->getClientOriginalName();

            // Store in public disk instead of using the 'public' prefix
            $thumbnailPath = Storage::disk('public')->putFileAs(
                'images/discourses',
                $thumbnailFile,
                $filename
            );

            $validated['thumbnail'] = $thumbnailPath;
        }

        // Set boolean fields
        $validated['is_active'] = $request->has('is_active');
        $validated['is_upcoming'] = $request->has('is_upcoming');

        // Set price to 0 if not provided
        $validated['price'] = $validated['price'] ?? 0;

        $discourse->update($validated);

        // Process videos if they exist in the request
        if ($request->has('videos')) {
            foreach ($request->videos as $videoData) {
                if (!empty($videoData['youtube_video_id'])) {
                    // If video has an ID, update it
                    if (!empty($videoData['id'])) {
                        $discourse->videos()->where('id', $videoData['id'])->update([
                            'title' => $videoData['title'],
                            'youtube_video_id' => $videoData['youtube_video_id'],
                            'sequence' => $videoData['sequence'] ?? 0,
                            'duration_seconds' => $videoData['duration_seconds'] ?? null,
                        ]);
                    } else {
                        // Otherwise create a new video
                        $discourse->videos()->create([
                            'title' => $videoData['title'],
                            'youtube_video_id' => $videoData['youtube_video_id'],
                            'sequence' => $videoData['sequence'] ?? 0,
                            'duration_seconds' => $videoData['duration_seconds'] ?? null,
                        ]);
                    }
                }
            }
        }

        // Delete videos if requested
        if ($request->has('delete_videos')) {
            $discourse->videos()->whereIn('id', $request->delete_videos)->delete();
        }

        return redirect()->route('admin.discourses.index')
            ->with('success', 'Discourse updated successfully.');
    }

    /**
     * Remove the specified discourse from storage.
     */
    public function destroy(Discourse $discourse)
    {
        // Delete thumbnail if exists
        if ($discourse->thumbnail) {
            Storage::disk('public')->delete($discourse->thumbnail);
        }

        $discourse->delete();

        return redirect()->route('admin.discourses.index')
            ->with('success', 'Discourse deleted successfully.');
    }
}

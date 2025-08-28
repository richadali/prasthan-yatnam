<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $albums = Album::orderBy('sort_order')->get();
        return view('admin.albums.index', compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.albums.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->except('cover_image');

        if ($request->hasFile('cover_image')) {
            try {
                $path = $request->file('cover_image')->store('albums', 'public');
                $data['cover_image'] = $path;
                \Log::info('Album cover image uploaded successfully', ['path' => $path]);
            } catch (\Exception $e) {
                \Log::error('Album cover image upload failed', ['error' => $e->getMessage()]);
                return redirect()->back()
                    ->with('error', 'Error uploading image: ' . $e->getMessage())
                    ->withInput();
            }
        }

        Album::create($data);

        return redirect()->route('admin.albums.index')->with('success', 'Album created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $album = Album::with('galleryImages')->findOrFail($id);
        return view('admin.albums.show', compact('album'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $album = Album::findOrFail($id);
        return view('admin.albums.edit', compact('album'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $album = Album::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->except(['cover_image', '_token', '_method']);

        if ($request->hasFile('cover_image')) {
            try {
                // Delete the old image if it exists
                if ($album->cover_image) {
                    Storage::disk('public')->delete($album->cover_image);
                    \Log::info('Deleted old album cover image', ['path' => $album->cover_image]);
                }

                $path = $request->file('cover_image')->store('albums', 'public');
                $data['cover_image'] = $path;
                \Log::info('New album cover image uploaded', ['path' => $path]);
            } catch (\Exception $e) {
                \Log::error('Album cover image upload failed during update', ['error' => $e->getMessage()]);
                return redirect()->back()
                    ->with('error', 'Error uploading image: ' . $e->getMessage())
                    ->withInput();
            }
        }

        $album->update($data);

        return redirect()->route('admin.albums.index')->with('success', 'Album updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $album = Album::findOrFail($id);

        // Delete cover image if exists
        if ($album->cover_image) {
            Storage::disk('public')->delete($album->cover_image);
            \Log::info('Album image deleted: ' . $album->cover_image);
        }

        // Delete all associated gallery images
        foreach ($album->galleryImages as $image) {
            if ($image->image_path) {
                Storage::disk('public')->delete($image->image_path);
                \Log::info('Gallery image deleted: ' . $image->image_path);
            }
            $image->delete();
        }

        $album->delete();

        return redirect()->route('admin.albums.index')->with('success', 'Album deleted successfully');
    }
}

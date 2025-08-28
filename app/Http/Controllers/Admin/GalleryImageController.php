<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $albums = Album::with('galleryImages')->orderBy('sort_order')->get();
        return view('admin.gallery-images.index', compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $albums = Album::orderBy('name')->pluck('name', 'id');
        return view('admin.gallery-images.create', compact('albums'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'album_id' => 'required|exists:albums,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            try {
                $path = $request->file('image')->store('albums', 'public');
                $data['image_path'] = $path;
                \Log::info('Gallery image uploaded successfully', ['path' => $path]);
            } catch (\Exception $e) {
                \Log::error('Gallery image upload failed', ['error' => $e->getMessage()]);
                return redirect()->back()
                    ->with('error', 'Error uploading image: ' . $e->getMessage())
                    ->withInput();
            }
        }

        GalleryImage::create($data);

        return redirect()->route('admin.gallery-images.index')->with('success', 'Image added to gallery successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $image = GalleryImage::with('album')->findOrFail($id);
        return view('admin.gallery-images.show', compact('image'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $image = GalleryImage::findOrFail($id);
        $albums = Album::orderBy('name')->pluck('name', 'id');
        return view('admin.gallery-images.edit', compact('image', 'albums'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $image = GalleryImage::findOrFail($id);

        $request->validate([
            'album_id' => 'required|exists:albums,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['image', '_token', '_method']);

        if ($request->hasFile('image')) {
            try {
                // Delete the old image if it exists
                if ($image->image_path) {
                    Storage::disk('public')->delete($image->image_path);
                    \Log::info('Deleted old gallery image', ['path' => $image->image_path]);
                }

                $path = $request->file('image')->store('albums', 'public');
                $data['image_path'] = $path;
                \Log::info('New gallery image uploaded', ['path' => $path]);
            } catch (\Exception $e) {
                \Log::error('Gallery image upload failed during update', ['error' => $e->getMessage()]);
                return redirect()->back()
                    ->with('error', 'Error uploading image: ' . $e->getMessage())
                    ->withInput();
            }
        }

        $image->update($data);

        return redirect()->route('admin.gallery-images.index')->with('success', 'Gallery image updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $image = GalleryImage::findOrFail($id);

        // Delete image file if exists
        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
            \Log::info('Gallery image deleted: ' . $image->image_path);
        }

        $image->delete();

        return redirect()->route('admin.gallery-images.index')->with('success', 'Gallery image deleted successfully');
    }
}

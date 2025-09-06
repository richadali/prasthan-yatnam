<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class HeroImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heroImages = HeroImage::orderBy('created_at', 'desc')->get();
        $currentActive = HeroImage::getCurrentActive();

        return view('admin.hero-images.index', compact('heroImages', 'currentActive'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hero-images.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // 2MB max (matching PHP upload_max_filesize)
            'tag' => 'nullable|string|max:65535',
            'is_active' => 'boolean',
        ]);

        try {
            // Enhanced debug information
            Log::info('HeroImageController@store: Starting image upload process', [
                'request_all' => $request->all(),
                'has_file' => $request->hasFile('image'),
                'file_name' => $request->hasFile('image') ? $request->file('image')->getClientOriginalName() : 'No file',
                'file_size' => $request->hasFile('image') ? $request->file('image')->getSize() : 0,
                'file_mime' => $request->hasFile('image') ? $request->file('image')->getMimeType() : 'No mime',
                'is_active_checkbox' => $request->has('is_active'),
                'is_active_value' => $request->input('is_active')
            ]);

            // Handle image upload
            $imagePath = $request->file('image')->store('hero-images', 'public');
            Log::info('HeroImageController@store: Image stored at: ' . $imagePath);

            // Create hero image record
            $heroImage = new HeroImage();
            $heroImage->image_path = $imagePath;
            $heroImage->tag = $request->tag;
            $heroImage->is_active = $request->boolean('is_active');

            Log::info('HeroImageController@store: Before save', [
                'hero_image' => $heroImage->toArray()
            ]);

            $saveResult = $heroImage->save();

            Log::info('HeroImageController@store: After save', [
                'save_result' => $saveResult,
                'hero_image_id' => $heroImage->id,
                'hero_image' => $heroImage->fresh()->toArray()
            ]);

            // If this image is set as active, deactivate other images
            if ($heroImage->is_active) {
                $updateCount = HeroImage::where('id', '!=', $heroImage->id)
                    ->where('is_active', true)
                    ->update(['is_active' => false]);

                Log::info('HeroImageController@store: Deactivated other images', [
                    'update_count' => $updateCount
                ]);
            }

            return redirect()->route('admin.hero-images.index')
                ->with('success', 'Hero image uploaded successfully.');
        } catch (\Illuminate\Http\Exceptions\PostTooLargeException $e) {
            Log::error('File upload error - Post too large', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->with('error', 'The uploaded file is too large. Maximum allowed size is 2MB.')
                ->withInput();
        } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
            Log::error('File upload error - File not found', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->with('error', 'The uploaded file could not be found or accessed.')
                ->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('HeroImageController@store: Database query exception', [
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'Database error while saving hero image. Please check the logs.')
                ->withInput();
        } catch (\Exception $e) {
            Log::error('HeroImageController@store: General exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'Error uploading hero image: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $heroImage = HeroImage::findOrFail($id);
        return view('admin.hero-images.show', compact('heroImage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $heroImage = HeroImage::findOrFail($id);
        return view('admin.hero-images.edit', compact('heroImage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $heroImage = HeroImage::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // 2MB max (matching PHP upload_max_filesize)
            'tag' => 'nullable|string|max:65535',
            'is_active' => 'boolean',
        ]);

        try {
            // Handle image upload if a new image is provided
            if ($request->hasFile('image')) {
                // Delete the old image
                if ($heroImage->image_path) {
                    Storage::disk('public')->delete($heroImage->image_path);
                }

                // Store the new image
                $imagePath = $request->file('image')->store('hero-images', 'public');
                $heroImage->image_path = $imagePath;
            }

            // Update other fields
            $heroImage->tag = $request->tag;
            $heroImage->is_active = $request->boolean('is_active');
            $heroImage->save();

            // If this image is set as active, deactivate other images
            if ($heroImage->is_active) {
                HeroImage::where('id', '!=', $heroImage->id)
                    ->where('is_active', true)
                    ->update(['is_active' => false]);
            }

            return redirect()->route('admin.hero-images.index')
                ->with('success', 'Hero image updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating hero image: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Toggle the active status of a hero image.
     */
    public function toggleActive(string $id)
    {
        $heroImage = HeroImage::findOrFail($id);

        try {
            // Toggle the active status
            $heroImage->is_active = !$heroImage->is_active;
            $heroImage->save();

            // If this image is now active, deactivate other images
            if ($heroImage->is_active) {
                HeroImage::where('id', '!=', $heroImage->id)
                    ->where('is_active', true)
                    ->update(['is_active' => false]);
            }

            $status = $heroImage->is_active ? 'activated' : 'deactivated';
            return redirect()->route('admin.hero-images.index')
                ->with('success', "Hero image {$status} successfully.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating hero image status: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $heroImage = HeroImage::findOrFail($id);

        try {
            // Delete the image file
            if ($heroImage->image_path) {
                Storage::disk('public')->delete($heroImage->image_path);
            }

            // Delete the record
            $heroImage->delete();

            return redirect()->route('admin.hero-images.index')
                ->with('success', 'Hero image deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting hero image: ' . $e->getMessage());
        }
    }
}

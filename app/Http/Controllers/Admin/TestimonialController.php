<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::orderBy('display_order')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get the next available display order
        $nextDisplayOrder = Testimonial::max('display_order') + 1;

        return view('admin.testimonials.index', compact('testimonials', 'nextDisplayOrder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get the highest display_order value and add 1 for the next testimonial
        $nextDisplayOrder = Testimonial::max('display_order') + 1;

        return view('admin.testimonials.create', compact('nextDisplayOrder'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Log the incoming request
            \Log::info('Testimonial store request received', [
                'request_data' => $request->all()
            ]);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'designation' => 'required|string|max:255',
                'message' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active' => 'boolean',
                'display_order' => 'integer|min:0',
            ]);

            \Log::info('Testimonial validation passed');

            $data = $request->except('image');

            // Handle the image upload
            if ($request->hasFile('image')) {
                try {
                    $path = $request->file('image')->store('testimonials', 'public');
                    $data['image'] = $path;
                    \Log::info('Image uploaded successfully', ['path' => $path]);
                } catch (\Exception $e) {
                    \Log::error('Image upload failed', ['error' => $e->getMessage()]);
                    return redirect()->back()
                        ->with('error', 'Error uploading image: ' . $e->getMessage())
                        ->withInput();
                }
            }

            // Set is_active as a boolean (true/false)
            $data['is_active'] = $request->has('is_active') ? true : false;

            \Log::info('Creating testimonial with data', ['data' => $data]);

            // Create the testimonial using try/catch
            try {
                $testimonial = new Testimonial();
                $testimonial->name = $data['name'];
                $testimonial->designation = $data['designation'];
                $testimonial->message = $data['message'];
                if (isset($data['image'])) {
                    $testimonial->image = $data['image'];
                }
                $testimonial->is_active = $data['is_active'] ? true : false;
                $testimonial->display_order = $data['display_order'] ?? 0;
                $testimonial->save();

                \Log::info('Testimonial created successfully', ['id' => $testimonial->id]);

                return redirect()->route('admin.testimonials.index')
                    ->with('success', 'Testimonial created successfully.');
            } catch (\Exception $e) {
                \Log::error('Failed to create testimonial', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                return redirect()->back()
                    ->with('error', 'Error creating testimonial: ' . $e->getMessage())
                    ->withInput();
            }
        } catch (\Exception $e) {
            \Log::error('Unexpected error in testimonial store', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Unexpected error: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Debug: Log the incoming request data
            \Log::info('Testimonial update request received', [
                'id' => $id,
                'request_data' => $request->all()
            ]);

            $testimonial = Testimonial::findOrFail($id);
            \Log::info('Found testimonial', ['testimonial' => $testimonial->toArray()]);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'designation' => 'required|string|max:255',
                'message' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active' => 'boolean',
                'display_order' => 'integer|min:0',
            ]);

            \Log::info('Testimonial validation passed');

            $data = $request->except('image', '_token', '_method');

            // Handle the image upload
            if ($request->hasFile('image')) {
                try {
                    // Delete the old image if it exists
                    if ($testimonial->image) {
                        Storage::disk('public')->delete($testimonial->image);
                        \Log::info('Deleted old image', ['path' => $testimonial->image]);
                    }

                    $path = $request->file('image')->store('testimonials', 'public');
                    $data['image'] = $path;
                    \Log::info('New image uploaded', ['path' => $path]);
                } catch (\Exception $e) {
                    \Log::error('Image upload failed during update', ['error' => $e->getMessage()]);
                    return redirect()->back()
                        ->with('error', 'Error uploading image: ' . $e->getMessage())
                        ->withInput();
                }
            }

            // Set is_active as a boolean (true/false)
            $data['is_active'] = $request->has('is_active') ? true : false;

            // Debug: Log the data being updated
            \Log::info('Testimonial update data', [
                'id' => $id,
                'data' => $data
            ]);

            // Check if this is a quick reorder request (message is set to 'Unchanged')
            if (isset($data['message']) && $data['message'] === 'Unchanged') {
                // This is a quick reorder - only update the display_order field
                // and keep the existing message
                $data['message'] = $testimonial->message;
            }

            try {
                // Use direct property assignment instead of update()
                $testimonial->name = $data['name'];
                $testimonial->designation = $data['designation'];
                $testimonial->message = $data['message'];
                if (isset($data['image'])) {
                    $testimonial->image = $data['image'];
                }
                $testimonial->is_active = $data['is_active'] ? true : false;
                $testimonial->display_order = $data['display_order'] ?? 0;

                $result = $testimonial->save();

                // Debug: Log the result
                \Log::info('Testimonial update result', [
                    'id' => $id,
                    'success' => $result,
                    'testimonial_after' => $testimonial->fresh()->toArray()
                ]);

                return redirect()->route('admin.testimonials.index')
                    ->with('success', 'Testimonial updated successfully.');
            } catch (\Exception $e) {
                // Debug: Log any exceptions
                \Log::error('Testimonial update error', [
                    'id' => $id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                return redirect()->back()
                    ->with('error', 'Error updating testimonial: ' . $e->getMessage())
                    ->withInput();
            }
        } catch (\Exception $e) {
            \Log::error('Unexpected error in testimonial update', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Unexpected error: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // Delete the image if it exists
        if ($testimonial->image) {
            Storage::disk('public')->delete($testimonial->image);
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }
}

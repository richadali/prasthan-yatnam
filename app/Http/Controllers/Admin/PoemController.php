<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PoemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $poems = Poem::orderBy('display_order')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get the next available display order
        $nextDisplayOrder = Poem::max('display_order') + 1;

        return view('admin.poems.index', compact('poems', 'nextDisplayOrder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get the highest display_order value and add 1 for the next poem
        $nextDisplayOrder = Poem::max('display_order') + 1;

        return view('admin.poems.create', compact('nextDisplayOrder'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Log the incoming request
            \Log::info('Poem store request received', [
                'request_data' => $request->all()
            ]);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'display_order' => 'integer|min:0',
            ]);

            \Log::info('Poem validation passed');

            $data = $request->except('image');

            // Handle the image upload
            if ($request->hasFile('image')) {
                try {
                    $path = $request->file('image')->store('poems', 'public');
                    $data['image'] = $path;
                    \Log::info('Image uploaded successfully', ['path' => $path]);
                } catch (\Exception $e) {
                    \Log::error('Image upload failed', ['error' => $e->getMessage()]);
                    return redirect()->back()
                        ->with('error', 'Error uploading image: ' . $e->getMessage())
                        ->withInput();
                }
            }

            \Log::info('Creating poem with data', ['data' => $data]);

            // Create the poem using try/catch
            try {
                $poem = new Poem();
                $poem->title = $data['title'];
                $poem->image = $data['image'];
                $poem->display_order = $data['display_order'] ?? 0;
                $poem->save();

                \Log::info('Poem created successfully', ['id' => $poem->id]);

                return redirect()->route('admin.poems.index')
                    ->with('success', 'Poem created successfully.');
            } catch (\Exception $e) {
                \Log::error('Failed to create poem', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                return redirect()->back()
                    ->with('error', 'Error creating poem: ' . $e->getMessage())
                    ->withInput();
            }
        } catch (\Exception $e) {
            \Log::error('Unexpected error in poem store', [
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
        $poem = Poem::findOrFail($id);
        return view('admin.poems.edit', compact('poem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Debug: Log the incoming request data
            \Log::info('Poem update request received', [
                'id' => $id,
                'request_data' => $request->all()
            ]);

            $poem = Poem::findOrFail($id);
            \Log::info('Found poem', ['poem' => $poem->toArray()]);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'display_order' => 'integer|min:0',
            ]);

            \Log::info('Poem validation passed');

            $data = $request->except('image', '_token', '_method');

            // Handle the image upload
            if ($request->hasFile('image')) {
                try {
                    // Delete the old image if it exists
                    if ($poem->image) {
                        Storage::disk('public')->delete($poem->image);
                        \Log::info('Deleted old image', ['path' => $poem->image]);
                    }

                    $path = $request->file('image')->store('poems', 'public');
                    $data['image'] = $path;
                    \Log::info('New image uploaded', ['path' => $path]);
                } catch (\Exception $e) {
                    \Log::error('Image upload failed during update', ['error' => $e->getMessage()]);
                    return redirect()->back()
                        ->with('error', 'Error uploading image: ' . $e->getMessage())
                        ->withInput();
                }
            }

            // Debug: Log the data being updated
            \Log::info('Poem update data', [
                'id' => $id,
                'data' => $data
            ]);

            try {
                // Use direct property assignment
                $poem->title = $data['title'];
                if (isset($data['image'])) {
                    $poem->image = $data['image'];
                }
                $poem->display_order = $data['display_order'] ?? 0;

                $result = $poem->save();

                // Debug: Log the result
                \Log::info('Poem update result', [
                    'id' => $id,
                    'success' => $result,
                    'poem_after' => $poem->fresh()->toArray()
                ]);

                return redirect()->route('admin.poems.index')
                    ->with('success', 'Poem updated successfully.');
            } catch (\Exception $e) {
                // Debug: Log any exceptions
                \Log::error('Poem update error', [
                    'id' => $id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                return redirect()->back()
                    ->with('error', 'Error updating poem: ' . $e->getMessage())
                    ->withInput();
            }
        } catch (\Exception $e) {
            \Log::error('Unexpected error in poem update', [
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
        $poem = Poem::findOrFail($id);

        // Delete the image if it exists
        if ($poem->image) {
            Storage::disk('public')->delete($poem->image);
        }

        $poem->delete();

        return redirect()->route('admin.poems.index')
            ->with('success', 'Poem deleted successfully.');
    }
}

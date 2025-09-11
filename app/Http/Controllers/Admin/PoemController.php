<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
            Log::info('Poem store request received', [
                'request_data' => $request->all()
            ]);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'file' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
                'display_order' => 'integer|min:0',
            ]);

            Log::info('Poem validation passed');

            $data = $request->except('file');

            // Handle the file upload
            if ($request->hasFile('file')) {
                try {
                    $file = $request->file('file');
                    $path = $file->store('poems', 'public');
                    $data['file_path'] = $path;
                    $data['file_type'] = $file->getMimeType();
                    Log::info('File uploaded successfully', ['path' => $path]);
                } catch (\Exception $e) {
                    Log::error('File upload failed', ['error' => $e->getMessage()]);
                    return redirect()->back()
                        ->with('error', 'Error uploading file: ' . $e->getMessage())
                        ->withInput();
                }
            }

            Log::info('Creating poem with data', ['data' => $data]);

            // Create the poem using try/catch
            try {
                $poem = new Poem();
                $poem->title = $data['title'];
                $poem->file_path = $data['file_path'];
                $poem->file_type = $data['file_type'];
                $poem->display_order = $data['display_order'] ?? 0;
                $poem->save();

                Log::info('Poem created successfully', ['id' => $poem->id]);

                return redirect()->route('admin.poems.index')
                    ->with('success', 'Poem created successfully.');
            } catch (\Exception $e) {
                Log::error('Failed to create poem', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                return redirect()->back()
                    ->with('error', 'Error creating poem: ' . $e->getMessage())
                    ->withInput();
            }
        } catch (\Exception $e) {
            Log::error('Unexpected error in poem store', [
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
            Log::info('Poem update request received', [
                'id' => $id,
                'request_data' => $request->all()
            ]);

            $poem = Poem::findOrFail($id);
            Log::info('Found poem', ['poem' => $poem->toArray()]);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
                'display_order' => 'integer|min:0',
            ]);

            Log::info('Poem validation passed');

            $data = $request->except('file', '_token', '_method');

            // Handle the file upload
            if ($request->hasFile('file')) {
                try {
                    // Delete the old file if it exists
                    if ($poem->file_path) {
                        Storage::disk('public')->delete($poem->file_path);
                        Log::info('Deleted old file', ['path' => $poem->file_path]);
                    }

                    $file = $request->file('file');
                    $path = $file->store('poems', 'public');
                    $data['file_path'] = $path;
                    $data['file_type'] = $file->getMimeType();
                    Log::info('New file uploaded', ['path' => $path]);
                } catch (\Exception $e) {
                    Log::error('File upload failed during update', ['error' => $e->getMessage()]);
                    return redirect()->back()
                        ->with('error', 'Error uploading file: ' . $e->getMessage())
                        ->withInput();
                }
            }

            // Debug: Log the data being updated
            Log::info('Poem update data', [
                'id' => $id,
                'data' => $data
            ]);

            try {
                // Use direct property assignment
                $poem->title = $data['title'];
                if (isset($data['file_path'])) {
                    $poem->file_path = $data['file_path'];
                    $poem->file_type = $data['file_type'];
                }
                $poem->display_order = $data['display_order'] ?? 0;

                $result = $poem->save();

                // Debug: Log the result
                Log::info('Poem update result', [
                    'id' => $id,
                    'success' => $result,
                    'poem_after' => $poem->fresh()->toArray()
                ]);

                return redirect()->route('admin.poems.index')
                    ->with('success', 'Poem updated successfully.');
            } catch (\Exception $e) {
                // Debug: Log any exceptions
                Log::error('Poem update error', [
                    'id' => $id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                return redirect()->back()
                    ->with('error', 'Error updating poem: ' . $e->getMessage())
                    ->withInput();
            }
        } catch (\Exception $e) {
            Log::error('Unexpected error in poem update', [
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
        if ($poem->file_path) {
            Storage::disk('public')->delete($poem->file_path);
        }

        $poem->delete();

        return redirect()->route('admin.poems.index')
            ->with('success', 'Poem deleted successfully.');
    }
}

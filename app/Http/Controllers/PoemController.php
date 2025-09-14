<?php

namespace App\Http\Controllers;

use App\Models\Poem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PoemController extends Controller
{
    /**
     * Display a listing of the poems.
     */
    public function index()
    {
        $poems = Poem::orderBy('display_order')->orderBy('created_at', 'desc')->get();
        return view('poems.index', compact('poems'));
    }

    /**
     * Display the specified poem.
     */
    public function show($id)
    {
        $poem = Poem::findOrFail($id);
        return view('poems.show', compact('poem'));
    }

    /**
     * Handle the download of the poem file.
     */
    public function download($id)
    {
        $poem = Poem::findOrFail($id);

        // Make sure the file exists
        if (!Storage::disk('public')->exists($poem->file_path)) {
            abort(404);
        }

        // Sanitize the title to create a valid filename
        $filename = Str::slug($poem->title) . '.' . pathinfo($poem->file_path, PATHINFO_EXTENSION);

        return Storage::disk('public')->download($poem->file_path, $filename);
    }
}

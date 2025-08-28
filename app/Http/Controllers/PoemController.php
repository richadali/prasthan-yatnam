<?php

namespace App\Http\Controllers;

use App\Models\Poem;
use Illuminate\Http\Request;

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
}

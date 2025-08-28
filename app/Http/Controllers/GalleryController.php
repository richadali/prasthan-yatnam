<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\GalleryImage;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the albums.
     */
    public function index()
    {
        $albums = Album::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('gallery.index', compact('albums'));
    }

    /**
     * Display the specified album with its images.
     */
    public function show($id)
    {
        $album = Album::where('is_active', true)
            ->with('galleryImages')
            ->findOrFail($id);

        return view('gallery.show', compact('album'));
    }
}

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
        $discourses = Discourse::orderBy('created_at', 'desc')->paginate(10);
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
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'price' => 'required|numeric|min:0',
            'slug' => 'nullable|string|max:255|unique:discourses,slug',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('public/images/discourses');
            $validated['thumbnail'] = basename($thumbnailPath);
        }

        // Set boolean fields
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        Discourse::create($validated);

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
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'price' => 'required|numeric|min:0',
            'slug' => 'nullable|string|max:255|unique:discourses,slug,' . $discourse->id,
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($discourse->thumbnail) {
                Storage::delete('public/images/discourses/' . $discourse->thumbnail);
            }

            $thumbnailPath = $request->file('thumbnail')->store('public/images/discourses');
            $validated['thumbnail'] = basename($thumbnailPath);
        }

        // Set boolean fields
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        $discourse->update($validated);

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
            Storage::delete('public/images/discourses/' . $discourse->thumbnail);
        }

        $discourse->delete();

        return redirect()->route('admin.discourses.index')
            ->with('success', 'Discourse deleted successfully.');
    }
}

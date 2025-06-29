<?php

namespace App\Http\Controllers;

use App\Models\Discourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscourseController extends Controller
{
    /**
     * Display a listing of all discourses.
     */
    public function index()
    {
        $activeDiscourses = Discourse::where('is_active', true)
            ->where('is_upcoming', false)
            ->orderBy('created_at', 'desc')
            ->get();

        $upcomingDiscourses = Discourse::where('is_active', true)
            ->where('is_upcoming', true)
            ->orderBy('expected_release_date')
            ->get();

        return view('discourses.index', compact('activeDiscourses', 'upcomingDiscourses'));
    }

    /**
     * Display the specified discourse.
     */
    public function show($slug)
    {
        $discourse = Discourse::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Check if user is enrolled
        $hasAccess = false;
        $freePreviewVideos = [];
        $isUpcoming = $discourse->is_upcoming;

        if (Auth::check()) {
            $user = Auth::user();
            $hasAccess = $user->enrolledDiscourses()
                ->where('discourse_id', $discourse->id)
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>', now());
                })
                ->exists();
        }

        // Since we removed free preview functionality, set empty array
        $freePreviewVideos = [];

        return view('discourses.show', compact('discourse', 'hasAccess', 'freePreviewVideos', 'isUpcoming'));
    }

    /**
     * Enroll the user in a discourse.
     */
    public function enroll($slug)
    {
        $discourse = Discourse::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Don't allow enrollment for upcoming discourses
        if ($discourse->is_upcoming) {
            return redirect()->route('discourses.show', $slug)
                ->with('error', 'This discourse is not yet available for enrollment. Please check back later.');
        }

        $user = Auth::user();

        // Check if user is already enrolled
        if ($user->enrolledDiscourses()->where('discourse_id', $discourse->id)->exists()) {
            return redirect()->route('discourses.show', $slug)
                ->with('info', 'You are already enrolled in this course.');
        }

        // Enroll the user
        $user->enrolledDiscourses()->attach($discourse->id, [
            'enrolled_at' => now(),
            'payment_status' => $discourse->price > 0 ? 'pending' : 'free',
            'amount_paid' => 0,
        ]);

        return redirect()->route('discourses.my')
            ->with('success', 'You have successfully enrolled in ' . $discourse->title);
    }

    /**
     * Display the user's enrolled discourses.
     * This method is protected by auth middleware in routes/web.php
     */
    public function myDiscourses()
    {
        $user = Auth::user();
        $enrolledDiscourses = $user->enrolledDiscourses()
            ->with('videos')
            ->get();

        return view('discourses.my-discourses', compact('enrolledDiscourses'));
    }
}

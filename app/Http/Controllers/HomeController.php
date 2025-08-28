<?php

namespace App\Http\Controllers;

use App\Models\Discourse;
use App\Models\HeroImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application home page.
     */
    public function index()
    {
        // Get the current active hero image
        $heroImage = HeroImage::getCurrentActive();


        // Get 3 active discourses
        $activeDiscourses = Discourse::where('is_active', true)
            ->where('is_upcoming', false)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Get upcoming discourses
        $upcomingDiscourses = Discourse::where('is_active', true)
            ->where('is_upcoming', true)
            ->orderBy('expected_release_date')
            ->take(3)
            ->get();

        // Merge both collections to ensure we have 3 discourses total
        if ($activeDiscourses->count() < 3) {
            $neededCount = 3 - $activeDiscourses->count();
            $additionalUpcoming = $upcomingDiscourses->take($neededCount);
            $featuredDiscourses = $activeDiscourses->merge($additionalUpcoming);
        } else {
            $featuredDiscourses = $activeDiscourses->take(3);
        }

        return view('home', compact('featuredDiscourses', 'upcomingDiscourses', 'heroImage'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display the testimonials page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('display_order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('testimonials.index', compact('testimonials'));
    }
}

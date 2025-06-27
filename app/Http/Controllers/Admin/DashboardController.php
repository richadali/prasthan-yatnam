<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discourse;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Admin middleware will be applied in routes file
    }

    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_discourses' => Discourse::count(),
            'active_discourses' => Discourse::where('is_active', true)->count(),
            'upcoming_discourses' => Discourse::where('is_active', true)->where('is_upcoming', true)->count(),
            'total_users' => User::count(),
        ];

        $latest_discourses = Discourse::latest()->take(5)->get();
        $latest_users = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latest_discourses', 'latest_users'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Discourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of all enrollments.
     */
    public function index(Request $request)
    {
        $query = DB::table('user_discourses')
            ->join('users', 'user_discourses.user_id', '=', 'users.id')
            ->join('discourses', 'user_discourses.discourse_id', '=', 'discourses.id')
            ->select(
                'user_discourses.id',
                'users.id as user_id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'discourses.id as discourse_id',
                'discourses.title as discourse_title',
                'user_discourses.enrolled_at',
                'user_discourses.expires_at',
                'user_discourses.payment_status',
                'user_discourses.amount_paid'
            );

        // Filter by discourse if provided
        if ($request->has('discourse_id')) {
            $query->where('discourses.id', $request->discourse_id);
        }

        // Filter by user if provided
        if ($request->has('user_id')) {
            $query->where('users.id', $request->user_id);
        }

        // Filter by payment status if provided
        if ($request->has('payment_status')) {
            $query->where('user_discourses.payment_status', $request->payment_status);
        }

        // Sort by enrolled_at date by default (newest first)
        $enrollments = $query->orderBy('user_discourses.enrolled_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Get all discourses for the filter dropdown
        $discourses = Discourse::orderBy('title')->get(['id', 'title']);

        return view('admin.enrollments.index', compact('enrollments', 'discourses'));
    }

    /**
     * Display details of a specific enrollment.
     */
    public function show($id)
    {
        $enrollment = DB::table('user_discourses')
            ->join('users', 'user_discourses.user_id', '=', 'users.id')
            ->join('discourses', 'user_discourses.discourse_id', '=', 'discourses.id')
            ->select(
                'user_discourses.*',
                'users.id as user_id',
                'users.first_name',
                'users.last_name',
                'users.email',
                'users.phone',
                'users.country_code',
                'users.organization',
                'discourses.id as discourse_id',
                'discourses.title as discourse_title',
                'discourses.price as discourse_price'
            )
            ->where('user_discourses.id', $id)
            ->first();

        if (!$enrollment) {
            return redirect()->route('admin.enrollments.index')
                ->with('error', 'Enrollment not found.');
        }

        return view('admin.enrollments.show', compact('enrollment'));
    }

    /**
     * Update enrollment payment status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,completed,failed,refunded'
        ]);

        DB::table('user_discourses')
            ->where('id', $id)
            ->update([
                'payment_status' => $request->payment_status,
                'updated_at' => now()
            ]);

        return redirect()->route('admin.enrollments.show', $id)
            ->with('success', 'Enrollment status updated successfully.');
    }
}

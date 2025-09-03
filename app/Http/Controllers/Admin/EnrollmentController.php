<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discourse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of enrollments.
     */
    public function index(Request $request)
    {
        $query = DB::table('user_discourses')
            ->join('users', 'user_discourses.user_id', '=', 'users.id')
            ->join('discourses', 'user_discourses.discourse_id', '=', 'discourses.id')
            ->select(
                'user_discourses.*',
                'users.name as user_name',
                'users.email as user_email',
                'discourses.title as discourse_title'
            );

        // Filter by status if provided
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('user_discourses.payment_status', $request->status);
        }

        // Filter by discourse if provided
        if ($request->has('discourse_id') && $request->discourse_id) {
            $query->where('user_discourses.discourse_id', $request->discourse_id);
        }

        $enrollments = $query->orderBy('user_discourses.created_at', 'desc')
            ->paginate(15)
            ->appends($request->query());

        $discourses = Discourse::orderBy('title')->get();

        return view('admin.enrollments.index', compact('enrollments', 'discourses'));
    }

    /**
     * Display the specified enrollment.
     */
    public function show($id)
    {
        $enrollment = DB::table('user_discourses')
            ->join('users', 'user_discourses.user_id', '=', 'users.id')
            ->join('discourses', 'user_discourses.discourse_id', '=', 'discourses.id')
            ->select(
                'user_discourses.*',
                'users.name as user_name',
                'users.email as user_email',
                'discourses.title as discourse_title',
                'discourses.price as discourse_price'
            )
            ->where('user_discourses.id', $id)
            ->first();

        if (!$enrollment) {
            abort(404);
        }

        return view('admin.enrollments.show', compact('enrollment'));
    }

    /**
     * Update the enrollment status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,completed,failed,refunded',
        ]);

        DB::table('user_discourses')
            ->where('id', $id)
            ->update([
                'payment_status' => $request->payment_status,
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.enrollments.show', $id)
            ->with('success', 'Enrollment status updated successfully.');
    }
}

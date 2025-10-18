<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollegeAdminController extends Controller
{
    /**
     * Display a list of pending students for the admin's college.
     */
    public function listPendingStudents()
{
    // Get the currently logged-in college admin
    $collegeAdmin = Auth::user();
    $adminCollegeId = $collegeAdmin->college_id;

    // --- TEMPORARY DEBUGGING ---
    // This will stop the code and show us exactly what we're looking for.
    // Uncomment the line below if the list is still empty after the fix.
    // dd('Searching for students with college_id = ' . $adminCollegeId . ' and is_approved = false');
    // ---------------------------

    // Find all users who are students, belong to this admin's college, and are not yet approved.
    $pendingStudents = User::where('role', 'student')
                            ->where('college_id', $adminCollegeId)
                            ->where('is_approved', false)
                            ->orderBy('created_at')
                            ->paginate(10);

    return view('college.students.pending', compact('pendingStudents'));
}

    /**
     * Approve a pending student.
     */
    public function approveStudent(Request $request, User $user)
    {
        // Security Check: Ensure the student being approved belongs to the admin's college.
        if ($user->college_id !== Auth::user()->college_id) {
            abort(403, 'UNAUTHORIZED ACTION.');
        }

        $user->update(['is_approved' => true]);

        // Optional: Send a notification email to the student
        // Mail::to($user->email)->send(new YourAccountHasBeenApproved($user));

        return redirect()->route('college.students.pending')->with('success', $user->name . ' has been approved.');
    }
    /**
     * Reject a pending student.
     */
    public function rejectStudent(Request $request, User $user)
    {
        // Security Check: Ensure the student being rejected belongs to the admin's college.
        if ($user->college_id !== Auth::user()->college_id) {
            abort(403, 'UNAUTHORIZED ACTION.');
        }

        // Optionally, you can delete the user or just mark them as rejected
        $user->delete();

        return redirect()->route('college.students.pending')->with('success', $user->name . ' has been rejected and removed from the pending list.');
    }
}
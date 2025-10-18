<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Use a simple if/else if structure for clarity
        if ($user->role === 'super_admin') {
            return view('superadmin.dashboard');

        } else if ($user->role === 'college_admin') {
            return view('college.dashboard');

        } else if ($user->role === 'reviewer') {
            // Prepare the data for the reviewer's dashboard
            $assignedSubmissions = Submission::where('reviewer_id', $user->id)
                ->where('status', 'Under Review')
                ->with('student.college')
                ->latest()
                ->get();
            
            // Pass the data to the correct view
            return view('reviewer.dashboard', ['assignedSubmissions' => $assignedSubmissions]);

        } else if ($user->role === 'student') {
            if (!$user->is_approved) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/login')->with('status', 'Your account is pending approval.');
            }
            // Prepare student's data
            $submissions = $user->submissions()->latest()->get();
            return view('student.dashboard', ['submissions' => $submissions]);

        } else {
            // A final fallback just in case
            return view('dashboard');
        }
    }
}
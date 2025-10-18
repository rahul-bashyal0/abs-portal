<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\User;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    // --- COLLEGE (INSTITUTE) MANAGEMENT ---
    public function listColleges()
    {
        $colleges = College::orderBy('name')->paginate(10);
        return view('superadmin.institutes.index', compact('colleges'));
    }

    public function createInstitute()
    {
        return view('superadmin.institutes.create');
    }

    public function storeInstitute(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|max:255|unique:colleges', 'city' => 'required|string|max:255', 'state' => 'required|string|max:255']);
        College::create($validated);
        return redirect()->route('superadmin.colleges.index')->with('success', 'Institute created successfully.');
    }

    public function editInstitute(College $institute)
    {
        return view('superadmin.institutes.edit', compact('institute'));
    }

    public function updateInstitute(Request $request, College $institute)
    {
        $validated = $request->validate(['name' => 'required|string|max:255|unique:colleges,name,' . $institute->id, 'city' => 'required|string|max:255', 'state' => 'required|string|max:255']);
        $institute->update($validated);
        return redirect()->route('superadmin.colleges.index')->with('success', 'Institute updated successfully.');
    }

    public function destroyInstitute(College $institute)
    {
        $institute->delete();
        return redirect()->route('superadmin.colleges.index')->with('success', 'Institute deleted successfully.');
    }

    // --- USER MANAGEMENT ---
    public function listUsers()
    {
        $users = User::where('role', '!=', 'super_admin')->with('college')->orderBy('name')->paginate(10);
        return view('superadmin.users.index', compact('users'));
    }

    public function createUser()
    {
        $colleges = College::where('name', '!=', 'ABS Soft Pvt. Ltd')->orderBy('name')->get();
        return view('superadmin.users.create', compact('colleges'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([ 'name' => 'required|string|max:255', 'email' => 'required|string|email|max:255|unique:users', 'password' => 'required|string|min:8|confirmed', 'role' => 'required|string|in:college_admin,reviewer', 'college_id' => 'nullable|required_if:role,college_admin|exists:colleges,id']);
        
        $collegeId = null;
        if ($validated['role'] === 'reviewer') {
            // THE FIX: Find the ABS Soft institute and get its ID.
            $absCollege = College::where('name', 'ABS Soft Pvt. Ltd')->first();
            // This will only assign if the institute actually exists.
            if ($absCollege) {
                $collegeId = $absCollege->id;
            }
        } else {
            $collegeId = $validated['college_id'];
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'college_id' => $collegeId, // Use the determined ID
            'is_approved' => true,
            'email_verified_at' => now(),
        ]);
        return redirect()->route('superadmin.users.index')->with('success', 'User created successfully.');
    }

    public function editUser(User $user)
    {
        $colleges = College::where('name', '!=', 'ABS Soft Pvt. Ltd')->orderBy('name')->get();
        return view('superadmin.users.edit', compact('user', 'colleges'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([ 'name' => 'required|string|max:255', 'email' => 'required|string|email|max:255|unique:users,email,' . $user->id, 'password' => 'nullable|string|min:8|confirmed', 'role' => 'required|string|in:college_admin,reviewer', 'college_id' => 'nullable|required_if:role,college_admin|exists:colleges,id']);
        
        $user->name = $validated['name']; $user->email = $validated['email']; $user->role = $validated['role'];
        
        if ($validated['role'] === 'reviewer') {
            $absCollege = College::where('name', 'ABS Soft Pvt. Ltd')->first();
            if ($absCollege) { $user->college_id = $absCollege->id; }
        } else {
            $user->college_id = $validated['college_id'];
        }

        if (!empty($validated['password'])) { $user->password = Hash::make($validated['password']); }
        $user->save();
        return redirect()->route('superadmin.users.index')->with('success', 'User updated successfully.');
    }
    
    public function destroyUser(User $user){ $user->delete(); return redirect()->route('superadmin.users.index')->with('success', 'User deleted successfully.'); }

    // --- SUBMISSION MANAGEMENT ---
    public function listSubmissions()
    {
        $submissions = Submission::with('student.college', 'reviewer')->latest()->paginate(10);
        $reviewers = User::where('role', 'reviewer')->orderBy('name')->get();
        return view('superadmin.submissions.index', compact('submissions', 'reviewers'));
    }
    
    public function assignReviewer(Request $request, Submission $submission)
    {
        $validated = $request->validate(['reviewer_id' => 'required|exists:users,id']);
        $reviewer = User::find($validated['reviewer_id']);
        if ($reviewer->role !== 'reviewer') { return back()->with('error', 'The selected user is not a reviewer.'); }
        $submission->update(['reviewer_id' => $validated['reviewer_id'], 'status' => 'Under Review']);
        return redirect()->route('superadmin.submissions.index')->with('success', 'Reviewer assigned successfully.');
    }
}
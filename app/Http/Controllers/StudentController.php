<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Show the form for creating a new project submission.
     */
    public function createSubmission()
    {
        return view('student.submissions.create');
    }

    /**
     * Store a newly created project submission in storage.
     */
    public function storeSubmission(Request $request)
    {
        // 1. Validate the incoming data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'problem_statement' => 'required|string|min:50',
            'solution_description' => 'required|string|min:100',
            'technologies_used' => 'required|string|max:255',
            'video_link' => 'nullable|url:http,https',
            'file' => 'nullable|file|mimes:pdf,zip,doc,docx|max:10240', // 10MB max
        ]);

        $filePath = null;

        // 2. Handle the file upload if it exists
        if ($request->hasFile('file')) {
            // Store the file in 'storage/app/public/submissions'
            // The 'public' disk is specified in config/filesystems.php
            $filePath = $request->file('file')->store('submissions', 'public');
        }

        // 3. Create the submission and associate it with the logged-in user
        Auth::user()->submissions()->create([
            'title' => $validated['title'],
            'problem_statement' => $validated['problem_statement'],
            'solution_description' => $validated['solution_description'],
            'technologies_used' => $validated['technologies_used'],
            'video_link' => $validated['video_link'],
            'file_path' => $filePath,
            'status' => 'Submitted', // Set the initial status
        ]);

        // 4. Redirect the user back to their dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Your project idea has been submitted successfully!');
    }
}